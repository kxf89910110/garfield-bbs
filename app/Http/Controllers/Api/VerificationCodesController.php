<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Overtrue\EasySms\EasySms;
use App\Http\Requests\Api\VerificationCodeRequest;

class VerificationCodesController extends Controller
{
    public function store(VerificationCodeRequest $request, EasySms $easySms)
    {

        $phone = $request->phone;

        if (!app()->environment('production')) {
            $code = '1234';
        } else {
            // Generate a 4-bit random number with 0 on the left
            $code = str_pad(random_int(1, 9999), 4, 0, STR_PAD_LEFT);

            try {
                $result = $easySms->send($phone, [
                    'template' => 341728,
                    'data' => [
                        $code,
                    ],
                ]);
            } catch (\Overtrue\EasySms\Exceptions\NoGatewayAvailableException $exception) {
                $message = $exception->getException('qcloud')->getMessage();
                return $this->response->errorInternal($message ?: 'SMS sending exception');
            }
        }

        // try {
        //     $result = $easySms->send($phone, [
        //         'content'  =>  "{$code}"
        //     ]);
        // } catch (\Overtrue\EasySms\Exceptions\NoGatewayAvailableException $exception) {
        //     $message = $exception->getException('yunpian')->getMessage();
        //     return $this->response->errorInternal($message ?: 'SMS sending exception');
        // }

        $key = 'verificationCode_'.str_random(15);
        $expiredAt = now()->addMinutes(10);
        // The cache verification code expires in 10 minutes.
        \Cache::put($key, ['phone' => $phone, 'code' => $code], $expiredAt);

        return $this->response->array([
            'key' => $key,
            'expired_at' => $expiredAt->toDateTimeString(),
        ])->setStatusCode(201);
    }
}
