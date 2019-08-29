@extends('layouts.app')

@section('title', $user->name . "'s personal center")

@section('content')

<div class="row">

  <div class="col-lg-3 col-md-3 hidden-sm hidden-xs user-info">
    <div class="card">
      <img class="card-img-top" src="https://cdn.learnku.com/uploads/images/201710/30/1/TrJS40Ey5k.png" alt="{{ $user->name }}"></img>
      <div class="card-body">
        <h5><strong>Personal profile</strong></h5>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
        <hr>
        <h5><strong>Registered at</strong></h5>
        <p>January 01 1901</p>
      </div>
    </div>
  </div>
  <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
    <div class="card">
      <div class="card-body">
        <h1 class="mb-0" style="font-size: 22px;">
          {{ $user->name }}
          <small>{{ $user->email }}</small>
        </h1>
      </div>
    </div>
    <hr>

    {{-- User posted content --}}
    <div class="card">
      <div class="card-body">
        No data ~_~
      </div>
    </div>

  </div>
</div>
@stop
