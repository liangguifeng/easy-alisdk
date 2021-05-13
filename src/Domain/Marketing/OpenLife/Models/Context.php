<?php

namespace EasyAliSdk\Domain\Marketing\OpenLife\Models;

use AlibabaCloud\Tea\Model;
use Alipay\EasySDK\Marketing\OpenLife\Models\Keyword;

class Context extends Model
{
    /**
     * @var string
     */
    public $headColor;

    /**
     * @var string
     */
    public $url;

    /**
     * @var string
     */
    public $actionName;

    /**
     * @var Keyword
     */
    public $keyword1;

    /**
     * @var Keyword
     */
    public $keyword2;

    /**
     * @var Keyword
     */
    public $first;

    /**
     * @var Keyword
     */
    public $remark;

    /**
     * @var string[]
     */
    protected $_name = [
        'headColor'  => 'head_color',
        'url'        => 'url',
        'actionName' => 'action_name',
        'keyword1'   => 'keyword1',
        'keyword2'   => 'keyword2',
        'first'      => 'first',
        'remark'     => 'remark',
    ];

    public function validate()
    {
        Model::validateRequired('headColor', $this->headColor, true);
        Model::validateRequired('url', $this->url, true);
        Model::validateRequired('actionName', $this->actionName, true);
    }

    /**
     * @return array
     */
    public function toMap()
    {
        $res = [];

        if ($this->headColor !== null) {
            $res['head_color'] = $this->headColor;
        }

        if ($this->url !== null) {
            $res['url'] = $this->url;
        }

        if ($this->actionName !== null) {
            $res['action_name'] = $this->actionName;
        }

        if ($this->keyword1 !== null) {
            $res['keyword1'] = $this->keyword1 !== null ? $this->keyword1->toMap() : null;
        }

        if ($this->keyword2 !== null) {
            $res['keyword2'] = $this->keyword2 !== null ? $this->keyword2->toMap() : null;
        }

        if ($this->first !== null) {
            $res['first'] = $this->first !== null ? $this->first->toMap() : null;
        }

        if ($this->remark !== null) {
            $res['remark'] = $this->remark !== null ? $this->remark->toMap() : null;
        }

        return $res;
    }

    /**
     * @param array $map
     *
     * @return Context
     */
    public static function fromMap($map = [])
    {
        $model = new self();

        if (isset($map['head_color'])) {
            $model->headColor = $map['head_color'];
        }

        if (isset($map['url'])) {
            $model->url = $map['url'];
        }

        if (isset($map['action_name'])) {
            $model->actionName = $map['action_name'];
        }

        if (isset($map['keyword1'])) {
            $model->keyword1 = Keyword::fromMap($map['keyword1']);
        }

        if (isset($map['keyword2'])) {
            $model->keyword2 = Keyword::fromMap($map['keyword2']);
        }

        if (isset($map['first'])) {
            $model->first = Keyword::fromMap($map['first']);
        }

        if (isset($map['remark'])) {
            $model->remark = Keyword::fromMap($map['remark']);
        }

        return $model;
    }
}
