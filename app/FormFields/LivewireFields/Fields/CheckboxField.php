<?php

namespace App\FormFields\LivewireFields\Fields;

use Illuminate\Support\Arr;
use App\FormFields\Traits\HasOptions;
use App\FormFields\Traits\HasMultiple;
use App\Forms\Fields\Traits\HasPlaceholder;
use App\FormFields\LivewireFields\Interfaces\ILivewireFields;
use App\FormFields\LivewireFields\Interfaces\IMultipleFields;

class CheckboxField extends BaseFieldWithOptions implements IMultipleFields
{
    use HasMultiple, HasOptions;
    
    public $default = false;

    public function options($options)
    {
        $this->multiple();
        $this->options = Arr::isAssoc($options) ? array_flip($options) : array_combine($options, $options);
        return $this;
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function getView() : string
    {
        return 'form-fields.livewire-fields.checkbox';
    }
}
