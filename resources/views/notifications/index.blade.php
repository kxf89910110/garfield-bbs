@extends('layouts.app')

@section('title', 'My message')

@section('content')
  <div class="container">
    <div class="col-md-10 offset-md-1">
      <div class="card ">

        <div class="card-body">

          <h3 class="text-xs-center">
            <i class="far fa-bell" aria-hidden="true"></i> My message
          </h3>
          <hr>

          @if ($notifications->count())

            <div class="list-unstyled notification-list">
              @foreach ($notifications as $notification)
                @include('notifications.types._' . snake_case(class_basename($notification->type)))
              @endforeach

              {!! $notifications->render() !!}
            </div>

          @else
            <div class="empty-block">No news notifications.</div>
          @endif

        </div>
      </div>
    </div>
  </div>
@stop
