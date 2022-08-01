<?php

namespace shop\tests\unit\entities\Shop\Brand;

use Codeception\Test\Unit;

class CreateTest extends Unit
{
    public function testSuccess()
    {
        $brand = Brand::create(
            $name = 'Name',
            $slug = 'slug',
            $meta = new Meta('title', 'Description', 'Keywords')
        );
        $this->assertEquals($name, $brand->name);
        $this->assertEquals($name, $brand->slug);
        $this->assertEquals($name, $brand->meta);
    }
}