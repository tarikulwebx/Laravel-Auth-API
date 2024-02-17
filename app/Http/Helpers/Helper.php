<?php

namespace App\Http\Helpers;

use Illuminate\Http\Exceptions\HttpResponseException;

class Helper
{

    /**
     * Success response
     *
     * @method successResponse
     * @param String message
     * @param Any data
     * @param Integer code
     *
     * @return Json
     */
    public static function successResponse($message, $data = [], $code = 200)
    {
        $response = [
            "success" => true,
            "message" => $message,
        ];

        if (!empty($data)) {
            $response['data'] = $data;
        }

        return response()->json($response, $code);
    }


    /**
     * Error response
     *
     * @method errorResponse
     * @param String message
     * @param Any data
     * @param Integer code
     *
     * @return Json exception
     */
    public static function errorResponse($message, $errors = [], $code = 401)
    {
        $response = [
            "success" => false,
            "message" => $message,
        ];

        if (!empty($errors)) {
            $response['errors'] = $errors;
        }

        throw new HttpResponseException(response()->json($response, $code));
    }
}
