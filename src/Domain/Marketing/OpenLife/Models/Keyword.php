<?php

namespace EasyAliSdk\Domain\Marketing\OpenLife\Models;

use AlibabaCloud\Tea\Model;

class Keyword extends Model
{
    /**
     * @var string
     */
    public $color;

    /**
     * @var string
     */
    public $value;

    /**
     * @var string[]
     */
    protected $_name = [
        'color' => 'color',
        'value' => 'value',
    ];

    public function validate()
    {
        Model::validateRequired('color', $this->color, true);
        Model::validateRequired('value', $this->value, true);
    }

    /**
     * @return array
     */
    public function toMap()
    {
        $res = [];

        if ($this->color !== null) {
            $res['color'] = $this->color;
        }

        if ($this->value !== null) {
            $res['value'] = $this->value;
        }

        return $res;
    }

    /**
     * @param array $map
     *
     * @return Keyword
     */
    public static function fromMap($map = [])
    {
        $model = new self();

        if (isset($map['color'])) {
            $model->color = $map['color'];
        }

        if (isset($map['value'])) {
            $model->value = $map['value'];
        }

        return $model;
    }
}
