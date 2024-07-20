<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ApiProvider\v1\Provider\ProviderModel;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class BaseController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    // Untuk Response Api
    protected function serverErrorResponse($message, $data = [])
    {
        $response = [
            'status' => 'server_error',
            'message' => $message,
            'data' => $data,
        ];

        return response()->json($response, 500);
    }

    protected function notFoundResponse($message, $data = [])
    {
        $response = [
            'status' => 'not_found',
            'message' => $message,
            'data' => $data,
        ];

        return response()->json($response, 404);
    }

    protected function unAuthorizationResponse($message, $data = [])
    {
        $response = [
            'status' => 'unauthorized',
            'message' => $message,
            'data' => $data,
        ];

        return response()->json($response, 401);
    }

    protected function badRequestResponse($message, $data = [])
    {
        $response = [
            'status' => 'bad_request',
            'message' => $message,
            'data' => $data,
        ];

        return response()->json($response, 400);
    }

    protected function successResponse($message, $data = [])
    {
        $response = [
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ];

        return response()->json($response, 200);
    }

    // Global Function Untuk Upload File
    protected function upload_image($request, $path, $name)
    {
        if ($request->hasFile($name)) {
            $file = $request->file($name);

            $file_name = str_replace(' ', '-', $file->getClientOriginalName());

            $destination = 'storage/' . $path;
            $file->move($destination, $file_name);
            $file = $destination . '/' . $file_name;
        } else {
            $file = '';
        }

        return $file;
    }

    protected function getUser()
    {
        $user = Auth::user();
        return $user;
    }

    protected function notifyService($discord)
    {
        $discord && self::bootDiscord($discord->title, $discord->description, $discord->content);
        return true;
    }

    protected function bootDiscord($title, $description, $content)
    {
        // if (env('APP_ENV') == "production") {
        //     $webhook = 'https://discord.com/api/webhooks/1150309229413023764/C7OhaL3EsUF0Mha-fwuShTB8JG_0mt80yo38ATL_9BhKjjVFC5DULfR9RecIWAAUdGME';
        // } else {
        //     $webhook = 'https://discord.com/api/webhooks/1150301516696125460/2DvCMyd2fUF5ZcYUBjraHEqb07q0eVaNYOnVHSC79a0GVWs9zu-ZqmUB_8GDr2EFkSpv';
        // }
        // return Http::post($webhook, [
        //     'content' => $content,
        //     'embeds' => [
        //         [
        //             'title' => $title,
        //             'description' => $description . ' @everyone',
        //         ]
        //     ],
        // ]);
    }
}
