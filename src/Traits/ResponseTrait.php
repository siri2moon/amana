<?php
/**
 * Created by PhpStorm.
 * User2: binhnx
 * Date: 10/1/18
 * Time: 2:44 PM
 */

namespace Herode\Amana\Traits;

trait ResponseTrait
{
    protected function success($data, $message = 'SUCCESS', $code = 0)
    {
        return response()->json(
            [
                'status' => true,
                'data'   => $data,
                'error'  => [
                    'code'    => $code,
                    'message' => $message,
                ],
            ]
        );
    }

    protected function error($message, $status = 400)
    {
        $decode = is_string($message) ? json_decode($message) : '';
        if ($decode) {
            $message = $decode;
        }

        return response()->json(
            [
                'status' => false,
                'data'   => null,
                'error'  => [
                    'code'    => $status,
                    'message' => $message,
                ],
            ],
            200
        );
    }

    protected function notFound()
    {
        return $this->error('RESOURCE_NOT_FOUND', 404);
    }

    protected function notFoundWeb()
    {
        return view('errors.404');
    }

    protected function notAuthorize()
    {
        return $this->error('NOT_AUTHORIZE_FOR_THIS_URI', 401);
    }
}
