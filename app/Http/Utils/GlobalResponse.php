<?php

namespace App\Http\Utils;

class GlobalResponse
{
    public function respond($trueOrFalse, $message, $result) {
        return response()->json([
            'success' => $trueOrFalse,
            'message' => $message,
            'data' => $result
        ]);
    }
}