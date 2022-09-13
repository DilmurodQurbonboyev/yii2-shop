<?php

namespace shop\entities\Shop\Product;

use yii\db\ActiveQuery;

class CategoryAssignment extends ActiveQuery
{
    public static function create($categoryId): self
    {
        $assignment = new static();
        $assignment->category_id = $categoryId;
        return $assignment;
    }

    public function isForCategory($id): bool
    {
        return $this->category_id = $id;
    }

    public static function tableName()
    {
        return '{{%shop_category_assignments}}';
    }
}