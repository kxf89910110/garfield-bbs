<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    public function saving(User $user)
<<<<<<< HEAD
    {
        //
        if (empty($user->avatar)) {
            $user->avatar = 'https://cdn.learnku.com/uploads/images/201710/30/1/TrJS40Ey5k.png';
        }
    }

    public function updating(User $user)
=======
>>>>>>> L03_5.8
    {
        // This is more scalable, and the default avatar is only specified when it is empty.
        if (empty($user->avatar)) {
            $user->avatar = 'https://raw.githubusercontent.com/kxf89910110/garfield-bbs/master/public/uploads/images/avatars/TrJS40Ey5k.png';
        }
    }
}
