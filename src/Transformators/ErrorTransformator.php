<?php

namespace App\Transformators;

use Throwable;

class ErrorTransformator extends Transformator
{
    public function __construct(protected Throwable $exception)
    {
    }

    public function data(): array
    {
        return [
            'code' => $this->exception->getCode(),
            'message' => 'Something went wrong',
        ];
    }
}