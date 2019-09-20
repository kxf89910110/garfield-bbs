<?php

namespace App\Models;

use Auth;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;

class User extends Authenticatable implements MustVerifyEmailContract, JWTSubject
{
    use Traits\ActiveUserHelper;
    use HasRoles;
    use MustVerifyEmailTrait;

    use Notifiable {
        notify as protected laravelNotify;
    }
    // public function notify($instance)
    // {
    //     // If the person to be notified is the current user, you do nor have to notify.
    //     if ($this->id == Auth::id()) {
    //         return;
    //     }

    //     // Only need to remind you of the database type notification,send email directly or other Pass.
    //     if (method_exists($instance, 'toDatabase')) {
    //         $this->increment('notification_count');
    //     }

    //     $this->laravelNotify($instance);
    // }
    public function topicNotify($instance)
    {
        // If the person to be notified is the current user, you do nor have to notify.
        if ($this->id == Auth::id()) {
            return;
        }
        $this->increment('notification_count');
        $this->notify($instance);
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'phone', 'email', 'password', 'introduction', 'avatar', 'weixin_openid', 'weixin_unionid', 'registration_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    public function isAuthorOf($model)
    {
        return $this->id == $model->user_id;
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function markAsRead()
    {
        $this->notification_count = 0;
        $this->save();
        $this->unreadNotifications->markAsRead();
    }

    public function setPasswordAttribute($value)
    {
        // If the length of the value is equal to 60, it is considered to have been encrypted.
        if (strlen($value) != 60) {

            // Not equal to 60, do password encryption processing
            $value = bcrypt($value);
        }

        $this->attributes['password'] = $value;
    }

    public function setAvatarAttribute($path)
    {
        // If it is not the beginning of the 'http' substring, it is uploaded from the background and needs to complete the URL.
        if ( ! starts_with($path, 'http')) {

            // Stitching the complete URL
            $path = config('app.url') . "/uploads/images/avatars/$path";
        }

        $this->attributes['avatar'] = $path;
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
