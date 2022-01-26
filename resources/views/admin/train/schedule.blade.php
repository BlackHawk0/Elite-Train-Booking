@extends('admin.master')


@section('body')
<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{ $train->name }} Train Schedule</h1>
    <a href="{{ route('schedules.create' ) }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
         class="fas fa-plus fa-sm text-white-50"></i> Add a Schedule</a>
  </div>
  @if(session()->get('success'))
  <div class="alert alert-success">
    {{ session()->get('success') }}
  </div>
  @endif
  @if(session()->get('fail'))
  <div class="alert alert-danger">
    {{ session()->get('fail') }}
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
  <div class="card shadow mb-4">
    <!-- Card Header - Dropdown -->
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
      <h6 class="m-0 font-weight-bold text-primary">Train Schedules</h6>
    </div>
    <!-- Card Body -->
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>Departure Station</th>
              <th>Arrival Station</th>
              <th>Departure Time</th>
              <th>Arrival Time</th>
              <th>Fare</th>
              <th class="text-right">Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($train_schedules as $train_schedule)
            <tr>
              <td>{{ $train_schedule->from }}</td>
              <td>{{ $train_schedule->to }}</td>
              <td>{{ $train_schedule->departure_time }}</td>
              <td>{{ $train_schedule->arrival_time }}</td>
              <td>{{ $train_schedule->cost }}</td>
              <td align="right">
                <div class="d-flex justify-content-around flex-row">
                  <a class="btn btn-info bg-info" href="#" data-toggle="modal"><i
                       class="fas fa-edit"></i></a>
                  <form action="{{ route('schedules.destroy', $train_schedule->id) }}" method="POST">
                    @csrf
                    @method("DELETE")
                    <button class="btn btn-danger bg-danger" type="submit"><i class="fas fa-trash"></i></button>
                  </form>
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="addStationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Station</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <form method="POST" action="{{ route('schedules.store') }}">
        <div class="modal-body">
          @csrf
          <div class="form-group">
            <label for="name">{{ __('Station Name') }}</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror"" name=" name" id="name"
                   value="{{ old('name') }}" placeholder="Station Name">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary btn-block mt-3">
            {{ __('Submit') }}
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- /.container-fluid -->
@endsection
