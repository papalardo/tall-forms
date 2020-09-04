<?php

namespace App\FormFields\LivewireFields\Fields;

use App\FormFields\Traits\HasOptions;
use App\FormFields\Traits\HasPlaceholder;

class SelectField extends BaseFieldWithOptions
{
    use HasPlaceholder, HasOptions;
  
    public function getView() : string
    {
        return 'form-fields.livewire-fields.select';
    }
}
