<?php

namespace App\Forms\Fields;

use App\Forms\Fields\Traits\HasOptions;
use App\Forms\Fields\Traits\HasPlaceholder;

class SelectField extends BaseField
{
    use HasPlaceholder, HasOptions;
    
    public function view() : string
    {
        return 'fields.select';
    }
}
