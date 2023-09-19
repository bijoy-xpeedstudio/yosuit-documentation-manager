<?php
namespace App\Http\Responses;
class ApiResponse
{
    public static function success($data=[],$message='Success !',$status=200,$request_time=null){
        return response()->json([
            'status' => $status,
            'success' => true,
            'message' => $message,
            'data' => $data,
            'request_time' => $request_time,
            'response_time' => date('y-m-d h:i:s')

        ]);
    }
    public static function validationError($errors=[],$message='Validation Failed',$status=422,$request_time=null){
        return response()->json([
            'status' => $status,
            'success' => false,
            'message' => $message,
            'errors' => $errors,
            'request_time' => $request_time,
            'response_time' => date('y-m-d h:i:s')
        ]);
    }
    public  static function serverException($errors=[],$message='Something Went Wrong !',$status=501,$request_time=null){
        return response()->json([
            'status' => $status,
            'success' => false,
            'message' => $message,
            'errors' => $errors,
            'request_time' => $request_time,
            'response_time' => date('y-m-d h:i:s')
        ]);
    }
}