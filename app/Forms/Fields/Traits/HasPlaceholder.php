<?php

namespace App\Forms\Fields\Traits;

trait HasPlaceholder
{
    public $placeholder;

    public function placeholder($placeholder)
    {
        $this->placeholder = $placeholder;
        return $this;
    }
}
