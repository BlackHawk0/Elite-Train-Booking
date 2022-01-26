@extends('layouts.app')

@section('content')
<nav class="navbar navbar-light bg-white mb-4 static-top shadow">
  <div class="container">
    <div class="navbar-brand text-secondary">Payment</div>
  </div>
</nav>
<h5 class="text-center">Confirm Booking & Make Payment</span></h5>

<div class="container">
  <div class="row">
    <div class="col-md-6">
      <div class="card mb-4">
        <div class="card-body">
          <h4>Ticket: {{ $booking->booking_code }}</h4>
          <h5 class="card-title mb-2 text-info"><i class="fas fa-route"></i> {{ $schedule->from->name }} to
            {{ $schedule->to->name }}
          </h5>
          <h6 class="card-subtitle my-2"><i class="fas fa-train"></i> {{ $schedule->train->name }}</h6>
          <div class="row">
            <div class="col-md-6">
              <h6 class="mt-0 text-dark">Departure Time</h6>
              <p>{{ $booking->departure_time }}</p>
            </div>
            <div class="col-md-6">
              <h6 class="mt-0 text-dark">Arrival Time</h6>
              <p>{{ $booking->arrival_time }}</p>
            </div>
          </div>
          <h6>Departure Date: {{ $booking->travel_date }}</h6>
          <hr>
          <div class="d-flex justify-content-between">
            <h6 class="mt-0 text-dark">Passengers: {{ $booking->passengers }}</h6>
            <h6 class="mt-0 text-dark">Booked At: {{ $booking->created_at }}</h6>
          </div>

        </div>
      </div>
    </div>


    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title mb-2 text-success font-weight-bold">Make Payment</h6>
          <form method="POST" action="{{ route('initiate.payment') }}">
            @csrf

            <input hidden value="{{ $booking->id }}" name="booking_id">
            <input hidden value="{{ $booking->total_fare }}" name="fare">

            <div class=form-group>
              <label for="phone">Mpesa Number</label>
              <input class="form-control" type="tel" name="phone" id="phone" placeholder="25478298208" required>
              <small id="phoneHelp" class="form-text text-muted">Format: 254720292892</small>
            </div>

            <hr>
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <h5 class="font-weight-bold">Total Fare</h5>
                <h4 class="font-weight-bolder">Ksh. {{ $booking->total_fare }}</h4>
              </div>
              <div>
                <button type="submit" class="btn btn-outline-info">Pay Now</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
