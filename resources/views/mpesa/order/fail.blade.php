@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center flex-column vh-100">
  <i class="fas fa-times-circle text-danger fa-10x"></i>
  <div class="d-flex justify-content-center align-items-center py-5">
    <h3>{{ session()->get('error') }}</h3>
    <a href="{{ route('home') }}" class="btn btn-primary">Home</a>
  </div>
</div>
@endsection
