<?php

namespace Selective\Encoding\Test;

use JsonSerializable;

class FooJson implements JsonSerializable
{
    private $key = 'value';

    public function jsonSerialize()
    {
        return ['key' => $this->key];
    }
}
