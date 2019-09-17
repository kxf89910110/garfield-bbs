<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\Api\UserRequest;

class UsersController extends Controller
{
    public function store(UserRequest $request)
    {
        $verifyData = \Cache::get($request->verification_key);

        if (!$verifyData) {
            return $this->response->error('Verification code has expired', 422);
        }

        if (!hash_equals($verifyData['code'], $request->verification_code)) {
            // Return 401
            return $this->response->errorUnauthorized('Verification code error.');
        }

        $user = User::create([
            'name' => $request->name,
            'phone' => $verifyData['phone'],
            'password' => bcrypt($request->password),
        ]);

        // Clear captcha cache
        \Cache::forget($request->verification_key);

        return $this->response->created();
    }
}
