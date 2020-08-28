<?php

namespace App\Forms\Fields;

use App\Forms\Fields\Traits\HasPlaceholder;

class RichTextField extends BaseField
{
    use HasPlaceholder;
    
    public function view() : string
    {
        return 'fields.rich-text';
    }
}
