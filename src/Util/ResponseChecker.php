<?php


namespace EasyAliSdk\Util;


class ResponseChecker
{
    /**
     * 响应成功
     *
     * @param $response
     *
     * @return bool
     */
    public function success($response)
    {
        if (!empty($response->code) && $response->code == 10000) {
            return true;
        }
        if (empty($response->code) && empty($response->subCode)) {
            return true;
        }
        return false;
    }
}