<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;

class Controller extends BaseController
{
    public function resFailJson(\Exception $e)
    {
        Log::info($e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine());

        return response()->json([
            'data' => null,
            'message' => 'Server internal error',
        ], 500);
    }

    public function resJson($data, $statusCode = 200)
    {
        return response()->json($data, $statusCode);
    }
}
