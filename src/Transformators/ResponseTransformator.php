<?php

namespace App\Transformators;

class ResponseTransformator extends Transformator
{
    public function __construct(protected array $data)
    {
    }

    public function data(): array
    {
        return $this->data;
    }
}