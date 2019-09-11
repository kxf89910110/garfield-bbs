@extends('layouts.app')

@section('title', $user->name . "'s personal center")

@section('content')

<div class="row">

  <div class="col-lg-3 col-md-3 hidden-sm hidden-xs user-info">
    <div class="card">
      <img class="card-img-top" src="{{ $user->avatar }}" alt="{{ $user->name }}"></img>
      <div class="card-body">
        <h5><strong>Personal profile</strong></h5>
        <p>{{ $user->introduction }}</p>
        <hr>
        <h5><strong>Registered at</strong></h5>
        <p>{{ $user->created_at->diffForHumans() }}</p>
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
    <div class="card ">
      <div class="card-body">
        <ul class="nav nav-tabs">
          <li class="nav-item">
            <a class="nav-link bg-transparent {{ active_class(if_query('tab', null)) }}" href="{{ route('users.show', $user->id) }}">
              {{ $user->name }}'s topic
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link bg-transparent {{ active_class(if_query('tab', 'replies')) }}" href="{{ route('users.show', [$user->id, 'tab' => 'replies']) }}">
              {{ $user->name }}'s reply
            </a>
          </li>
        </ul>
        @if (if_query('tab', 'replies'))
          @include('users._replies', ['replies' => $user->replies()->with('topic')->recent()->paginate(5)])
        @else
          @include('users._topics', ['topics' => $user->topics()->recent()->paginate(5)])
        @endif
      </div>
    </div>

  </div>
</div>
@stop
