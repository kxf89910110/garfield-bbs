<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class NotificationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Get all notifications for logged in users
        $notifications = Auth::user()->notifications()->paginate(20);
        // Mark as read, unread quantity clear
        Auth::user()->markAsRead();
        return view('notifications.index', compact('notifications'));
    }
}
