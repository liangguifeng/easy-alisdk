<?php

namespace EasyAliSdk\Domain\Marketing\OpenLife;

use Exception;
use AlibabaCloud\Tea\Tea;
use AlibabaCloud\Tea\Request;
use EasyAliSdk\Domain\AliSdkOperate;
use AlibabaCloud\Tea\Exception\TeaError;
use AlibabaCloud\Tea\Exception\TeaUnableRetryError;
use EasyAliSdk\Domain\Marketing\OpenLife\Models\Text;
use EasyAliSdk\Domain\Marketing\OpenLife\Models\Article;
use EasyAliSdk\Domain\Marketing\OpenLife\Models\Template;
use EasyAliSdk\Domain\Marketing\OpenLife\Models\AlipayOpenPublicLifeMsgRecallResponse;
use EasyAliSdk\Domain\Marketing\OpenLife\Models\AlipayOpenPublicMessageTotalSendResponse;
use EasyAliSdk\Domain\Marketing\OpenLife\Models\AlipayOpenPublicMessageSingleSendResponse;
use EasyAliSdk\Domain\Marketing\OpenLife\Models\AlipayOpenPublicMessageContentCreateResponse;
use EasyAliSdk\Domain\Marketing\OpenLife\Models\AlipayOpenPublicMessageContentModifyResponse;
use EasyAliSdk\Domain\Marketing\OpenLife\Models\AlipayOpenPublicSettingCategoryQueryResponse;
use EasyAliSdk\Domain\Marketing\OpenLife\Models\AlipayOpenPublicTemplateMessageIndustryModifyResponse;

class Client implements AliSdkOperate
{
    protected $_kernel;

    public function __construct($kernel)
    {
        $this->_kernel = $kernel;
    }

    /**
     * @param string $title
     * @param string $cover
     * @param string $content
     * @param string $contentComment
     * @param string $ctype
     * @param string $benefit
     * @param string $extTags
     * @param string $loginIds
     *
     * @throws TeaError
     * @throws Exception
     * @throws TeaUnableRetryError
     *
     * @return AlipayOpenPublicMessageContentCreateResponse
     */
    public function createImageTextContent($title, $cover, $content, $contentComment, $ctype, $benefit, $extTags, $loginIds)
    {
        $_runtime = [
            'ignoreSSL'      => $this->_kernel->getConfig('ignoreSSL'),
            'httpProxy'      => $this->_kernel->getConfig('httpProxy'),
            'connectTimeout' => 15000,
            'readTimeout'    => 15000,
            'retry'          => [
                'maxAttempts' => 0,
            ],
        ];
        $_lastRequest   = null;
        $_lastException = null;
        $_now           = time();
        $_retryTimes    = 0;
        while (Tea::allowRetry(@$_runtime['retry'], $_retryTimes, $_now)) {
            if ($_retryTimes > 0) {
                $_backoffTime = Tea::getBackoffTime(@$_runtime['backoff'], $_retryTimes);

                if ($_backoffTime > 0) {
                    Tea::sleep($_backoffTime);
                }
            }
            $_retryTimes = $_retryTimes + 1;

            try {
                $_request     = new Request();
                $systemParams = [
                    'method'              => 'alipay.open.public.message.content.create',
                    'app_id'              => $this->_kernel->getConfig('appId'),
                    'timestamp'           => $this->_kernel->getTimestamp(),
                    'format'              => 'json',
                    'version'             => '1.0',
                    'alipay_sdk'          => $this->_kernel->getSdkVersion(),
                    'charset'             => 'UTF-8',
                    'sign_type'           => $this->_kernel->getConfig('signType'),
                    'app_cert_sn'         => $this->_kernel->getMerchantCertSN(),
                    'alipay_root_cert_sn' => $this->_kernel->getAlipayRootCertSN(),
                ];
                $bizParams = [
                    'title'         => $title,
                    'cover'         => $cover,
                    'content'       => $content,
                    'could_comment' => $contentComment,
                    'ctype'         => $ctype,
                    'benefit'       => $benefit,
                    'ext_tags'      => $extTags,
                    'login_ids'     => $loginIds,
                ];
                $textParams         = [];
                $_request->protocol = $this->_kernel->getConfig('protocol');
                $_request->method   = 'POST';
                $_request->pathname = '/gateway.do';
                $_request->headers  = [
                    'host'         => $this->_kernel->getConfig('gatewayHost'),
                    'content-type' => 'application/x-www-form-urlencoded;charset=utf-8',
                ];
                $_request->query = $this->_kernel->sortMap(Tea::merge([
                    'sign' => $this->_kernel->sign($systemParams, $bizParams, $textParams, $this->_kernel->getConfig('merchantPrivateKey')),
                ], $systemParams, $textParams));
                $_request->body = $this->_kernel->toUrlEncodedRequestBody($bizParams);
                $_lastRequest   = $_request;
                $_response      = Tea::send($_request, $_runtime);
                $respMap        = $this->_kernel->readAsJson($_response, 'alipay.open.public.message.content.create');

                if ($this->_kernel->isCertMode()) {
                    if ($this->_kernel->verify($respMap, $this->_kernel->extractAlipayPublicKey($this->_kernel->getAlipayCertSN($respMap)))) {
                        return AlipayOpenPublicMessageContentCreateResponse::fromMap($this->_kernel->toRespModel($respMap));
                    }
                } else {
                    if ($this->_kernel->verify($respMap, $this->_kernel->getConfig('alipayPublicKey'))) {
                        return AlipayOpenPublicMessageContentCreateResponse::fromMap($this->_kernel->toRespModel($respMap));
                    }
                }
                throw new TeaError([
                    'message' => '????????????????????????????????????????????????????????????',
                ]);
            } catch (Exception $e) {
                if (!($e instanceof TeaError)) {
                    $e = new TeaError([], $e->getMessage(), $e->getCode(), $e);
                }

                if (Tea::isRetryable($e)) {
                    $_lastException = $e;
                    continue;
                }
                throw $e;
            }
        }
        throw new TeaUnableRetryError($_lastRequest, $_lastException);
    }

    /**
     * @param string $contentId
     * @param string $title
     * @param string $cover
     * @param string $content
     * @param string $couldComment
     * @param string $ctype
     * @param string $benefit
     * @param string $extTags
     * @param string $loginIds
     *
     * @throws TeaError
     * @throws Exception
     * @throws TeaUnableRetryError
     *
     * @return AlipayOpenPublicMessageContentModifyResponse
     */
    public function modifyImageTextContent($contentId, $title, $cover, $content, $couldComment, $ctype, $benefit, $extTags, $loginIds)
    {
        $_runtime = [
            'ignoreSSL'      => $this->_kernel->getConfig('ignoreSSL'),
            'httpProxy'      => $this->_kernel->getConfig('httpProxy'),
            'connectTimeout' => 15000,
            'readTimeout'    => 15000,
            'retry'          => [
                'maxAttempts' => 0,
            ],
        ];
        $_lastRequest   = null;
        $_lastException = null;
        $_now           = time();
        $_retryTimes    = 0;
        while (Tea::allowRetry(@$_runtime['retry'], $_retryTimes, $_now)) {
            if ($_retryTimes > 0) {
                $_backoffTime = Tea::getBackoffTime(@$_runtime['backoff'], $_retryTimes);

                if ($_backoffTime > 0) {
                    Tea::sleep($_backoffTime);
                }
            }
            $_retryTimes = $_retryTimes + 1;

            try {
                $_request     = new Request();
                $systemParams = [
                    'method'              => 'alipay.open.public.message.content.modify',
                    'app_id'              => $this->_kernel->getConfig('appId'),
                    'timestamp'           => $this->_kernel->getTimestamp(),
                    'format'              => 'json',
                    'version'             => '1.0',
                    'alipay_sdk'          => $this->_kernel->getSdkVersion(),
                    'charset'             => 'UTF-8',
                    'sign_type'           => $this->_kernel->getConfig('signType'),
                    'app_cert_sn'         => $this->_kernel->getMerchantCertSN(),
                    'alipay_root_cert_sn' => $this->_kernel->getAlipayRootCertSN(),
                ];
                $bizParams = [
                    'content_id'    => $contentId,
                    'title'         => $title,
                    'cover'         => $cover,
                    'content'       => $content,
                    'could_comment' => $couldComment,
                    'ctype'         => $ctype,
                    'benefit'       => $benefit,
                    'ext_tags'      => $extTags,
                    'login_ids'     => $loginIds,
                ];
                $textParams         = [];
                $_request->protocol = $this->_kernel->getConfig('protocol');
                $_request->method   = 'POST';
                $_request->pathname = '/gateway.do';
                $_request->headers  = [
                    'host'         => $this->_kernel->getConfig('gatewayHost'),
                    'content-type' => 'application/x-www-form-urlencoded;charset=utf-8',
                ];
                $_request->query = $this->_kernel->sortMap(Tea::merge([
                    'sign' => $this->_kernel->sign($systemParams, $bizParams, $textParams, $this->_kernel->getConfig('merchantPrivateKey')),
                ], $systemParams, $textParams));
                $_request->body = $this->_kernel->toUrlEncodedRequestBody($bizParams);
                $_lastRequest   = $_request;
                $_response      = Tea::send($_request, $_runtime);
                $respMap        = $this->_kernel->readAsJson($_response, 'alipay.open.public.message.content.modify');

                if ($this->_kernel->isCertMode()) {
                    if ($this->_kernel->verify($respMap, $this->_kernel->extractAlipayPublicKey($this->_kernel->getAlipayCertSN($respMap)))) {
                        return AlipayOpenPublicMessageContentModifyResponse::fromMap($this->_kernel->toRespModel($respMap));
                    }
                } else {
                    if ($this->_kernel->verify($respMap, $this->_kernel->getConfig('alipayPublicKey'))) {
                        return AlipayOpenPublicMessageContentModifyResponse::fromMap($this->_kernel->toRespModel($respMap));
                    }
                }
                throw new TeaError([
                    'message' => '????????????????????????????????????????????????????????????',
                ]);
            } catch (Exception $e) {
                if (!($e instanceof TeaError)) {
                    $e = new TeaError([], $e->getMessage(), $e->getCode(), $e);
                }

                if (Tea::isRetryable($e)) {
                    $_lastException = $e;
                    continue;
                }
                throw $e;
            }
        }
        throw new TeaUnableRetryError($_lastRequest, $_lastException);
    }

    /**
     * @param string $text
     *
     * @throws TeaError
     * @throws Exception
     * @throws TeaUnableRetryError
     *
     * @return AlipayOpenPublicMessageTotalSendResponse
     */
    public function sendText($text)
    {
        $_runtime = [
            'ignoreSSL'      => $this->_kernel->getConfig('ignoreSSL'),
            'httpProxy'      => $this->_kernel->getConfig('httpProxy'),
            'connectTimeout' => 15000,
            'readTimeout'    => 15000,
            'retry'          => [
                'maxAttempts' => 0,
            ],
        ];
        $_lastRequest   = null;
        $_lastException = null;
        $_now           = time();
        $_retryTimes    = 0;
        while (Tea::allowRetry(@$_runtime['retry'], $_retryTimes, $_now)) {
            if ($_retryTimes > 0) {
                $_backoffTime = Tea::getBackoffTime(@$_runtime['backoff'], $_retryTimes);

                if ($_backoffTime > 0) {
                    Tea::sleep($_backoffTime);
                }
            }
            $_retryTimes = $_retryTimes + 1;

            try {
                $_request     = new Request();
                $systemParams = [
                    'method'              => 'alipay.open.public.message.total.send',
                    'app_id'              => $this->_kernel->getConfig('appId'),
                    'timestamp'           => $this->_kernel->getTimestamp(),
                    'format'              => 'json',
                    'version'             => '1.0',
                    'alipay_sdk'          => $this->_kernel->getSdkVersion(),
                    'charset'             => 'UTF-8',
                    'sign_type'           => $this->_kernel->getConfig('signType'),
                    'app_cert_sn'         => $this->_kernel->getMerchantCertSN(),
                    'alipay_root_cert_sn' => $this->_kernel->getAlipayRootCertSN(),
                ];
                $textObj = new Text([
                    'title'   => '',
                    'content' => $text,
                ]);
                $bizParams = [
                    'msg_type' => 'text',
                    'text'     => $textObj,
                ];
                $textParams         = [];
                $_request->protocol = $this->_kernel->getConfig('protocol');
                $_request->method   = 'POST';
                $_request->pathname = '/gateway.do';
                $_request->headers  = [
                    'host'         => $this->_kernel->getConfig('gatewayHost'),
                    'content-type' => 'application/x-www-form-urlencoded;charset=utf-8',
                ];
                $_request->query = $this->_kernel->sortMap(Tea::merge([
                    'sign' => $this->_kernel->sign($systemParams, $bizParams, $textParams, $this->_kernel->getConfig('merchantPrivateKey')),
                ], $systemParams, $textParams));
                $_request->body = $this->_kernel->toUrlEncodedRequestBody($bizParams);
                $_lastRequest   = $_request;
                $_response      = Tea::send($_request, $_runtime);
                $respMap        = $this->_kernel->readAsJson($_response, 'alipay.open.public.message.total.send');

                if ($this->_kernel->isCertMode()) {
                    if ($this->_kernel->verify($respMap, $this->_kernel->extractAlipayPublicKey($this->_kernel->getAlipayCertSN($respMap)))) {
                        return AlipayOpenPublicMessageTotalSendResponse::fromMap($this->_kernel->toRespModel($respMap));
                    }
                } else {
                    if ($this->_kernel->verify($respMap, $this->_kernel->getConfig('alipayPublicKey'))) {
                        return AlipayOpenPublicMessageTotalSendResponse::fromMap($this->_kernel->toRespModel($respMap));
                    }
                }
                throw new TeaError([
                    'message' => '????????????????????????????????????????????????????????????',
                ]);
            } catch (Exception $e) {
                if (!($e instanceof TeaError)) {
                    $e = new TeaError([], $e->getMessage(), $e->getCode(), $e);
                }

                if (Tea::isRetryable($e)) {
                    $_lastException = $e;
                    continue;
                }
                throw $e;
            }
        }
        throw new TeaUnableRetryError($_lastRequest, $_lastException);
    }

    /**
     * @param Article[] $articles
     *
     * @throws TeaError
     * @throws Exception
     * @throws TeaUnableRetryError
     *
     * @return AlipayOpenPublicMessageTotalSendResponse
     */
    public function sendImageText($articles)
    {
        $_runtime = [
            'ignoreSSL'      => $this->_kernel->getConfig('ignoreSSL'),
            'httpProxy'      => $this->_kernel->getConfig('httpProxy'),
            'connectTimeout' => 15000,
            'readTimeout'    => 15000,
            'retry'          => [
                'maxAttempts' => 0,
            ],
        ];
        $_lastRequest   = null;
        $_lastException = null;
        $_now           = time();
        $_retryTimes    = 0;
        while (Tea::allowRetry(@$_runtime['retry'], $_retryTimes, $_now)) {
            if ($_retryTimes > 0) {
                $_backoffTime = Tea::getBackoffTime(@$_runtime['backoff'], $_retryTimes);

                if ($_backoffTime > 0) {
                    Tea::sleep($_backoffTime);
                }
            }
            $_retryTimes = $_retryTimes + 1;

            try {
                $_request     = new Request();
                $systemParams = [
                    'method'              => 'alipay.open.public.message.total.send',
                    'app_id'              => $this->_kernel->getConfig('appId'),
                    'timestamp'           => $this->_kernel->getTimestamp(),
                    'format'              => 'json',
                    'version'             => '1.0',
                    'alipay_sdk'          => $this->_kernel->getSdkVersion(),
                    'charset'             => 'UTF-8',
                    'sign_type'           => $this->_kernel->getConfig('signType'),
                    'app_cert_sn'         => $this->_kernel->getMerchantCertSN(),
                    'alipay_root_cert_sn' => $this->_kernel->getAlipayRootCertSN(),
                ];
                $bizParams = [
                    'msg_type' => 'image-text',
                    'articles' => $articles,
                ];
                $textParams         = [];
                $_request->protocol = $this->_kernel->getConfig('protocol');
                $_request->method   = 'POST';
                $_request->pathname = '/gateway.do';
                $_request->headers  = [
                    'host'         => $this->_kernel->getConfig('gatewayHost'),
                    'content-type' => 'application/x-www-form-urlencoded;charset=utf-8',
                ];
                $_request->query = $this->_kernel->sortMap(Tea::merge([
                    'sign' => $this->_kernel->sign($systemParams, $bizParams, $textParams, $this->_kernel->getConfig('merchantPrivateKey')),
                ], $systemParams, $textParams));
                $_request->body = $this->_kernel->toUrlEncodedRequestBody($bizParams);
                $_lastRequest   = $_request;
                $_response      = Tea::send($_request, $_runtime);
                $respMap        = $this->_kernel->readAsJson($_response, 'alipay.open.public.message.total.send');

                if ($this->_kernel->isCertMode()) {
                    if ($this->_kernel->verify($respMap, $this->_kernel->extractAlipayPublicKey($this->_kernel->getAlipayCertSN($respMap)))) {
                        return AlipayOpenPublicMessageTotalSendResponse::fromMap($this->_kernel->toRespModel($respMap));
                    }
                } else {
                    if ($this->_kernel->verify($respMap, $this->_kernel->getConfig('alipayPublicKey'))) {
                        return AlipayOpenPublicMessageTotalSendResponse::fromMap($this->_kernel->toRespModel($respMap));
                    }
                }
                throw new TeaError([
                    'message' => '????????????????????????????????????????????????????????????',
                ]);
            } catch (Exception $e) {
                if (!($e instanceof TeaError)) {
                    $e = new TeaError([], $e->getMessage(), $e->getCode(), $e);
                }

                if (Tea::isRetryable($e)) {
                    $_lastException = $e;
                    continue;
                }
                throw $e;
            }
        }
        throw new TeaUnableRetryError($_lastRequest, $_lastException);
    }

    /**
     * @param string   $toUserId
     * @param Template $template
     *
     * @throws TeaError
     * @throws Exception
     * @throws TeaUnableRetryError
     *
     * @return AlipayOpenPublicMessageSingleSendResponse
     */
    public function sendSingleMessage($toUserId, $template)
    {
        $template->validate();
        $_runtime = [
            'ignoreSSL'      => $this->_kernel->getConfig('ignoreSSL'),
            'httpProxy'      => $this->_kernel->getConfig('httpProxy'),
            'connectTimeout' => 15000,
            'readTimeout'    => 15000,
            'retry'          => [
                'maxAttempts' => 0,
            ],
        ];
        $_lastRequest   = null;
        $_lastException = null;
        $_now           = time();
        $_retryTimes    = 0;
        while (Tea::allowRetry(@$_runtime['retry'], $_retryTimes, $_now)) {
            if ($_retryTimes > 0) {
                $_backoffTime = Tea::getBackoffTime(@$_runtime['backoff'], $_retryTimes);

                if ($_backoffTime > 0) {
                    Tea::sleep($_backoffTime);
                }
            }
            $_retryTimes = $_retryTimes + 1;

            try {
                $_request     = new Request();
                $systemParams = [
                    'method'              => 'alipay.open.public.message.single.send',
                    'app_id'              => $this->_kernel->getConfig('appId'),
                    'timestamp'           => $this->_kernel->getTimestamp(),
                    'format'              => 'json',
                    'version'             => '1.0',
                    'alipay_sdk'          => $this->_kernel->getSdkVersion(),
                    'charset'             => 'UTF-8',
                    'sign_type'           => $this->_kernel->getConfig('signType'),
                    'app_cert_sn'         => $this->_kernel->getMerchantCertSN(),
                    'alipay_root_cert_sn' => $this->_kernel->getAlipayRootCertSN(),
                ];
                $bizParams = [
                    'to_user_id' => $toUserId,
                    'template'   => $template,
                ];
                $textParams         = [];
                $_request->protocol = $this->_kernel->getConfig('protocol');
                $_request->method   = 'POST';
                $_request->pathname = '/gateway.do';
                $_request->headers  = [
                    'host'         => $this->_kernel->getConfig('gatewayHost'),
                    'content-type' => 'application/x-www-form-urlencoded;charset=utf-8',
                ];
                $_request->query = $this->_kernel->sortMap(Tea::merge([
                    'sign' => $this->_kernel->sign($systemParams, $bizParams, $textParams, $this->_kernel->getConfig('merchantPrivateKey')),
                ], $systemParams, $textParams));
                $_request->body = $this->_kernel->toUrlEncodedRequestBody($bizParams);
                $_lastRequest   = $_request;
                $_response      = Tea::send($_request, $_runtime);
                $respMap        = $this->_kernel->readAsJson($_response, 'alipay.open.public.message.single.send');

                if ($this->_kernel->isCertMode()) {
                    if ($this->_kernel->verify($respMap, $this->_kernel->extractAlipayPublicKey($this->_kernel->getAlipayCertSN($respMap)))) {
                        return AlipayOpenPublicMessageSingleSendResponse::fromMap($this->_kernel->toRespModel($respMap));
                    }
                } else {
                    if ($this->_kernel->verify($respMap, $this->_kernel->getConfig('alipayPublicKey'))) {
                        return AlipayOpenPublicMessageSingleSendResponse::fromMap($this->_kernel->toRespModel($respMap));
                    }
                }
                throw new TeaError([
                    'message' => '????????????????????????????????????????????????????????????',
                ]);
            } catch (Exception $e) {
                if (!($e instanceof TeaError)) {
                    $e = new TeaError([], $e->getMessage(), $e->getCode(), $e);
                }

                if (Tea::isRetryable($e)) {
                    $_lastException = $e;
                    continue;
                }
                throw $e;
            }
        }
        throw new TeaUnableRetryError($_lastRequest, $_lastException);
    }

    /**
     * @param string $messageId
     *
     * @throws TeaError
     * @throws Exception
     * @throws TeaUnableRetryError
     *
     * @return AlipayOpenPublicLifeMsgRecallResponse
     */
    public function recallMessage($messageId)
    {
        $_runtime = [
            'ignoreSSL'      => $this->_kernel->getConfig('ignoreSSL'),
            'httpProxy'      => $this->_kernel->getConfig('httpProxy'),
            'connectTimeout' => 15000,
            'readTimeout'    => 15000,
            'retry'          => [
                'maxAttempts' => 0,
            ],
        ];
        $_lastRequest   = null;
        $_lastException = null;
        $_now           = time();
        $_retryTimes    = 0;
        while (Tea::allowRetry(@$_runtime['retry'], $_retryTimes, $_now)) {
            if ($_retryTimes > 0) {
                $_backoffTime = Tea::getBackoffTime(@$_runtime['backoff'], $_retryTimes);

                if ($_backoffTime > 0) {
                    Tea::sleep($_backoffTime);
                }
            }
            $_retryTimes = $_retryTimes + 1;

            try {
                $_request     = new Request();
                $systemParams = [
                    'method'              => 'alipay.open.public.life.msg.recall',
                    'app_id'              => $this->_kernel->getConfig('appId'),
                    'timestamp'           => $this->_kernel->getTimestamp(),
                    'format'              => 'json',
                    'version'             => '1.0',
                    'alipay_sdk'          => $this->_kernel->getSdkVersion(),
                    'charset'             => 'UTF-8',
                    'sign_type'           => $this->_kernel->getConfig('signType'),
                    'app_cert_sn'         => $this->_kernel->getMerchantCertSN(),
                    'alipay_root_cert_sn' => $this->_kernel->getAlipayRootCertSN(),
                ];
                $bizParams = [
                    'message_id' => $messageId,
                ];
                $textParams         = [];
                $_request->protocol = $this->_kernel->getConfig('protocol');
                $_request->method   = 'POST';
                $_request->pathname = '/gateway.do';
                $_request->headers  = [
                    'host'         => $this->_kernel->getConfig('gatewayHost'),
                    'content-type' => 'application/x-www-form-urlencoded;charset=utf-8',
                ];
                $_request->query = $this->_kernel->sortMap(Tea::merge([
                    'sign' => $this->_kernel->sign($systemParams, $bizParams, $textParams, $this->_kernel->getConfig('merchantPrivateKey')),
                ], $systemParams, $textParams));
                $_request->body = $this->_kernel->toUrlEncodedRequestBody($bizParams);
                $_lastRequest   = $_request;
                $_response      = Tea::send($_request, $_runtime);
                $respMap        = $this->_kernel->readAsJson($_response, 'alipay.open.public.life.msg.recall');

                if ($this->_kernel->isCertMode()) {
                    if ($this->_kernel->verify($respMap, $this->_kernel->extractAlipayPublicKey($this->_kernel->getAlipayCertSN($respMap)))) {
                        return AlipayOpenPublicLifeMsgRecallResponse::fromMap($this->_kernel->toRespModel($respMap));
                    }
                } else {
                    if ($this->_kernel->verify($respMap, $this->_kernel->getConfig('alipayPublicKey'))) {
                        return AlipayOpenPublicLifeMsgRecallResponse::fromMap($this->_kernel->toRespModel($respMap));
                    }
                }
                throw new TeaError([
                    'message' => '????????????????????????????????????????????????????????????',
                ]);
            } catch (Exception $e) {
                if (!($e instanceof TeaError)) {
                    $e = new TeaError([], $e->getMessage(), $e->getCode(), $e);
                }

                if (Tea::isRetryable($e)) {
                    $_lastException = $e;
                    continue;
                }
                throw $e;
            }
        }
        throw new TeaUnableRetryError($_lastRequest, $_lastException);
    }

    /**
     * @param string $primaryIndustryCode
     * @param string $primaryIndustryName
     * @param string $secondaryIndustryCode
     * @param string $secondaryIndustryName
     *
     * @throws TeaError
     * @throws Exception
     * @throws TeaUnableRetryError
     *
     * @return AlipayOpenPublicTemplateMessageIndustryModifyResponse
     */
    public function setIndustry($primaryIndustryCode, $primaryIndustryName, $secondaryIndustryCode, $secondaryIndustryName)
    {
        $_runtime = [
            'ignoreSSL'      => $this->_kernel->getConfig('ignoreSSL'),
            'httpProxy'      => $this->_kernel->getConfig('httpProxy'),
            'connectTimeout' => 15000,
            'readTimeout'    => 15000,
            'retry'          => [
                'maxAttempts' => 0,
            ],
        ];
        $_lastRequest   = null;
        $_lastException = null;
        $_now           = time();
        $_retryTimes    = 0;
        while (Tea::allowRetry(@$_runtime['retry'], $_retryTimes, $_now)) {
            if ($_retryTimes > 0) {
                $_backoffTime = Tea::getBackoffTime(@$_runtime['backoff'], $_retryTimes);

                if ($_backoffTime > 0) {
                    Tea::sleep($_backoffTime);
                }
            }
            $_retryTimes = $_retryTimes + 1;

            try {
                $_request     = new Request();
                $systemParams = [
                    'method'              => 'alipay.open.public.template.message.industry.modify',
                    'app_id'              => $this->_kernel->getConfig('appId'),
                    'timestamp'           => $this->_kernel->getTimestamp(),
                    'format'              => 'json',
                    'version'             => '1.0',
                    'alipay_sdk'          => $this->_kernel->getSdkVersion(),
                    'charset'             => 'UTF-8',
                    'sign_type'           => $this->_kernel->getConfig('signType'),
                    'app_cert_sn'         => $this->_kernel->getMerchantCertSN(),
                    'alipay_root_cert_sn' => $this->_kernel->getAlipayRootCertSN(),
                ];
                $bizParams = [
                    'primary_industry_code'   => $primaryIndustryCode,
                    'primary_industry_name'   => $primaryIndustryName,
                    'secondary_industry_code' => $secondaryIndustryCode,
                    'secondary_industry_name' => $secondaryIndustryName,
                ];
                $textParams         = [];
                $_request->protocol = $this->_kernel->getConfig('protocol');
                $_request->method   = 'POST';
                $_request->pathname = '/gateway.do';
                $_request->headers  = [
                    'host'         => $this->_kernel->getConfig('gatewayHost'),
                    'content-type' => 'application/x-www-form-urlencoded;charset=utf-8',
                ];
                $_request->query = $this->_kernel->sortMap(Tea::merge([
                    'sign' => $this->_kernel->sign($systemParams, $bizParams, $textParams, $this->_kernel->getConfig('merchantPrivateKey')),
                ], $systemParams, $textParams));
                $_request->body = $this->_kernel->toUrlEncodedRequestBody($bizParams);
                $_lastRequest   = $_request;
                $_response      = Tea::send($_request, $_runtime);
                $respMap        = $this->_kernel->readAsJson($_response, 'alipay.open.public.template.message.industry.modify');

                if ($this->_kernel->isCertMode()) {
                    if ($this->_kernel->verify($respMap, $this->_kernel->extractAlipayPublicKey($this->_kernel->getAlipayCertSN($respMap)))) {
                        return AlipayOpenPublicTemplateMessageIndustryModifyResponse::fromMap($this->_kernel->toRespModel($respMap));
                    }
                } else {
                    if ($this->_kernel->verify($respMap, $this->_kernel->getConfig('alipayPublicKey'))) {
                        return AlipayOpenPublicTemplateMessageIndustryModifyResponse::fromMap($this->_kernel->toRespModel($respMap));
                    }
                }
                throw new TeaError([
                    'message' => '????????????????????????????????????????????????????????????',
                ]);
            } catch (Exception $e) {
                if (!($e instanceof TeaError)) {
                    $e = new TeaError([], $e->getMessage(), $e->getCode(), $e);
                }

                if (Tea::isRetryable($e)) {
                    $_lastException = $e;
                    continue;
                }
                throw $e;
            }
        }
        throw new TeaUnableRetryError($_lastRequest, $_lastException);
    }

    /**
     * @throws TeaError
     * @throws Exception
     * @throws TeaUnableRetryError
     *
     * @return AlipayOpenPublicSettingCategoryQueryResponse
     */
    public function getIndustry()
    {
        $_runtime = [
            'ignoreSSL'      => $this->_kernel->getConfig('ignoreSSL'),
            'httpProxy'      => $this->_kernel->getConfig('httpProxy'),
            'connectTimeout' => 15000,
            'readTimeout'    => 15000,
            'retry'          => [
                'maxAttempts' => 0,
            ],
        ];
        $_lastRequest   = null;
        $_lastException = null;
        $_now           = time();
        $_retryTimes    = 0;
        while (Tea::allowRetry(@$_runtime['retry'], $_retryTimes, $_now)) {
            if ($_retryTimes > 0) {
                $_backoffTime = Tea::getBackoffTime(@$_runtime['backoff'], $_retryTimes);

                if ($_backoffTime > 0) {
                    Tea::sleep($_backoffTime);
                }
            }
            $_retryTimes = $_retryTimes + 1;

            try {
                $_request     = new Request();
                $systemParams = [
                    'method'              => 'alipay.open.public.setting.category.query',
                    'app_id'              => $this->_kernel->getConfig('appId'),
                    'timestamp'           => $this->_kernel->getTimestamp(),
                    'format'              => 'json',
                    'version'             => '1.0',
                    'alipay_sdk'          => $this->_kernel->getSdkVersion(),
                    'charset'             => 'UTF-8',
                    'sign_type'           => $this->_kernel->getConfig('signType'),
                    'app_cert_sn'         => $this->_kernel->getMerchantCertSN(),
                    'alipay_root_cert_sn' => $this->_kernel->getAlipayRootCertSN(),
                ];
                $bizParams          = [];
                $textParams         = [];
                $_request->protocol = $this->_kernel->getConfig('protocol');
                $_request->method   = 'POST';
                $_request->pathname = '/gateway.do';
                $_request->headers  = [
                    'host'         => $this->_kernel->getConfig('gatewayHost'),
                    'content-type' => 'application/x-www-form-urlencoded;charset=utf-8',
                ];
                $_request->query = $this->_kernel->sortMap(Tea::merge([
                    'sign' => $this->_kernel->sign($systemParams, $bizParams, $textParams, $this->_kernel->getConfig('merchantPrivateKey')),
                ], $systemParams, $textParams));
                $_request->body = $this->_kernel->toUrlEncodedRequestBody($bizParams);
                $_lastRequest   = $_request;
                $_response      = Tea::send($_request, $_runtime);
                $respMap        = $this->_kernel->readAsJson($_response, 'alipay.open.public.setting.category.query');

                if ($this->_kernel->isCertMode()) {
                    if ($this->_kernel->verify($respMap, $this->_kernel->extractAlipayPublicKey($this->_kernel->getAlipayCertSN($respMap)))) {
                        return AlipayOpenPublicSettingCategoryQueryResponse::fromMap($this->_kernel->toRespModel($respMap));
                    }
                } else {
                    if ($this->_kernel->verify($respMap, $this->_kernel->getConfig('alipayPublicKey'))) {
                        return AlipayOpenPublicSettingCategoryQueryResponse::fromMap($this->_kernel->toRespModel($respMap));
                    }
                }
                throw new TeaError([
                    'message' => '????????????????????????????????????????????????????????????',
                ]);
            } catch (Exception $e) {
                if (!($e instanceof TeaError)) {
                    $e = new TeaError([], $e->getMessage(), $e->getCode(), $e);
                }

                if (Tea::isRetryable($e)) {
                    $_lastException = $e;
                    continue;
                }
                throw $e;
            }
        }
        throw new TeaUnableRetryError($_lastRequest, $_lastException);
    }

    /**
     * ISV????????????????????????appAuthToken.
     *
     * @param $appAuthToken String ?????????token
     *
     * @return $this ?????????????????????????????????
     */
    public function agent($appAuthToken)
    {
        $this->_kernel->injectTextParam('app_auth_token', $appAuthToken);

        return $this;
    }

    /**
     * ???????????????????????????authToken.
     *
     * @param $authToken String ????????????token
     *
     * @return $this
     */
    public function auth($authToken)
    {
        $this->_kernel->injectTextParam('auth_token', $authToken);

        return $this;
    }

    /**
     * ?????????????????????????????????????????????????????????????????????Config??????????????????.
     *
     * @param $url String ????????????????????????????????????https://www.test.com/callback
     *
     * @return $this
     */
    public function asyncNotify($url)
    {
        $this->_kernel->injectTextParam('notify_url', $url);

        return $this;
    }

    /**
     * ????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????.
     *
     * @param $testUrl String ????????????????????????
     *
     * @return $this
     */
    public function route($testUrl)
    {
        $this->_kernel->injectTextParam('ws_service_url', $testUrl);

        return $this;
    }

    /**
     * ??????API????????????????????????????????????????????????(biz_content????????????).
     *
     * @param $key   String ???????????????????????????biz_content????????????????????????timeout_express???
     * @param $value object ???????????????????????????????????????????????????JSON?????????
     *               ??????????????????????????????????????????String???Price???Date???SDK?????????????????????????????????String??????
     *               ???????????????????????????????????????????????????Number???????????????Long??????
     *               ?????????????????????????????????????????????????????????array???????????????????????????
     *               ??????????????????????????????????????????array???????????????
     *
     * @return $this
     */
    public function optional($key, $value)
    {
        $this->_kernel->injectBizParam($key, $value);

        return $this;
    }

    /**
     * ????????????API????????????????????????????????????????????????(biz_content????????????)
     * optional?????????????????????.
     *
     * @param $optionalArgs array ????????????????????????????????????key???value?????????key???value??????????????????optional???????????????
     *
     * @return $this
     */
    public function batchOptional($optionalArgs)
    {
        foreach ($optionalArgs as $key => $value) {
            $this->_kernel->injectBizParam($key, $value);
        }

        return $this;
    }
}
