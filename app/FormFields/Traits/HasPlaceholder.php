<?php

namespace App\FormFields\Traits;

trait HasPlaceholder
{
    private $placeholder;

    public function placeholder($placeholder)
    {
        $this->placeholder = $placeholder;
        return $this;
    }

    public function getPlaceholder()
    {
        return $this->placeholder;
    }
}
