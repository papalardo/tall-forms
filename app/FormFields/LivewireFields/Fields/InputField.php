<?php

namespace App\FormFields\LivewireFields\Fields;

use App\FormFields\Traits\HasPlaceholder;

class InputField extends BaseField
{
    use HasPlaceholder;
    
    private $type;

    public function type($type)
    {
        $this->type = $type;
        return $this;
    }

    public function getType()
    {
        return $this->type;
    }
    
    public function getView() : string
    {
        return 'form-fields.livewire-fields.input';
    }
}
