<?php

namespace shop\forms\manage\Shop\Product;

use shop\entities\Shop\Tag;
use yii\base\Model;
use shop\entities\Shop\Product\Product;
use yii\helpers\ArrayHelper;

class TagsForm extends Model
{
    public $existing = [];
    public $textNew;

    public function __construct(Product $product = null, $config = [])
    {
        if ($product) {
            $this->existing = ArrayHelper::getColumn($product->tagAssignments, 'tag_id');
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['existing', 'each', 'rule' => ['integer']],
            ['textNew', 'string'],
        ];
    }

    public function tagsList(): array
    {
        return ArrayHelper::map(Tag::find()->orderBy('name')->asArray()->all(), 'id', 'name');
    }

    public function getNewNames(): array
    {
        return array_map('trim', preg_split('#\s*,\s*#i', $this->textNew));
    }

    public function beforeValidate(): bool
    {
        $this->existing = array_filter((array)$this->existing);
        return parent::beforeValidate();
    }
}