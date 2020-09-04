<?php

namespace App\FormFields\Traits;

trait HasOptions
{
    private $options = [];

    public function options(array $options)
    {
        $this->options = $options;
        return $this;
    }

    public function getOptions()
    {
        return $this->options;
    }
}
