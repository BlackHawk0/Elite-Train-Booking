<?php

namespace App\Http\Controllers;

use App\Booking;
use App\BookingPayment;
use App\BookingPaymentTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class MpesaRentPaymentController extends Controller
{
    protected $mpesa;
    protected $transactionType;
    protected $businessShortCode;
    protected $lipaNaMpesaPasskey;
    protected $partyB;
    protected $callBackURL;
    protected $accountReference;
    protected $transactionDesc;
    protected $remarks;

    public function __construct()
    {
        $this->mpesa = new \Safaricom\Mpesa\Mpesa();
        $this->transactionType = 'CustomerPayBillOnline';
        $this->businessShortCode = 174379;
        $this->lipaNaMpesaPasskey = 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';
        $this->partyB = 174379;
        $this->callBackURL = route('payment.callback');
        $this->accountReference = 'Train Booking';
        $this->transactionDesc = 'Train Booking Payment';
        $this->remarks = 'Train Booking payment';
    }

    public function initiatePayment(Request $request)
    {
        $request->validate([
            'phone' => 'required',
        ]);

        $phone = $request->phone;
        $amount = $request->fare;
        session(['bookingId' => $request->booking_id]);

        // format number
        $phone = (substr($phone, 0, 1) == "+") ? str_replace("+", "", $phone) : $phone;
        $phone = (substr($phone, 0, 1) == "0") ? preg_replace("/^0/", "254", $phone) : $phone;
        $phone = (substr($phone, 0, 1) == "7") ? "254{$phone}" : $phone;

        session('phone', $phone);

        $stkResponse = $this->makePayment($phone, $amount);
        return $this->paymentResponse($stkResponse);
    }

    public function stkPushStatus(Request $request)
    {
        $checkoutId = $request->session()->get('checkoutId');
        $businessShortCode = $this->businessShortCode;
        $timestamp = date("YmdHis");
        $password = base64_encode($businessShortCode . $this->lipaNaMpesaPasskey . $timestamp);

        // leaves out environment (Handled inside the function on sdk)
        $stkRequestStatus = $this->mpesa->STKPushQuery('', $checkoutId, $businessShortCode, $password, $timestamp);
        return $this->stkPushQueryResponse($stkRequestStatus);
    }

    public function orderComplete()
    {
        return view('mpesa.order.complete');
    }

    public function orderFail()
    {
        return view('mpesa.order.fail');
    }

    public function stkPushQueryResponse($responseJson)
    {
        $data = json_decode($responseJson, true);
        if (Arr::exists($data, 'errorCode') && $data['errorCode'] == '500.001.1001') {
            return redirect()->route('mpesa.order.fail')->with('error', $data['errorMessage']);
        }

        if ($data['ResultCode'] == 1032) {
            // transactions cancelled
            return redirect()->route('mpesa.order.fail')->with('error', 'Transaction cancelled');
        }

        if ($data['ResultCode'] == 0) {
            // payment confirmed.
            // record this payment

            // set transaction id
            $transaction = BookingPaymentTransaction::where('checkout_request_id', session('checkoutId'))->get();
            $transaction_id = $transaction->first()->id;

            BookingPayment::create([
                'booking_id' => session('bookingId'),
                'checkout_id' => session('checkoutId'),
                'transaction_id' => $transaction_id,
            ]);

            // update booking was paid availability
            $booking = Booking::find(session('bookingId'));
            $booking->payment_status = 1; // mark as paid

            $booking->phone = session('phone');

            $booking->save();

            // redirect to order completion page.
            return redirect()->route('mpesa.order.complete')->with('transaction', $transaction_id);
        }
    }

    public function paymentStatus($status)
    {
        return view('mpesa.payment.status', ['status' => $status]);

    }

    public function paymentResponse($responseJson)
    {
        // response after stk push is initiated.
        $data = json_decode($responseJson, true);

        //stk push error
        if (Arr::exists($data, 'errorCode')) {
            return redirect()->route('mpesa.payment.status', 'stk_push_error')->with('stk_push_error', 'Could not process the request. Check mpesa number before submission');
        }

        if ($data['ResponseCode'] != 0) {
            // mpesa push failed.
            return redirect()->route('mpesa.payment.status', 'fail')->with('fail', $data['ResponseDescription']);
        }
        // stk push was a success
        $checkoutRequestId = $data['CheckoutRequestID'];
        session(['checkoutId' => $checkoutRequestId]);

        return redirect()->route('mpesa.payment.status', 'success')->with('success', $data['CustomerMessage']);

    }

    public function paymentCallback()
    {
        // response from mpesa callback.
        $result = $this->mpesa->getDataFromCallback();

        $data = json_decode($result, true);

        if ($data['Body']['stkCallback']['ResultCode'] == 0) {

            $merchant_request_id = $data['Body']['stkCallback']['MerchantRequestID'];
            $checkout_request_id = $data['Body']['stkCallback']['CheckoutRequestID'];
            $receipt_number = $data['Body']['stkCallback']['CallbackMetadata']['Item'][1]['Value'];
            $transactionDate = $data['Body']['stkCallback']['CallbackMetadata']['Item'][3]['Value'];
            $phone_number = $data['Body']['stkCallback']['CallbackMetadata']['Item'][4]['Value'];
            $amount = $data['Body']['stkCallback']['CallbackMetadata']['Item'][0]['Value'];

            BookingPaymentTransaction::create([
                'merchant_request_id' => $merchant_request_id,
                'checkout_request_id' => $checkout_request_id,
                'receipt_number' => $receipt_number,
                'transaction_date' => $transactionDate,
                'phone_number' => $phone_number,
                'amount' => $amount,
            ]);

            $this->mpesa->finishTransaction();

        } else {
            $this->mpesa->finishTransaction(false);
        }
    }

    public function makePayment($mobile, $amount)
    {

        $mpesaNumber = $mobile;

        $total = $amount;

        if (env('MPESA_ENV') == 'sandbox') {
            $total = 1;
        }

        $stkPushSimulation = $this->mpesa->STKPushSimulation(
            $this->businessShortCode,
            $this->lipaNaMpesaPasskey,
            $this->transactionType,
            $total,
            $mpesaNumber,
            $this->partyB,
            $mpesaNumber,
            $this->callBackURL,
            $this->accountReference,
            $this->transactionDesc,
            $this->remarks
        );
        return $stkPushSimulation;
    }
}
