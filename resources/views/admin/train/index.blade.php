@extends('admin.master')


@section('body')
<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Trains</h1>
    <a href="#" data-toggle="modal" data-target="#registerTrainModal"
       class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
         class="fas fa-plus fa-sm text-white-50"></i> Register Train</a>
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
      <h6 class="m-0 font-weight-bold text-primary">Trains</h6>
    </div>
    <!-- Card Body -->
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>Name</th>
              <th>Train Type</th>
              <th>Capacity</th>
              <th>Schedules</th>
              <th class="text-right">Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($trains as $train)
            <tr>
              <td>{{ $train->name }}</td>
              <td>{{ $train->train_type->type }}</td>
              <td>{{ $train->capacity }}</td>
              <td>
                <a class="text-info text-decoration-none"
                   href="{{route('train.schedule',  $train->id)}}">{{count($train->schedules)}}
                  @choice('Schedule|Schedules', $train->schedules)
                </a>
              </td>
              <td align="right">
                <div class="d-flex justify-content-around flex-row">
                  <a class="btn btn-info bg-info" href="#" data-toggle="modal" data-target="#editTrainModal"><i
                       class="fas fa-edit"></i></a>
                  <form action="{{ route('trains.destroy', $train->id) }}" method="POST">
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

<div class="modal fade" id="registerTrainModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Train</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <form method="POST" action="{{ route('trains.store') }}">
        <div class="modal-body">
          @csrf
          <div class="form-group">
            <label for="name">{{ __('Train Name') }}</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror"" name=" name" id="name"
                   value="{{ old('name') }}" placeholder="Train Name">
          </div>
          <div class="form-group">
            <label for="train_type">{{ __('Train Type') }}</label>
            <select class="custom-select" name="train_type">
              <option selected disabled>Select Train Type</option>
              @foreach($train_types as $train_type)
              <option value="{{ $train_type->id }}">{{ $train_type->type }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="capacity">{{ __('Capacity') }}</label>
            <input type="number" class="form-control @error('capacity') is-invalid @enderror"" name=" capacity"
                   id="capacity"
                   value="{{ old('capacity', 1) }}" min="1">
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
