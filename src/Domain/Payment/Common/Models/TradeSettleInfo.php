<?php

namespace EasyAliSdk\Domain\Payment\Common\Models;

use AlibabaCloud\Tea\Model;

class TradeSettleInfo extends Model
{
    /**
     * @var TradeSettleDetail[]
     */
    public $tradeSettleDetailList;

    /**
     * @var string[]
     */
    protected $_name = [
        'tradeSettleDetailList' => 'trade_settle_detail_list',
    ];

    public function validate()
    {
        Model::validateRequired('tradeSettleDetailList', $this->tradeSettleDetailList, true);
    }

    /**
     * @return array
     */
    public function toMap()
    {
        $res = [];

        if ($this->tradeSettleDetailList !== null) {
            $res['trade_settle_detail_list'] = [];

            if ($this->tradeSettleDetailList !== null && is_array($this->tradeSettleDetailList)) {
                $n = 0;
                foreach ($this->tradeSettleDetailList as $item) {
                    $res['trade_settle_detail_list'][$n++] = $item !== null ? $item->toMap() : $item;
                }
            }
        }

        return $res;
    }

    /**
     * @param array $map
     *
     * @return TradeSettleInfo
     */
    public static function fromMap($map = [])
    {
        $model = new self();

        if (isset($map['trade_settle_detail_list'])) {
            if (!empty($map['trade_settle_detail_list'])) {
                $model->tradeSettleDetailList = [];
                $n                            = 0;
                foreach ($map['trade_settle_detail_list'] as $item) {
                    $model->tradeSettleDetailList[$n++] = $item !== null ? TradeSettleDetail::fromMap($item) : $item;
                }
            }
        }

        return $model;
    }
}
