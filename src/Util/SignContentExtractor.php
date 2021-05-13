<?php

namespace EasyAliSdk\Util;

use EasyAliSdk\AlipayConstants;

class SignContentExtractor
{
    /**
     * @var string
     */
    private $RESPONSE_SUFFIX = '_response';

    /**
     * @var string
     */
    private $ERROR_RESPONSE = 'error_response';

    /**
     * 获取签名资源.
     *
     * @param $body    string 网关的整体响应字符串
     * @param $method  string 本次调用的OpenAPI接口名称
     *
     * @return null|false|string 待验签的原文
     */
    public function getSignSourceData($body, $method)
    {
        $rootNodeName = str_replace('.', '_', $method) . $this->RESPONSE_SUFFIX;
        $rootIndex    = strpos($body, $rootNodeName);

        if ($rootIndex !== strrpos($body, $rootNodeName)) {
            throw new \Exception('检测到响应报文中有重复的' . $rootNodeName . ',验签失败。');
        }
        $errorIndex = strpos($body, $this->ERROR_RESPONSE);

        if ($rootIndex > 0) {
            return $this->parserJSONSource($body, $rootNodeName, $rootIndex);
        }

        if ($errorIndex > 0) {
            return $this->parserJSONSource($body, $this->ERROR_RESPONSE, $errorIndex);
        }

        return null;
    }

    /**
     * 解析响应体.
     *
     * @param $responseContent
     * @param $nodeName
     * @param $nodeIndex
     *
     * @return null|false|string
     */
    public function parserJSONSource($responseContent, $nodeName, $nodeIndex)
    {
        $signDataStartIndex = $nodeIndex + strlen($nodeName) + 2;

        if (strrpos($responseContent, AlipayConstants::ALIPAY_CERT_SN_FIELD)) {
            $signIndex = strrpos($responseContent, '"' . AlipayConstants::ALIPAY_CERT_SN_FIELD . '"');
        } else {
            $signIndex = strrpos($responseContent, '"' . AlipayConstants::SIGN_FIELD . '"');
        }
        // 签名前-逗号
        $signDataEndIndex = $signIndex         - 1;
        $indexLen         = $signDataEndIndex  - $signDataStartIndex;

        if ($indexLen < 0) {
            return null;
        }

        return substr($responseContent, $signDataStartIndex, $indexLen);
    }
}
