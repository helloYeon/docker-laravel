<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SampleController extends APIController
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * get user info
     *
     * @param Request $request
     * @return object
     */
    public function get(Request $request): object
    {

        // log
        log_info(sprintf(config('message.I0002'), 'sample api'), []);

        // validation check
        $this->validator($request, [
            'userId'  => 'required',
        ]);

        // get user info
        $userId = request()->input('userId');
        $userInfo = \App\Models\User::where('id', $userId)->first();

        // response
        $response = [
            'message'  => "This Is Sample API",
            'userInfo' => [
                'userId' => $userInfo->id,
                'name'   => $userInfo->name,
                'email'  => $userInfo->email,
                'tel'    => $userInfo->tel,
            ],
        ];

        return $this->response($response);
    }
}
