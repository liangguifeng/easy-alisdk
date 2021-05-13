<?php

namespace EasyAliSdk\Domain\Marketing\OpenLife\Models;

use AlibabaCloud\Tea\Model;

class Template extends Model
{
    /**
     * @var string
     */
    public $templateId;

    /**
     * @var Context
     */
    public $context;

    /**
     * @var string[]
     */
    protected $_name = [
        'templateId' => 'template_id',
        'context'    => 'context',
    ];

    public function validate()
    {
        Model::validateRequired('templateId', $this->templateId, true);
        Model::validateRequired('context', $this->context, true);
    }

    /**
     * @return array
     */
    public function toMap()
    {
        $res = [];

        if ($this->templateId !== null) {
            $res['template_id'] = $this->templateId;
        }

        if ($this->context !== null) {
            $res['context'] = $this->context !== null ? $this->context->toMap() : null;
        }

        return $res;
    }

    /**
     * @param array $map
     *
     * @return Template
     */
    public static function fromMap($map = [])
    {
        $model = new self();

        if (isset($map['template_id'])) {
            $model->templateId = $map['template_id'];
        }

        if (isset($map['context'])) {
            $model->context = Context::fromMap($map['context']);
        }

        return $model;
    }
}
