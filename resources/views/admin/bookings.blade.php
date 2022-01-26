@extends('admin.master')


@section('body')
<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Bookings</h1>
  </div>
  <div class="card shadow mb-4">
    <!-- Card Header - Dropdown -->
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
      <h6 class="m-0 font-weight-bold text-primary">Bookings</h6>
    </div>
    <!-- Card Body -->
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>Booking Code</th>
              <th>Travel Date</th>
              <th>Phone</th>
              <th>From</th>
              <th>To</th>
              <th>Passengers</th>
              <th>Total Fare (Ksh)</th>
              <th>Payment Status</th>
            </tr>
          </thead>
          <tbody>
            @foreach($bookings as $booking)
            <tr>
              <td>{{ $booking->booking_code }}</td>
              <td>{{ $booking->travel_date }}</td>
              <td>{{ $booking->phone }}</td>
              <td>{{ $booking->from }}</td>
              <td>{{ $booking->to }}</td>
              <td>{{ $booking->passengers }}</td>
              <td>{{ $booking->total_fare }}</td>
              @if($booking->payment_status == 0)
              <td>Not Paid</td>
              @else
              <td>Paid</td>
              @endif
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<!-- /.container-fluid -->
@endsection
