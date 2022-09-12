<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Libraries\UtilCommon;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator as FacadesValidator;

abstract class APIController extends Controller
{
    /**
     * constant
     *
     * @var array
     */
    protected array $const;

    /**
     * UtilCommon
     *
     * @var UtilCommon
     */
    protected UtilCommon $common;

    /**
     * construct
     */
    public function __construct()
    {
        // コンスタント取得
        $this->const = config('constant');

        // Common Util
        $this->common = app('Common');
    }

    /**
     * validator
     *
     * @param Request $request
     * @param array $rules
     * @param array $attribute
     * @param array $message
     * @return void
     */
    protected function validator(Request $request, array $rules, array $attribute = [], array $message = []): void
    {
        $validator = FacadesValidator::make($request->all(), $rules, $message, $attribute);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    /**
     * api common response
     *
     * @param array $response
     */
    protected function response(array $response)
    {
        $responseData = [];

        // set response header
        $responseData['header'] =  [
            'code'         => null,
            'errorMessage' => null,
            'traceId'      => $this->common->getPid()
        ];

        // set response data(item name is camel case)
        $responseData['response'] = $this->common->convertToSnakeCaseOrCamelCaseMulti($response, true);

        return response()->json($responseData);
    }
}
