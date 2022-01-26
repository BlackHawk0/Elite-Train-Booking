@extends('layouts.app')

@section('content')
<nav class="navbar navbar-light bg-white mb-4 static-top shadow">
  <div class="container">
    <div class="navbar-brand text-secondary">Schedules</div>
  </div>
</nav>
<div class="container">
  @php
  $data = session()->get('data');
  $schedules = $data['schedules']['available_schedules'];
  $travel_date = $data['travel_date'];
  $from = $data['from'];
  $to = $data['to'];
  $passengers = $data['passengers'];
  @endphp
  <h5>Found {{ count($schedules) }} results for: <span>{{ $from->name }} to {{ $to->name }}</span></h5>

  <div class="row">
    <div class="col-md-12">
      @foreach($schedules as $schedule)
      <div class="card mb-4">
        <div class="card-body">
          <h6 class="card-title mb-2 text-info"><i class="fas fa-train"></i> {{ $schedule->train->name }} </h6>
          <div class="row">
            <div class="col-md-6">
              <h6 class="mt-0 text-dark">Departure Time</h6>
              <p>{{ $schedule->departure_time }}</p>

              <h6 class="mt-0 text-dark">Arrival Time</h6>
              <p>{{ $schedule->arrival_time }}</p>
            </div>
            <div class="col-md-6">
              <h6 class="mt-0 text-dark">Fare</h6>
              <h5 class="font-weight-bolder">Ksh. {{ $schedule->cost }} <span
                      class="text-muted text-small font-weight-lighter">/
                  person</span></h5>
              <form action="{{ route('book.train') }}" method="POST">
                @csrf
                <input hidden name="schedule" value="{{ $schedule->id }}">
                <input hidden name="passengers" value="{{ $passengers }}">
                <input hidden name="travel_date" value="{{ $travel_date }}">
                <button class="btn btn-outline-success" type="submit">Book Now</button>
              </form>

            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</div>
@endsection
