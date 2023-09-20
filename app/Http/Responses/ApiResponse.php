<?php

namespace App\Http\Responses;

class ApiResponse
{
    public static function response($data = [], $message = 'Success !', $status = 200, $request_time = null)
    {
        return response()->json([
            'message' => $message,
            'data' => $data,
            'request_time' => $request_time,
            'response_time' => date('y-m-d h:i:s')

        ], $status);
    }
}
