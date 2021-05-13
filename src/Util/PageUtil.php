<?php

namespace EasyAliSdk\Util;

use EasyAliSdk\AlipayConstants;

class PageUtil
{
    /**
     * 构建参数.
     *
     * @param $actionUrl
     * @param $parameters
     *
     * @return string
     */
    public function buildForm($actionUrl, $parameters)
    {
        $sHtml = "<form id='alipaysubmit' name='alipaysubmit' action='" . $actionUrl . '?charset=' . trim(AlipayConstants::DEFAULT_CHARSET) . "' method='POST'>";
        while (list($key, $val) = $this->fun_adm_each($parameters)) {
            if ($this->checkEmpty($val) === false) {
                $val = str_replace("'", '&apos;', $val);
                $sHtml .= "<input type='hidden' name='" . $key . "' value='" . $val . "'/>";
            }
        }

        //submit按钮控件请不要含有name属性
        $sHtml = $sHtml . "<input type='submit' value='ok' style='display:none;''></form>";

        return $sHtml . "<script>document.forms['alipaysubmit'].submit();</script>";
    }

    /**
     * @param $array
     *
     * @return array|false
     */
    protected function fun_adm_each(&$array)
    {
        $res = [];
        $key = key($array);

        if ($key !== null) {
            next($array);
            $res[1] = $res['value'] = $array[$key];
            $res[0] = $res['key'] = $key;
        } else {
            $res = false;
        }

        return $res;
    }

    /**
     * 校验$value是否非空.
     *  if not set ,return true;
     *  if is null , return true;
     *
     * @param mixed $value
     */
    protected function checkEmpty($value)
    {
        if (!isset($value)) {
            return true;
        }

        if ($value === null) {
            return true;
        }

        if (trim($value) === '') {
            return true;
        }

        return false;
    }
}
