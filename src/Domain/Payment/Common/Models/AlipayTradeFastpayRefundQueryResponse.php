<?php

namespace EasyAliSdk\Domain\Payment\Common\Models;

use AlibabaCloud\Tea\Model;

class AlipayTradeFastpayRefundQueryResponse extends Model
{
    /**
     * @description 响应原始字符串
     *
     * @var string
     */
    public $httpBody;

    /**
     * @var string
     */
    public $code;

    /**
     * @var string
     */
    public $msg;

    /**
     * @var string
     */
    public $subCode;

    /**
     * @var string
     */
    public $subMsg;

    /**
     * @var string
     */
    public $errorCode;

    /**
     * @var string
     */
    public $gmtRefundPay;

    /**
     * @var string
     */
    public $industrySepcDetail;

    /**
     * @var string
     */
    public $outRequestNo;

    /**
     * @var string
     */
    public $outTradeNo;

    /**
     * @var string
     */
    public $presentRefundBuyerAmount;

    /**
     * @var string
     */
    public $presentRefundDiscountAmount;

    /**
     * @var string
     */
    public $presentRefundMdiscountAmount;

    /**
     * @var string
     */
    public $refundAmount;

    /**
     * @var string
     */
    public $refundChargeAmount;

    /**
     * @var TradeFundBill[]
     */
    public $refundDetailItemList;

    /**
     * @var string
     */
    public $refundReason;

    /**
     * @var RefundRoyaltyResult[]
     */
    public $refundRoyaltys;

    /**
     * @var string
     */
    public $refundSettlementId;

    /**
     * @var string
     */
    public $refundStatus;

    /**
     * @var string
     */
    public $sendBackFee;

    /**
     * @var string
     */
    public $totalAmount;

    /**
     * @var string
     */
    public $tradeNo;

    /**
     * @var string[]
     */
    protected $_name = [
        'httpBody'                     => 'http_body',
        'code'                         => 'code',
        'msg'                          => 'msg',
        'subCode'                      => 'sub_code',
        'subMsg'                       => 'sub_msg',
        'errorCode'                    => 'error_code',
        'gmtRefundPay'                 => 'gmt_refund_pay',
        'industrySepcDetail'           => 'industry_sepc_detail',
        'outRequestNo'                 => 'out_request_no',
        'outTradeNo'                   => 'out_trade_no',
        'presentRefundBuyerAmount'     => 'present_refund_buyer_amount',
        'presentRefundDiscountAmount'  => 'present_refund_discount_amount',
        'presentRefundMdiscountAmount' => 'present_refund_mdiscount_amount',
        'refundAmount'                 => 'refund_amount',
        'refundChargeAmount'           => 'refund_charge_amount',
        'refundDetailItemList'         => 'refund_detail_item_list',
        'refundReason'                 => 'refund_reason',
        'refundRoyaltys'               => 'refund_royaltys',
        'refundSettlementId'           => 'refund_settlement_id',
        'refundStatus'                 => 'refund_status',
        'sendBackFee'                  => 'send_back_fee',
        'totalAmount'                  => 'total_amount',
        'tradeNo'                      => 'trade_no',
    ];

    public function validate()
    {
        Model::validateRequired('httpBody', $this->httpBody, true);
        Model::validateRequired('code', $this->code, true);
        Model::validateRequired('msg', $this->msg, true);
        Model::validateRequired('subCode', $this->subCode, true);
        Model::validateRequired('subMsg', $this->subMsg, true);
        Model::validateRequired('errorCode', $this->errorCode, true);
        Model::validateRequired('gmtRefundPay', $this->gmtRefundPay, true);
        Model::validateRequired('industrySepcDetail', $this->industrySepcDetail, true);
        Model::validateRequired('outRequestNo', $this->outRequestNo, true);
        Model::validateRequired('outTradeNo', $this->outTradeNo, true);
        Model::validateRequired('presentRefundBuyerAmount', $this->presentRefundBuyerAmount, true);
        Model::validateRequired('presentRefundDiscountAmount', $this->presentRefundDiscountAmount, true);
        Model::validateRequired('presentRefundMdiscountAmount', $this->presentRefundMdiscountAmount, true);
        Model::validateRequired('refundAmount', $this->refundAmount, true);
        Model::validateRequired('refundChargeAmount', $this->refundChargeAmount, true);
        Model::validateRequired('refundDetailItemList', $this->refundDetailItemList, true);
        Model::validateRequired('refundReason', $this->refundReason, true);
        Model::validateRequired('refundRoyaltys', $this->refundRoyaltys, true);
        Model::validateRequired('refundSettlementId', $this->refundSettlementId, true);
        Model::validateRequired('refundStatus', $this->refundStatus, true);
        Model::validateRequired('sendBackFee', $this->sendBackFee, true);
        Model::validateRequired('totalAmount', $this->totalAmount, true);
        Model::validateRequired('tradeNo', $this->tradeNo, true);
    }

    /**
     * @return array
     */
    public function toMap()
    {
        $res = [];

        if ($this->httpBody !== null) {
            $res['http_body'] = $this->httpBody;
        }

        if ($this->code !== null) {
            $res['code'] = $this->code;
        }

        if ($this->msg !== null) {
            $res['msg'] = $this->msg;
        }

        if ($this->subCode !== null) {
            $res['sub_code'] = $this->subCode;
        }

        if ($this->subMsg !== null) {
            $res['sub_msg'] = $this->subMsg;
        }

        if ($this->errorCode !== null) {
            $res['error_code'] = $this->errorCode;
        }

        if ($this->gmtRefundPay !== null) {
            $res['gmt_refund_pay'] = $this->gmtRefundPay;
        }

        if ($this->industrySepcDetail !== null) {
            $res['industry_sepc_detail'] = $this->industrySepcDetail;
        }

        if ($this->outRequestNo !== null) {
            $res['out_request_no'] = $this->outRequestNo;
        }

        if ($this->outTradeNo !== null) {
            $res['out_trade_no'] = $this->outTradeNo;
        }

        if ($this->presentRefundBuyerAmount !== null) {
            $res['present_refund_buyer_amount'] = $this->presentRefundBuyerAmount;
        }

        if ($this->presentRefundDiscountAmount !== null) {
            $res['present_refund_discount_amount'] = $this->presentRefundDiscountAmount;
        }

        if ($this->presentRefundMdiscountAmount !== null) {
            $res['present_refund_mdiscount_amount'] = $this->presentRefundMdiscountAmount;
        }

        if ($this->refundAmount !== null) {
            $res['refund_amount'] = $this->refundAmount;
        }

        if ($this->refundChargeAmount !== null) {
            $res['refund_charge_amount'] = $this->refundChargeAmount;
        }

        if ($this->refundDetailItemList !== null) {
            $res['refund_detail_item_list'] = [];

            if ($this->refundDetailItemList !== null && is_array($this->refundDetailItemList)) {
                $n = 0;
                foreach ($this->refundDetailItemList as $item) {
                    $res['refund_detail_item_list'][$n++] = $item !== null ? $item->toMap() : $item;
                }
            }
        }

        if ($this->refundReason !== null) {
            $res['refund_reason'] = $this->refundReason;
        }

        if ($this->refundRoyaltys !== null) {
            $res['refund_royaltys'] = [];

            if ($this->refundRoyaltys !== null && is_array($this->refundRoyaltys)) {
                $n = 0;
                foreach ($this->refundRoyaltys as $item) {
                    $res['refund_royaltys'][$n++] = $item !== null ? $item->toMap() : $item;
                }
            }
        }

        if ($this->refundSettlementId !== null) {
            $res['refund_settlement_id'] = $this->refundSettlementId;
        }

        if ($this->refundStatus !== null) {
            $res['refund_status'] = $this->refundStatus;
        }

        if ($this->sendBackFee !== null) {
            $res['send_back_fee'] = $this->sendBackFee;
        }

        if ($this->totalAmount !== null) {
            $res['total_amount'] = $this->totalAmount;
        }

        if ($this->tradeNo !== null) {
            $res['trade_no'] = $this->tradeNo;
        }

        return $res;
    }

    /**
     * @param array $map
     *
     * @return AlipayTradeFastpayRefundQueryResponse
     */
    public static function fromMap($map = [])
    {
        $model = new self();

        if (isset($map['http_body'])) {
            $model->httpBody = $map['http_body'];
        }

        if (isset($map['code'])) {
            $model->code = $map['code'];
        }

        if (isset($map['msg'])) {
            $model->msg = $map['msg'];
        }

        if (isset($map['sub_code'])) {
            $model->subCode = $map['sub_code'];
        }

        if (isset($map['sub_msg'])) {
            $model->subMsg = $map['sub_msg'];
        }

        if (isset($map['error_code'])) {
            $model->errorCode = $map['error_code'];
        }

        if (isset($map['gmt_refund_pay'])) {
            $model->gmtRefundPay = $map['gmt_refund_pay'];
        }

        if (isset($map['industry_sepc_detail'])) {
            $model->industrySepcDetail = $map['industry_sepc_detail'];
        }

        if (isset($map['out_request_no'])) {
            $model->outRequestNo = $map['out_request_no'];
        }

        if (isset($map['out_trade_no'])) {
            $model->outTradeNo = $map['out_trade_no'];
        }

        if (isset($map['present_refund_buyer_amount'])) {
            $model->presentRefundBuyerAmount = $map['present_refund_buyer_amount'];
        }

        if (isset($map['present_refund_discount_amount'])) {
            $model->presentRefundDiscountAmount = $map['present_refund_discount_amount'];
        }

        if (isset($map['present_refund_mdiscount_amount'])) {
            $model->presentRefundMdiscountAmount = $map['present_refund_mdiscount_amount'];
        }

        if (isset($map['refund_amount'])) {
            $model->refundAmount = $map['refund_amount'];
        }

        if (isset($map['refund_charge_amount'])) {
            $model->refundChargeAmount = $map['refund_charge_amount'];
        }

        if (isset($map['refund_detail_item_list'])) {
            if (!empty($map['refund_detail_item_list'])) {
                $model->refundDetailItemList = [];
                $n                           = 0;
                foreach ($map['refund_detail_item_list'] as $item) {
                    $model->refundDetailItemList[$n++] = $item !== null ? TradeFundBill::fromMap($item) : $item;
                }
            }
        }

        if (isset($map['refund_reason'])) {
            $model->refundReason = $map['refund_reason'];
        }

        if (isset($map['refund_royaltys'])) {
            if (!empty($map['refund_royaltys'])) {
                $model->refundRoyaltys = [];
                $n                     = 0;
                foreach ($map['refund_royaltys'] as $item) {
                    $model->refundRoyaltys[$n++] = $item !== null ? RefundRoyaltyResult::fromMap($item) : $item;
                }
            }
        }

        if (isset($map['refund_settlement_id'])) {
            $model->refundSettlementId = $map['refund_settlement_id'];
        }

        if (isset($map['refund_status'])) {
            $model->refundStatus = $map['refund_status'];
        }

        if (isset($map['send_back_fee'])) {
            $model->sendBackFee = $map['send_back_fee'];
        }

        if (isset($map['total_amount'])) {
            $model->totalAmount = $map['total_amount'];
        }

        if (isset($map['trade_no'])) {
            $model->tradeNo = $map['trade_no'];
        }

        return $model;
    }
}
