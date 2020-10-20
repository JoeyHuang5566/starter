<?php

namespace App\Traits;

trait JsonRender
{
	public function jsonRenderResultWithSuccess($data = array())
	{
        return (
            response()->json($data)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'POST')
            ->header('Access-Control-Allow-Headers', 'Content-Type, X-Auth-Token, Origin')
        );
	}

	public function jsonRenderResultWithError($msg = null, $statusCode, $data = array(), $option = array())
	{
		$callback = [
            'error_name' => $msg,
        ];

        if ($msg == 'illegal form input') {
            $callback['validation'] = $data;
        } else {
            $callback = array_merge($callback, $data);
        }

        $callback = array_merge($callback, $option);

        return (
            response()->json($callback, $statusCode)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'POST')
            ->header('Access-Control-Allow-Headers', 'Content-Type, X-Auth-Token, Origin')
        );
	}
}
