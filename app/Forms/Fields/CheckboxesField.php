<?php

namespace App\Forms\Fields;

use App\Forms\Fields\Traits\HasOptions;
use App\Forms\Fields\Traits\HasPlaceholder;
use App\Forms\Fields\Interfaces\HasArrayValues;

class CheckboxesField extends BaseField implements HasArrayValues
{
    use HasOptions;
    
    public function view()
    {
        return 'fields.checkboxes';
    }
}
