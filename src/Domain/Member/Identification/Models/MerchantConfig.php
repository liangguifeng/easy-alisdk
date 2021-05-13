<?php

namespace EasyAliSdk\Domain\Member\Identification\Models;

use AlibabaCloud\Tea\Model;

class MerchantConfig extends Model
{
    /**
     * @var string
     */
    public $returnUrl;

    /**
     * @var string[]
     */
    protected $_name = [
        'returnUrl' => 'return_url',
    ];

    public function validate()
    {
        Model::validateRequired('returnUrl', $this->returnUrl, true);
    }

    /**
     * @return array
     */
    public function toMap()
    {
        $res = [];

        if ($this->returnUrl !== null) {
            $res['return_url'] = $this->returnUrl;
        }

        return $res;
    }

    /**
     * @param array $map
     *
     * @return MerchantConfig
     */
    public static function fromMap($map = [])
    {
        $model = new self();

        if (isset($map['return_url'])) {
            $model->returnUrl = $map['return_url'];
        }

        return $model;
    }
}
