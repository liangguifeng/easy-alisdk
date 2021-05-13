<?php

namespace EasyAliSdk\Domain\Marketing\OpenLife\Models;

use AlibabaCloud\Tea\Model;

class Text extends Model
{
    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $content;

    /**
     * @var string[]
     */
    protected $_name = [
        'title'   => 'title',
        'content' => 'content',
    ];

    public function validate()
    {
        Model::validateRequired('title', $this->title, true);
        Model::validateRequired('content', $this->content, true);
    }

    /**
     * @return array
     */
    public function toMap()
    {
        $res = [];

        if ($this->title !== null) {
            $res['title'] = $this->title;
        }

        if ($this->content !== null) {
            $res['content'] = $this->content;
        }

        return $res;
    }

    /**
     * @param array $map
     *
     * @return Text
     */
    public static function fromMap($map = [])
    {
        $model = new self();

        if (isset($map['title'])) {
            $model->title = $map['title'];
        }

        if (isset($map['content'])) {
            $model->content = $map['content'];
        }

        return $model;
    }
}
