<?php

namespace EasyAliSdk\Domain\Payment\Huabei\Models;

use AlibabaCloud\Tea\Model;

class HuabeiConfig extends Model
{
    /**
     * @var string
     */
    public $hbFqNum;

    /**
     * @var string
     */
    public $hbFqSellerPercent;

    /**
     * @var string[]
     */
    protected $_name = [
        'hbFqNum'           => 'hb_fq_num',
        'hbFqSellerPercent' => 'hb_fq_seller_percent',
    ];

    public function validate()
    {
        Model::validateRequired('hbFqNum', $this->hbFqNum, true);
        Model::validateRequired('hbFqSellerPercent', $this->hbFqSellerPercent, true);
    }

    /**
     * @return array
     */
    public function toMap()
    {
        $res = [];

        if ($this->hbFqNum !== null) {
            $res['hb_fq_num'] = $this->hbFqNum;
        }

        if ($this->hbFqSellerPercent !== null) {
            $res['hb_fq_seller_percent'] = $this->hbFqSellerPercent;
        }

        return $res;
    }

    /**
     * @param array $map
     *
     * @return HuabeiConfig
     */
    public static function fromMap($map = [])
    {
        $model = new self();

        if (isset($map['hb_fq_num'])) {
            $model->hbFqNum = $map['hb_fq_num'];
        }

        if (isset($map['hb_fq_seller_percent'])) {
            $model->hbFqSellerPercent = $map['hb_fq_seller_percent'];
        }

        return $model;
    }
}
