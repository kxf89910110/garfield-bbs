@extends('layouts.app')

<<<<<<< HEAD
@section('title', 'My notice')
=======
@section('title', 'My message')
>>>>>>> L03_5.8

@section('content')
  <div class="container">
    <div class="col-md-10 offset-md-1">
<<<<<<< HEAD
      <div class="card">
=======
      <div class="card ">
>>>>>>> L03_5.8

        <div class="card-body">

          <h3 class="text-xs-center">
<<<<<<< HEAD
            <i class="far fa-bell" aria-hidden="true"></i> My notice
=======
            <i class="far fa-bell" aria-hidden="true"></i> My message
>>>>>>> L03_5.8
          </h3>
          <hr>

          @if ($notifications->count())
<<<<<<< HEAD
=======

>>>>>>> L03_5.8
            <div class="list-unstyled notification-list">
              @foreach ($notifications as $notification)
                @include('notifications.types._' . snake_case(class_basename($notification->type)))
              @endforeach

              {!! $notifications->render() !!}
            </div>

          @else
<<<<<<< HEAD
            <div class="empty-block">No message notification.</div>
=======
            <div class="empty-block">No news notifications.</div>
>>>>>>> L03_5.8
          @endif

        </div>
      </div>
    </div>
  </div>
@stop
