<?php

namespace EasyAliSdk\Domain\Payment\Common;

use Exception;
use AlibabaCloud\Tea\Tea;
use AlibabaCloud\Tea\Request;
use AlibabaCloud\Tea\Exception\TeaError;
use AlibabaCloud\Tea\Exception\TeaUnableRetryError;
use EasyAliSdk\Domain\Payment\Common\Models\AlipayTradeCloseResponse;
use EasyAliSdk\Domain\Payment\Common\Models\AlipayTradeQueryResponse;
use EasyAliSdk\Domain\Payment\Common\Models\AlipayTradeCancelResponse;
use EasyAliSdk\Domain\Payment\Common\Models\AlipayTradeCreateResponse;
use EasyAliSdk\Domain\Payment\Common\Models\AlipayTradeRefundResponse;
use EasyAliSdk\Domain\Payment\Common\Models\AlipayTradeFastpayRefundQueryResponse;
use EasyAliSdk\Domain\Payment\Common\Models\AlipayDataDataserviceBillDownloadurlQueryResponse;

class Client
{
    protected $_kernel;

    public function __construct($kernel)
    {
        $this->_kernel = $kernel;
    }

    /**
     * @param string $subject
     * @param string $outTradeNo
     * @param string $totalAmount
     * @param string $buyerId
     *
     * @throws TeaError
     * @throws Exception
     * @throws TeaUnableRetryError
     *
     * @return AlipayTradeCreateResponse
     */
    public function create($subject, $outTradeNo, $totalAmount, $buyerId)
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
                    'method'              => 'alipay.trade.create',
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
                    'subject'      => $subject,
                    'out_trade_no' => $outTradeNo,
                    'total_amount' => $totalAmount,
                    'buyer_id'     => $buyerId,
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
                $respMap        = $this->_kernel->readAsJson($_response, 'alipay.trade.create');

                if ($this->_kernel->isCertMode()) {
                    if ($this->_kernel->verify($respMap, $this->_kernel->extractAlipayPublicKey($this->_kernel->getAlipayCertSN($respMap)))) {
                        return AlipayTradeCreateResponse::fromMap($this->_kernel->toRespModel($respMap));
                    }
                } else {
                    if ($this->_kernel->verify($respMap, $this->_kernel->getConfig('alipayPublicKey'))) {
                        return AlipayTradeCreateResponse::fromMap($this->_kernel->toRespModel($respMap));
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
     * @param string $outTradeNo
     *
     * @throws TeaError
     * @throws Exception
     * @throws TeaUnableRetryError
     *
     * @return AlipayTradeQueryResponse
     */
    public function query($outTradeNo)
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
                    'method'              => 'alipay.trade.query',
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
                    'out_trade_no' => $outTradeNo,
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
                $respMap        = $this->_kernel->readAsJson($_response, 'alipay.trade.query');

                if ($this->_kernel->isCertMode()) {
                    if ($this->_kernel->verify($respMap, $this->_kernel->extractAlipayPublicKey($this->_kernel->getAlipayCertSN($respMap)))) {
                        return AlipayTradeQueryResponse::fromMap($this->_kernel->toRespModel($respMap));
                    }
                } else {
                    if ($this->_kernel->verify($respMap, $this->_kernel->getConfig('alipayPublicKey'))) {
                        return AlipayTradeQueryResponse::fromMap($this->_kernel->toRespModel($respMap));
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
     * @param string $outTradeNo
     * @param string $refundAmount
     *
     * @throws TeaError
     * @throws Exception
     * @throws TeaUnableRetryError
     *
     * @return AlipayTradeRefundResponse
     */
    public function refund($outTradeNo, $refundAmount)
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
                    'method'              => 'alipay.trade.refund',
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
                    'out_trade_no'  => $outTradeNo,
                    'refund_amount' => $refundAmount,
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
                $respMap        = $this->_kernel->readAsJson($_response, 'alipay.trade.refund');

                if ($this->_kernel->isCertMode()) {
                    if ($this->_kernel->verify($respMap, $this->_kernel->extractAlipayPublicKey($this->_kernel->getAlipayCertSN($respMap)))) {
                        return AlipayTradeRefundResponse::fromMap($this->_kernel->toRespModel($respMap));
                    }
                } else {
                    if ($this->_kernel->verify($respMap, $this->_kernel->getConfig('alipayPublicKey'))) {
                        return AlipayTradeRefundResponse::fromMap($this->_kernel->toRespModel($respMap));
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
     * @param string $outTradeNo
     *
     * @throws TeaError
     * @throws Exception
     * @throws TeaUnableRetryError
     *
     * @return AlipayTradeCloseResponse
     */
    public function close($outTradeNo)
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
                    'method'              => 'alipay.trade.close',
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
                    'out_trade_no' => $outTradeNo,
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
                $respMap        = $this->_kernel->readAsJson($_response, 'alipay.trade.close');

                if ($this->_kernel->isCertMode()) {
                    if ($this->_kernel->verify($respMap, $this->_kernel->extractAlipayPublicKey($this->_kernel->getAlipayCertSN($respMap)))) {
                        return AlipayTradeCloseResponse::fromMap($this->_kernel->toRespModel($respMap));
                    }
                } else {
                    if ($this->_kernel->verify($respMap, $this->_kernel->getConfig('alipayPublicKey'))) {
                        return AlipayTradeCloseResponse::fromMap($this->_kernel->toRespModel($respMap));
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
     * @param string $outTradeNo
     *
     * @throws TeaError
     * @throws Exception
     * @throws TeaUnableRetryError
     *
     * @return AlipayTradeCancelResponse
     */
    public function cancel($outTradeNo)
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
                    'method'              => 'alipay.trade.cancel',
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
                    'out_trade_no' => $outTradeNo,
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
                $respMap        = $this->_kernel->readAsJson($_response, 'alipay.trade.cancel');

                if ($this->_kernel->isCertMode()) {
                    if ($this->_kernel->verify($respMap, $this->_kernel->extractAlipayPublicKey($this->_kernel->getAlipayCertSN($respMap)))) {
                        return AlipayTradeCancelResponse::fromMap($this->_kernel->toRespModel($respMap));
                    }
                } else {
                    if ($this->_kernel->verify($respMap, $this->_kernel->getConfig('alipayPublicKey'))) {
                        return AlipayTradeCancelResponse::fromMap($this->_kernel->toRespModel($respMap));
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
     * @param string $outTradeNo
     * @param string $outRequestNo
     *
     * @throws TeaError
     * @throws Exception
     * @throws TeaUnableRetryError
     *
     * @return AlipayTradeFastpayRefundQueryResponse
     */
    public function queryRefund($outTradeNo, $outRequestNo)
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
                    'method'              => 'alipay.trade.fastpay.refund.query',
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
                    'out_trade_no'   => $outTradeNo,
                    'out_request_no' => $outRequestNo,
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
                $respMap        = $this->_kernel->readAsJson($_response, 'alipay.trade.fastpay.refund.query');

                if ($this->_kernel->isCertMode()) {
                    if ($this->_kernel->verify($respMap, $this->_kernel->extractAlipayPublicKey($this->_kernel->getAlipayCertSN($respMap)))) {
                        return AlipayTradeFastpayRefundQueryResponse::fromMap($this->_kernel->toRespModel($respMap));
                    }
                } else {
                    if ($this->_kernel->verify($respMap, $this->_kernel->getConfig('alipayPublicKey'))) {
                        return AlipayTradeFastpayRefundQueryResponse::fromMap($this->_kernel->toRespModel($respMap));
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
     * @param string $billType
     * @param string $billDate
     *
     * @throws TeaError
     * @throws Exception
     * @throws TeaUnableRetryError
     *
     * @return AlipayDataDataserviceBillDownloadurlQueryResponse
     */
    public function downloadBill($billType, $billDate)
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
                    'method'              => 'alipay.data.dataservice.bill.downloadurl.query',
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
                    'bill_type' => $billType,
                    'bill_date' => $billDate,
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
                $respMap        = $this->_kernel->readAsJson($_response, 'alipay.data.dataservice.bill.downloadurl.query');

                if ($this->_kernel->isCertMode()) {
                    if ($this->_kernel->verify($respMap, $this->_kernel->extractAlipayPublicKey($this->_kernel->getAlipayCertSN($respMap)))) {
                        return AlipayDataDataserviceBillDownloadurlQueryResponse::fromMap($this->_kernel->toRespModel($respMap));
                    }
                } else {
                    if ($this->_kernel->verify($respMap, $this->_kernel->getConfig('alipayPublicKey'))) {
                        return AlipayDataDataserviceBillDownloadurlQueryResponse::fromMap($this->_kernel->toRespModel($respMap));
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
     * @param string[] $parameters
     *
     * @return bool
     */
    public function verifyNotify($parameters)
    {
        if ($this->_kernel->isCertMode()) {
            return $this->_kernel->verifyParams($parameters, $this->_kernel->extractAlipayPublicKey(''));
        }

        return $this->_kernel->verifyParams($parameters, $this->_kernel->getConfig('alipayPublicKey'));
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
