<?php

namespace Selective\Util\Test;

class FooJson implements \JsonSerializable
{
    private $key = 'value';

    public function jsonSerialize()
    {
        return ['key' => $this->key];
    }
}
