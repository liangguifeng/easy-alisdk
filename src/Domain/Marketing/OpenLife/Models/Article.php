<?php

namespace EasyAliSdk\Domain\Marketing\OpenLife\Models;

use AlibabaCloud\Tea\Model;

class Article extends Model
{
    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $desc;

    /**
     * @var string
     */
    public $imageUrl;

    /**
     * @var string
     */
    public $url;

    /**
     * @var string
     */
    public $actionName;

    /**
     * @var string[]
     */
    protected $_name = [
        'title'      => 'title',
        'desc'       => 'desc',
        'imageUrl'   => 'image_url',
        'url'        => 'url',
        'actionName' => 'action_name',
    ];

    public function validate()
    {
        Model::validateRequired('desc', $this->desc, true);
        Model::validateRequired('url', $this->url, true);
    }

    public function toMap()
    {
        $res = [];

        if ($this->title !== null) {
            $res['title'] = $this->title;
        }

        if ($this->desc !== null) {
            $res['desc'] = $this->desc;
        }

        if ($this->imageUrl !== null) {
            $res['image_url'] = $this->imageUrl;
        }

        if ($this->url !== null) {
            $res['url'] = $this->url;
        }

        if ($this->actionName !== null) {
            $res['action_name'] = $this->actionName;
        }

        return $res;
    }

    /**
     * @param array $map
     *
     * @return Article
     */
    public static function fromMap($map = [])
    {
        $model = new self();

        if (isset($map['title'])) {
            $model->title = $map['title'];
        }

        if (isset($map['desc'])) {
            $model->desc = $map['desc'];
        }

        if (isset($map['image_url'])) {
            $model->imageUrl = $map['image_url'];
        }

        if (isset($map['url'])) {
            $model->url = $map['url'];
        }

        if (isset($map['action_name'])) {
            $model->actionName = $map['action_name'];
        }

        return $model;
    }
}
