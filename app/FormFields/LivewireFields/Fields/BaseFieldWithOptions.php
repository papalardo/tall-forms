<?php

namespace App\FormFields\LivewireFields\Fields;

use Closure;
use Illuminate\Support\Str;
use App\Forms\Fields\Config\FieldsDefaultConfig;
use App\FormFields\LivewireFields\Interfaces\ILivewireFields;
use App\FormFields\LivewireFields\Config\ConfigLivewireFields;

abstract class BaseFieldWithOptions extends BaseField implements ILivewireFields
{
    public function __construct(string $label = null, string $name = null, array $options = [])
    {
        parent::__construct($label, $name);

        if(! empty($options)) {
            $this->options($options);
        }
    }

    public static function make(string $label = null, string $name = null, array $options = []) : ILivewireFields
    {
        return app(get_called_class(), [
            'label' => $label, 
            'name' => $name,
            'options' => $options
        ]);
    }
}
