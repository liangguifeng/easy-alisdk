<?php

namespace EasyAliSdk\Domain\Marketing\Card;

use EasyAliSdk\Domain\Marketing\Card\Models\AlipayMemberCardTemplateModifySendResponse;
use Exception;
use AlibabaCloud\Tea\Tea;
use AlibabaCloud\Tea\Request;
use AlibabaCloud\Tea\Exception\TeaError;
use AlibabaCloud\Tea\Exception\TeaUnableRetryError;
use EasyAliSdk\Domain\Marketing\Card\Models\AlipayMemberCardOpenSendResponse;
use EasyAliSdk\Domain\Marketing\Card\Models\AlipayMemberCardTemplateCreateSendResponse;
use EasyAliSdk\Domain\Marketing\Card\Models\AlipayMemberCardTemplateFormSetSendResponse;
use EasyAliSdk\Domain\Marketing\Card\Models\AlipayMemberCardActivateUrlApplySendResponse;
use EasyAliSdk\Domain\Marketing\Card\Models\AlipayMemberCardActivateFormQuerySendResponse;

class Client
{
    protected $_kernel;

    public function __construct($kernel)
    {
        $this->_kernel = $kernel;
    }

    /**
     * 创建会员卡模板
     *
     * @param $requestId
     * @param $cardType
     * @param $bizNoSuffixLen
     * @param $writeOffType
     * @param null $bizNoPrefix
     * @param null $cardSpecTag
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @return AlipayMemberCardTemplateCreateSendResponse
     */
    public function templateCreate(
        $requestId,
        $cardType,
        $bizNoSuffixLen,
        $writeOffType,
        array $templateStyleInfo,
        array $columnInfoList,
        array $fieldRuleList,
        array $templateBenefitInfo = [],
        array $cardActionList = [],
        array $openCardConf = [],
        array $shopIds = [],
        array $pubChannels = [],
        array $cardLevelConf = [],
        array $mdcodeNotifyConf = [],
        $bizNoPrefix = null,
        $cardSpecTag = null
    ) {
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
                    'method'              => 'alipay.marketing.card.template.create',
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
                    'request_id'            => $requestId,
                    'card_type'             => $cardType,
                    'biz_no_suffix_len'     => $bizNoSuffixLen,
                    'write_off_type'        => $writeOffType,
                    'template_style_info'   => $templateStyleInfo,
                    'column_info_list'      => $columnInfoList,
                    'field_rule_list'       => $fieldRuleList,
                    'biz_no_prefix'         => $bizNoPrefix,
                    'card_action_list'      => $cardActionList,
                ];

                if (!empty($templateBenefitInfo)) {
                    $bizParams['template_benefit_info'] = $templateBenefitInfo;
                }

                if (!empty($bizNoPrefix)) {
                    $bizParams['biz_no_prefix'] = $bizNoPrefix;
                }

                if (!empty($cardActionList)) {
                    $bizParams['card_action_list'] = $cardActionList;
                }

                if (!empty($openCardConf)) {
                    $bizParams['open_card_conf'] = $openCardConf;
                }

                if (!empty($shopIds)) {
                    $bizParams['shop_ids'] = $shopIds;
                }

                if (!empty($pubChannels)) {
                    $bizParams['pub_channels'] = [
                        $pubChannels,
                    ];
                }

                if (!empty($cardLevelConf)) {
                    $bizParams['card_level_conf'] = [
                        $cardLevelConf,
                    ];
                }

                if (!empty($mdcodeNotifyConf)) {
                    $bizParams['mdcode_notify_conf'] = $mdcodeNotifyConf;
                }

                if (!empty($cardSpecTag)) {
                    $bizParams['card_spec_tag'] = $cardSpecTag;
                }

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
                $respMap        = $this->_kernel->readAsJson($_response, 'alipay.marketing.card.template.create');

                if ($this->_kernel->isCertMode()) {
                    if ($this->_kernel->verify($respMap, $this->_kernel->extractAlipayPublicKey($this->_kernel->getAlipayCertSN($respMap)))) {
                        return AlipayMemberCardTemplateCreateSendResponse::fromMap($this->_kernel->toRespModel($respMap));
                    }
                } else {
                    if ($this->_kernel->verify($respMap, $this->_kernel->getConfig('alipayPublicKey'))) {
                        return AlipayMemberCardTemplateCreateSendResponse::fromMap($this->_kernel->toRespModel($respMap));
                    }
                }
                throw new TeaError([
                    'message' => '验签失败，请检查支付宝公钥设置是否正确。',
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
     * 修改会员卡模板
     *
     * @param $requestId
     * @param $templateId
     * @param $bizNoSuffixLen
     * @param $writeOffType
     * @param null $bizNoPrefix
     * @param null $cardSpecTag
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @return AlipayMemberCardTemplateModifySendResponse
     */
    public function templateModify(
        $requestId,
        $templateId,
        $writeOffType,
        array $templateStyleInfo,
        array $columnInfoList,
        array $fieldRuleList,
        array $templateBenefitInfo = [],
        array $cardActionList = [],
        array $openCardConf = [],
        array $shopIds = [],
        array $pubChannels = [],
        array $cardLevelConf = [],
        array $mdcodeNotifyConf = [],
        $bizNoPrefix = null,
        $cardSpecTag = null
    ) {
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
                    'method'              => 'alipay.marketing.card.template.modify',
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
                    'request_id'          => $requestId,
                    'template_id'         => $templateId,
                    'write_off_type'      => $writeOffType,
                    'template_style_info' => $templateStyleInfo,
                    'column_info_list'    => $columnInfoList,
                    'field_rule_list'     => $fieldRuleList,
                    'biz_no_prefix'       => $bizNoPrefix,
                    'card_action_list'    => $cardActionList,
                ];

                if (!empty($templateBenefitInfo)) {
                    $bizParams['template_benefit_info'] = $templateBenefitInfo;
                }

                if (!empty($bizNoPrefix)) {
                    $bizParams['biz_no_prefix'] = $bizNoPrefix;
                }

                if (!empty($cardActionList)) {
                    $bizParams['card_action_list'] = $cardActionList;
                }

                if (!empty($openCardConf)) {
                    $bizParams['open_card_conf'] = $openCardConf;
                }

                if (!empty($shopIds)) {
                    $bizParams['shop_ids'] = $shopIds;
                }

                if (!empty($pubChannels)) {
                    $bizParams['pub_channels'] = [
                        $pubChannels,
                    ];
                }

                if (!empty($cardLevelConf)) {
                    $bizParams['card_level_conf'] = [
                        $cardLevelConf,
                    ];
                }

                if (!empty($mdcodeNotifyConf)) {
                    $bizParams['mdcode_notify_conf'] = $mdcodeNotifyConf;
                }

                if (!empty($cardSpecTag)) {
                    $bizParams['card_spec_tag'] = $cardSpecTag;
                }

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
                $respMap        = $this->_kernel->readAsJson($_response, 'alipay.marketing.card.template.modify');

                if ($this->_kernel->isCertMode()) {
                    if ($this->_kernel->verify($respMap, $this->_kernel->extractAlipayPublicKey($this->_kernel->getAlipayCertSN($respMap)))) {
                        return AlipayMemberCardTemplateModifySendResponse::fromMap($this->_kernel->toRespModel($respMap));
                    }
                } else {
                    if ($this->_kernel->verify($respMap, $this->_kernel->getConfig('alipayPublicKey'))) {
                        return AlipayMemberCardTemplateModifySendResponse::fromMap($this->_kernel->toRespModel($respMap));
                    }
                }
                throw new TeaError([
                    'message' => '验签失败，请检查支付宝公钥设置是否正确。',
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
     * 会员卡表单模板配置.
     *
     * @param $requestId
     * @param $cardType
     * @param $bizNoSuffixLen
     * @param $writeOffType
     * @param null  $bizNoPrefix
     * @param null  $cardSpecTag
     * @param mixed $templateId
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @return AlipayMemberCardTemplateFormSetSendResponse
     */
    public function templateForm($templateId, array $fields)
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
                    'method'              => 'alipay.marketing.card.formtemplate.set',
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
                    'template_id' => $templateId,
                    'fields'      => $fields,
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
                $respMap        = $this->_kernel->readAsJson($_response, 'alipay.marketing.card.formtemplate.set');

                if ($this->_kernel->isCertMode()) {
                    if ($this->_kernel->verify($respMap, $this->_kernel->extractAlipayPublicKey($this->_kernel->getAlipayCertSN($respMap)))) {
                        return AlipayMemberCardTemplateFormSetSendResponse::fromMap($this->_kernel->toRespModel($respMap));
                    }
                } else {
                    if ($this->_kernel->verify($respMap, $this->_kernel->getConfig('alipayPublicKey'))) {
                        return AlipayMemberCardTemplateFormSetSendResponse::fromMap($this->_kernel->toRespModel($respMap));
                    }
                }
                throw new TeaError([
                    'message' => '验签失败，请检查支付宝公钥设置是否正确。',
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
     * 获取会员卡领卡投放链接.
     *
     * @param $requestId
     * @param $cardType
     * @param $bizNoSuffixLen
     * @param $writeOffType
     * @param null  $bizNoPrefix
     * @param null  $cardSpecTag
     * @param mixed $templateId
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @return AlipayMemberCardActivateUrlApplySendResponse
     */
    public function activateUrl(string $templateId, string $outString = null, string $callback = null, string $followAppId = null)
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
                    'method'              => 'alipay.marketing.card.activateurl.apply',
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
                    'template_id' => $templateId,
                ];

                if (!empty($outString)) {
                    $bizParams['out_string'] = $outString;
                }

                if (!empty($callback)) {
                    $bizParams['callback'] = $callback;
                }

                if (!empty($followAppId)) {
                    $bizParams['follow_app_id'] = $followAppId;
                }

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
                $respMap        = $this->_kernel->readAsJson($_response, 'alipay.marketing.card.activateurl.apply');

                if ($this->_kernel->isCertMode()) {
                    if ($this->_kernel->verify($respMap, $this->_kernel->extractAlipayPublicKey($this->_kernel->getAlipayCertSN($respMap)))) {
                        return AlipayMemberCardActivateUrlApplySendResponse::fromMap($this->_kernel->toRespModel($respMap));
                    }
                } else {
                    if ($this->_kernel->verify($respMap, $this->_kernel->getConfig('alipayPublicKey'))) {
                        return AlipayMemberCardActivateUrlApplySendResponse::fromMap($this->_kernel->toRespModel($respMap));
                    }
                }
                throw new TeaError([
                    'message' => '验签失败，请检查支付宝公钥设置是否正确。',
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
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @return AlipayMemberCardActivateFormQuerySendResponse
     */
    public function activateForm(string $bizType, string $templateId, string $requestId)
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
                    'method'              => 'alipay.marketing.card.activateform.query',
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
                    'biz_type'    => $bizType,
                    'template_id' => $templateId,
                    'request_id'  => $requestId,
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
                $respMap        = $this->_kernel->readAsJson($_response, 'alipay.marketing.card.activateform.query');

                if ($this->_kernel->isCertMode()) {
                    if ($this->_kernel->verify($respMap, $this->_kernel->extractAlipayPublicKey($this->_kernel->getAlipayCertSN($respMap)))) {
                        return AlipayMemberCardActivateFormQuerySendResponse::fromMap($this->_kernel->toRespModel($respMap));
                    }
                } else {
                    if ($this->_kernel->verify($respMap, $this->_kernel->getConfig('alipayPublicKey'))) {
                        return AlipayMemberCardActivateFormQuerySendResponse::fromMap($this->_kernel->toRespModel($respMap));
                    }
                }
                throw new TeaError([
                    'message' => '验签失败，请检查支付宝公钥设置是否正确。',
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
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @return AlipayMemberCardActivateFormQuerySendResponse|AlipayMemberCardOpenSendResponse
     */
    public function open(
        string $outSerialNo,
        string $cardTemplateId,
        array $cardUserInfo,
        array $cardExtInfo,
        array $memberExtInfo = [],
        string $openCardChannel = null,
        string $openCardChannelId = null
    ) {
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
                    'method'              => 'alipay.marketing.card.open',
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
                    'out_serial_no'    => $outSerialNo,
                    'card_template_id' => $cardTemplateId,
                    'card_user_info'   => $cardUserInfo,
                    'card_ext_info'    => $cardExtInfo,
                ];

                if (!empty($memberExtInfo)) {
                    $bizParams['member_ext_info'] = $memberExtInfo;
                }

                if (!empty($openCardChannel)) {
                    $bizParams['open_card_channel'] = $openCardChannel;
                }

                if (!empty($openCardChannelId)) {
                    $bizParams['open_card_channel_id'] = $openCardChannelId;
                }

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
                $respMap        = $this->_kernel->readAsJson($_response, 'alipay.marketing.card.open');

                if ($this->_kernel->isCertMode()) {
                    if ($this->_kernel->verify($respMap, $this->_kernel->extractAlipayPublicKey($this->_kernel->getAlipayCertSN($respMap)))) {
                        return AlipayMemberCardOpenSendResponse::fromMap($this->_kernel->toRespModel($respMap));
                    }
                } else {
                    if ($this->_kernel->verify($respMap, $this->_kernel->getConfig('alipayPublicKey'))) {
                        return AlipayMemberCardOpenSendResponse::fromMap($this->_kernel->toRespModel($respMap));
                    }
                }
                throw new TeaError([
                    'message' => '验签失败，请检查支付宝公钥设置是否正确。',
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
     * ISV代商户代用，指定appAuthToken.
     *
     * @param $appAuthToken String 代调用token
     *
     * @return $this 本客户端，便于链式调用
     */
    public function agent($appAuthToken)
    {
        $this->_kernel->injectTextParam('app_auth_token', $appAuthToken);

        return $this;
    }

    /**
     * 用户授权调用，指定authToken.
     *
     * @param $authToken String 用户授权token
     *
     * @return $this
     */
    public function auth($authToken)
    {
        $this->_kernel->injectTextParam('auth_token', $authToken);

        return $this;
    }

    /**
     * 设置异步通知回调地址，此处设置将在本调用中覆盖Config中的全局配置.
     *
     * @param $url String 异步通知回调地址，例如：https://www.test.com/callback
     *
     * @return $this
     */
    public function asyncNotify($url)
    {
        $this->_kernel->injectTextParam('notify_url', $url);

        return $this;
    }

    /**
     * 将本次调用强制路由到后端系统的测试地址上，常用于线下环境内外联调，沙箱与线上环境设置无效.
     *
     * @param $testUrl String 后端系统测试地址
     *
     * @return $this
     */
    public function route($testUrl)
    {
        $this->_kernel->injectTextParam('ws_service_url', $testUrl);

        return $this;
    }

    /**
     * 设置API入参中没有的其他可选业务请求参数(biz_content下的字段).
     *
     * @param $key   String 业务请求参数名称（biz_content下的字段名，比如timeout_express）
     * @param $value object 业务请求参数的值，一个可以序列化成JSON的对象
     *               如果该字段是一个字符串类型（String、Price、Date在SDK中都是字符串），请使用String储存
     *               如果该字段是一个数值型类型（比如：Number），请使用Long储存
     *               如果该字段是一个复杂类型，请使用嵌套的array指定各下级字段的值
     *               如果该字段是一个数组，请使用array储存各个值
     *
     * @return $this
     */
    public function optional($key, $value)
    {
        $this->_kernel->injectBizParam($key, $value);

        return $this;
    }

    /**
     * 批量设置API入参中没有的其他可选业务请求参数(biz_content下的字段)
     * optional方法的批量版本.
     *
     * @param $optionalArgs array 可选参数集合，每个参数由key和value组成，key和value的格式请参见optional方法的注释
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
