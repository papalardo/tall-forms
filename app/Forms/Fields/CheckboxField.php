<?php

namespace App\Forms\Fields;

use Illuminate\Support\Arr;
use App\Forms\Fields\Traits\HasOptions;
use App\Forms\Fields\Traits\HasPlaceholder;

class CheckboxField extends BaseField
{
    use HasOptions;
    
    public $default = false;
    
    public $is_multiple = false;

    public $options = [];

    public function multiple()
    {
        $this->is_multiple = true;
    }

    public function options($options)
    {
        $this->multiple();

        $this->options = Arr::isAssoc($options) ? array_flip($options) : array_combine($options, $options);
        return $this;
    }

    public function view() : string
    {
        return 'fields.checkbox';
    }
}
