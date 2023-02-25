<?php

namespace App\Helpers;

class ApiResponse
{
    public static function responseWithStatusAndMessage($status, $errors = null)
    {
        $responseData = [
            'status' => $status,
            'body' => $errors !== null ? $errors : self::getStatusMessage($status)
        ];

        return response()->json($responseData, $status);
    }

    public static function getStatusMessage($statusCode) {
        switch ($statusCode) {
            case 200:
                return 'Sucess';
            case 400:
                return 'Bad request';
            case 401:
                return 'Unauthorized';
            case 403:
                return 'Forbidden';
            case 404:
                return 'No such record found bobo';
            case 500:
                return 'Internal server error tanga';
            default:
                return 'Unknown error';
        }
    }
}