<?php

namespace shop\entities\Shop\Product;

use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $code
 * @property string $name
 * @property string $price
 * @property int $quantity
 */
class Modification extends ActiveRecord
{
    public static function create($code, $name, $price): self
    {
        $modification = new static();
        $modification->code = $code;
        $modification->name = $name;
        $modification->price = $price;
        return $modification;
    }

    public function edit($code, $name, $price): void
    {
        $this->code = $code;
        $this->name = $name;
        $this->price = $price;
    }

    public function checkout($quantity): void
    {
        if ($quantity > $this->quantity) {
            throw new \DomainException('Only ' . $this->quantity . ' items are available.');
        }
        $this->quantity -= $quantity;
    }

    public function isIdEqualTo($id)
    {
        return $this->id == $id;
    }

    public function isCodeEqualTo($code)
    {
        return $this->code === $code;
    }

    public static function tableName(): string
    {
        return '{{%shop_modifications}}';
    }
}