@extends('layouts.app')
@section('title', 'No access')

@section('content')
  <div class="col-md-4 offset-md-4">
<<<<<<< HEAD
    <div class="card">
=======
    <div class="card ">
>>>>>>> L03_5.8
      <div class="card-body">
        @if (Auth::check())
          <div class="alert alert-danger text-center mb-0">
            The current login account has no background access.
          </div>
        @else
          <div class="alert alert-danger text-center">
<<<<<<< HEAD
            Please sign in and operate again.
          </div>

          <a class="btn btn-lg btn-primary btn-block" href="{{ route('login') }}">
            <i class="fas fa-sign-in-alert"></i>
=======
            Please log in and operate again
          </div>

          <a class="btn btn-lg btn-primary btn-block" href="{{ route('login') }}">
            <i class="fas fa-sign-in-alt"></i>
>>>>>>> L03_5.8
            Sign in
          </a>
        @endif
      </div>
    </div>
  </div>
@stop
