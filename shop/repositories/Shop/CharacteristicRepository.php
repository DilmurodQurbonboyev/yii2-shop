<?php

namespace shop\repositories\Shop;

//use shop\dispatchers\EventDispatcher;
use shop\entities\Shop\Category;
//use shop\repositories\events\EntityPersisted;
//use shop\repositories\events\EntityRemoved;
use shop\entities\Shop\Characteristic;
use shop\repositories\NotFoundException;

class CharacteristicRepository
{
//    private $dispatcher;

//    public function __construct(EventDispatcher $dispatcher)
//    {
//        $this->dispatcher = $dispatcher;
//    }

    public function get($id): Characteristic
    {
        if (!$characteristic = Characteristic::findOne($id)) {
            throw new NotFoundException('Characteristic is not found.');
        }
        return $characteristic;
    }

    public function save(Characteristic $characteristic): void
    {
        if (!$characteristic->save()) {
            throw new \RuntimeException('Saving error.');
        }
//        $this->dispatcher->dispatch(new EntityPersisted($category));
    }

    public function remove(Characteristic $characteristic): void
    {
        if (!$characteristic->delete()) {
            throw new \RuntimeException('Removing error.');
        }
//        $this->dispatcher->dispatch(new EntityRemoved($category));
    }
}