<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Styles -->
    <style>
    html,
    body {
      height: 100vh;
    }

    .bg {
      background-image: url('images/bg_1-min.jpg');
      height: 100%;

      background-position: center;
      background-repeat: no-repeat;
      background-size: cover;

      filter: blur(4px);
      -webkit-filter: blur(4px);
      -moz-filter: blur(4px);
      -o-filter: blur(4px);
      -ms-filter: blur(4px);
    }

    .content {
      background-color: rgb(0, 0, 0);
      /* Fallback color */
      background-color: rgba(0, 0, 0, 0.4);
      /* Black w/opacity/see-through */
      color: white;
      font-weight: bold;
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      z-index: 2;
      width: 80%;
      padding: 20px;
    }

    .title {
      font-size: 84px;
    }

    </style>
  </head>

  <body>
    <div class="bg"></div>
    <div class="content">
      <h1 class="display-2 text-center">
        Train Reservation
      </h1>
      <div>
        <form action="{{ route('search.schedules') }}" method="POST">
          @csrf
          <div class="form-row">
            <div class="form-group col-md-4">
              <label for="from font-weight-bold">From</label>
              <select class="custom-select custom-select-lg  @error('from') is-invalid @enderror" id="from" name="from"
                      required>
                <option selected disabled>Select...</option>
                @foreach($stations as $station)
                <option value="{{ $station->id }}">{{$station->name}}</option>
                @endforeach
              </select>
              @error('from')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
            <div class="form-group col-md-4">
              <label for="to">To</label>
              <select class="custom-select custom-select-lg  @error('to') is-invalid @enderror" id="to" name="to"
                      required>
                <option selected disabled>Select...</option>
                @foreach($stations as $station)
                <option value="{{ $station->id }}">{{$station->name}}</option>
                @endforeach
              </select>
              @error('to')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
            <div class="form-group col-md-3">
              <label for="travel_date">Travel Date</label>
              <input type="date" id="travel_date" name="travel_date"
                     class="form-control form-control-lg @error('travel_date') is-invalid @enderror"
                     min="<?php echo date('Y-m-d'); ?>"
                     value="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-m-d', strtotime('+3 months')) ?>"
                     placeholder="Travel Date" required>

              @error('travel_date')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
            <div class="form-group col-md-1">
              <label for="passengers">Passengers</label>
              <input type="number" name="passengers"
                     class="form-control form-control-lg @error('passengers') is-invalid @enderror" min="1" value="1"
                     max="10"
                     placeholder="Passengers" required>
              @error('passengers')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
          </div>
          <div class="d-flex justify-content-center">
            <button type="submit" class="btn btn-success btn-lg text-white">Check Availability</button>
          </div>
        </form>
      </div>
    </div>

    <script>
    </script>


  </body>

</html>
