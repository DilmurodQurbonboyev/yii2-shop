<?php

namespace shop\forms\manage\Shop;

use shop\entities\Shop\Tag;
use yii\base\Model;

class TagEditForm extends Model
{
    public $name;
    public $slug;

    public function rules(): array
    {
        return [
            [['name', 'slug'], 'required'],
            [['name', 'slug'], 'string', 'max' => 255],
            ['slug', 'match', 'pattern' =>'#^[a-z0-9_-]*$#s'],
            [['name', 'slug'], 'unique', 'targetClass' => Tag::class],
        ];
    }
}