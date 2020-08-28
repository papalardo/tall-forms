<?php

namespace App\Forms\Fields;

use App\Forms\Fields\Traits\HasPlaceholder;

class InputField extends BaseField
{
    use HasPlaceholder;
    
    public $type;

    public function type($type)
    {
        $this->type = $type;
        return $this;
    }
    
    public function view() : string
    {
        return 'fields.input';
    }
}
