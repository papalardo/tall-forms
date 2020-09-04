<?php

namespace App\FormFields\Traits;

use App\FormFields\LivewireFields\Interfaces\IMultipleFields;

trait HasMultiple
{
    private $is_multiple = false;

    public function multiple($is_multiple = true)
    {
        $this->is_multiple = $is_multiple;
        return $this;
    }

    public function isMultiple() : bool
    {
        return $this->is_multiple;
    }
}
