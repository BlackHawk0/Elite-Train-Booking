@extends('admin.master')


@section('body')
<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Add {{ $train->name }} Train Schedule</h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
         class="fas fa-list fa-sm text-white-50"></i> Train Schedules</a>
  </div>

  <div class="row">

    <!-- Area Chart -->
    <div class="col-xl-8 col-lg-7">
      <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">Add Train Schedule</h6>
        </div>
        <!-- Card Body -->
        <div class="card-body">
          @if(session()->get('success'))
          <div class="alert alert-success">
            {{ session()->get('success') }}
          </div>
          @endif
          @if ($errors->any())
          <div class="alert alert-danger">
            <ul>
              @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
          <br />
          @endif
          <form method="POST" action="{{ route('schedules.store') }}">
            @csrf
            <div class=" form-group">
              <label for="from">{{ __('Departure Station') }}</label>
              <select class="custom-select" name="from">
                <option selected disabled>Select Departure Station</option>
                @foreach($stations as $station)
                <option value="{{ $station->id }}">{{ $station->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="to">{{ __('Destination Station') }}</label>
              <select class="custom-select" name="to">
                <option selected disabled>Select Destination Station</option>
                @foreach($stations as $station)
                <option value="{{ $station->id }}">{{ $station->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="departure_time">{{ __('Departure Time') }}</label>
              <input type="time" class="form-control" name="departure_time" id="departure_time">
            </div>
            <div class="form-group">
              <label for="arrival_time">{{ __('Arrival Time') }}</label>
              <input type="time" class="form-control" name="arrival_time" id="arrival_time">
            </div>

            <div class="form-group">
              <label for="cost">Fare (Ksh.)</label>
              <input type="number" min="1" class="form-control" name="cost" id="cost"
                     value="{{ old('cost', 1) }}">
            </div>

            <button type="submit" class="btn btn-primary btn-block mt-3">
              {{ __('Add Schedule') }}
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /.container-fluid -->
@endsection
