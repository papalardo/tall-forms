<?php

namespace App\FormFields\LivewireFields\Interfaces;

interface IMultipleFields
{
    public function multiple($is_multiple = true);

    public function isMultiple() : bool;
}
