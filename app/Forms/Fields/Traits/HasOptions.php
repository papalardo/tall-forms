<?php

namespace App\Forms\Fields\Traits;

use Illuminate\Support\Arr;

trait HasOptions
{
    public $options = [];

    public function options($options)
    {
        $this->options = Arr::isAssoc($options) ? array_flip($options) : array_combine($options, $options);
        return $this;
    }
}
