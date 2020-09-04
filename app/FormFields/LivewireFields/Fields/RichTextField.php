<?php

namespace App\FormFields\LivewireFields\Fields;

use App\FormFields\Traits\HasPlaceholder;

class RichTextField extends BaseField
{
    use HasPlaceholder;
    
    public function getView() : string
    {
        return 'form-fields.livewire-fields.rich-text';
    }
}
