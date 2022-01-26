@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center flex-column vh-100">
  @switch($status)
  @case('error')
  <i class="fas fa-times-circle text-danger fa-10x"></i>
  <h3 class="py-5">Something went wrong.</h3>
  <a class="btn btn-info" href="{{ url()->previous() }}">Go back</a>
  @break
  @case('fail')
  <i class="fas fa-times-circle text-danger fa-10x"></i>
  <h3 class="py-5">Payment failed.</h3>
  <a href="{{ route('mpesa.stk.status') }}" class="btn btn-info">Confirm Payment</a>
  @break
  @case('stk_push_error')
  <i class="fas fa-times-circle text-danger fa-10x"></i>
  <div class="d-flex flex-column justify-content-center align-items-center py-5">
    <h3>Error initiating payment!</h3>
    <h4>Please confirm number.</h4>
    <a class="btn btn-info" href="{{ url()->previous() }}">Go back</a>
  </div>
  @break
  @case('success')
  <i class="fas fa-lock text-info fa-10x"></i>
  <div class="d-flex flex-column justify-content-center align-items-center py-5">
    <h3>Payment initiated successfully.</h3>
    <h4>Enter Mpesa Pin to complete transaction.</h4>
    <a href="{{ route('mpesa.stk.status') }}" class="btn btn-info">Confirm payment.</a>
  </div>
  @break
  @default
  <i class="fas fa-window-close text-warning fa-10x"></i>
  <div class="d-flex justify-content-center align-items-center py-5">
    <h3>Something went wrong.</h3>
  </div>
  @endswitch
</div>
@endsection
