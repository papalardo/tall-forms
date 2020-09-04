<?php

namespace App\FormFields\BasicFields\Fields;

use App\FormFields\Traits\HasPlaceholder;

class SelectField extends BaseField
{
    use HasPlaceholder;

    private $options;

    public static function make(string $label, string $name, array $options) {
        $field = new static($label, $name);
        $field->options($options);
        return $field;
    }

    public function options($options)
    {
        $this->options = $options;
        return $this;
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function getView()
    {
        return 'form-fields.basic-fields.select';
    }
}
