<?php

namespace shop\forms\manage\Shop;

use shop\entities\Shop\Brand;
use shop\forms\CompositeForm;
use shop\forms\manage\MetaForm;
use shop\validators\SlugValidator;

/**
 * @property MetaForm $meta;
 */
class BrandForm extends CompositeForm
{
    public $name;
    public $slug;

    private $_brand;
    private $_meta;

    public function __construct(Brand $brand = null, $config = [])
    {
        if ($brand) {
            $this->name = $brand->name;
            $this->slug = $brand->slug;
            $this->meta = new MetaForm($brand->meta);
            $this->_brand = $brand;
        } else {
            $this->meta = new MetaForm();
        }
        parent::__construct($config);
    }

    public function load($data, $formName = null)
    {
        $self = parent::load($data, $formName);
        $meta = $this->_meta->load($data, $formName);
        return $self && $meta;
    }

    public function validate($attributeNames = null, $clearErrors = true)
    {
        $self = parent::validate($attributeNames, $clearErrors);
        $meta = $this->_meta->validate(null, $clearErrors);
        return $self && $meta;
    }

    public function rules(): array
    {
        return [
            [['name', 'slug'], 'required'],
            [['name', 'slug'], 'string', 'max' => 255],
            ['slug', SlugValidator::class],
            [['name', 'slug'], 'unique', 'targetClass' => Brand::class, 'filter' => $this->_brand ? ['<>', 'id', $this->_brand->id] : null]
        ];
    }

    public function internalForms(): array
    {
        return ['meta'];
    }
}