<?php

namespace App\Exceptions;

use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\JsonResponse;

trait CustomHandlerTrait
{
    /**
     * 独自例外のレスポンスハンドラ
     *
     * @param  Throwable  $exception
     * @return JsonResponse
     *
     * @throws Throwable
     */
    public function exceptionResponseHandler($ex) : JsonResponse
    {
        switch ($ex) {
            // invalid parameter error
            case $ex instanceof ValidationException:
                $errors = $ex->errors();
                $key = array_key_first($errors);
                return $this->errorResponse(Response::HTTP_BAD_REQUEST, 'I0004', sprintf(config('message.I0004'), $errors[$key][0]));
                break;
            // internal server error
            default:
                return $this->errorResponse(Response::HTTP_INTERNAL_SERVER_ERROR, 'E0001', $ex->getMessage());
                break;
        }
    }

    /**
     * error response
     *
     * @param int $statusCode
     * @param string $code
     * @param string $message
     * @return JsonResponse
     */
    protected function errorResponse(int $statusCode, string $code, string $message = '') : JsonResponse
    {
        if (empty($message)) {
            $message = config('message.'.$code);
        }

        $data = [
            'header' => [
                'code'          => $code,
                'error_message' => $message,
                'trace_id'      => app('Common')->getPid()
            ],
            'response' => []
        ];

        $corsHostName = '*';

        return response()->json($data, $statusCode)->header('Access-Control-Allow-Origin', $corsHostName);
    }
}
