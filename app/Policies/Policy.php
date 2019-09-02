<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class Policy
{
    use HandlesAuthorization;

    public function before($user, $ability)
	{
	    // If the user has the right to manage the content, then the authorization is passed.
        if ($user->can('manage_contents')) {
            return true;
        }
	}
}
