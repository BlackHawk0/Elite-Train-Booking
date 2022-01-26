<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Schedule;
use App\Station;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BookTrainController extends Controller
{
    /// called when user checks for train availability
    public function findSchedule(Request $request)
    {
        $request->validate([
            'from' => 'required',
            'to' => 'required|different:from',
            'travel_date' => 'required',
            'passengers' => 'required|max:10|min:1',
        ]);

        $available_schedules = Schedule::where([['from_id', $request->from], ['to_id', $request->to]])->get();

        $from_station = Station::find($request->from);
        $to_station = Station::find($request->to);

        return redirect()->route('search.results')->with('data', ['schedules' => compact('available_schedules'), 'travel_date' => $request->travel_date, 'from' => $from_station, 'to' => $to_station, 'passengers' => $request->passengers]);
    }

    public function searchResults(Request $request)
    {
        $request->session()->reflash();
        return view('search_results');
    }

    // check train availability
    public static function trainAvailable($travel_date, $passengers, $train_capacity, $departure_time)
    {
        $bookings = Booking::where('payment_status', 1)->where('travel_date', $travel_date)
            ->where('departure_time', $departure_time)
            ->get();
        $passengers_booked = 0;
        foreach ($bookings as $booking) {
            $passengers_booked += $booking->passengers;
        }
        if (($passengers_booked + $passengers) > $train_capacity) {
            return false;
        }
        return true;
    }

    public function bookTrain(Request $request)
    {
        $passengers_count = $request->passengers;
        $schedule_id = $request->schedule;
        $travel_date = $request->travel_date;

        $schedule = Schedule::find($request->schedule);

        $train_capacity = $schedule->train->capacity;
        $departure_time = $schedule->departure_time;
        $arrival_time = $schedule->arrival_time;
        $fare = $schedule->cost;

        if (!self::trainAvailable($travel_date, $passengers_count, $train_capacity, $departure_time)) {
            return view('book.full');
        }

        $booking = Booking::create([
            'booking_code' => Str::random(10),
            'travel_date' => $travel_date,
            'departure_time' => $departure_time,
            'arrival_time' => $arrival_time,
            'from' => $schedule->from,
            'to' => $schedule->to,
            'passengers' => $passengers_count,

            'fare' => $fare,
            'total_fare' => $fare * $passengers_count,
        ]);

        return view('book.book_train', compact('schedule', 'booking'));
    }

    public function bookings()
    {
        $bookings = Booking::where('travel_date', '>=', date('Y-m-d'))->get();
        return view('admin.bookings', compact('bookings'));
    }
}
