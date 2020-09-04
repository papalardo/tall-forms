<?php

namespace App\FormFields\BasicFields\Fields;

class InputField extends BaseField
{
    private $type;

    public static function make(string $label, string $name) {
        return new static($label, $name);
    }

    public function type($type)
    {
        $this->type = $type;
        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getView()
    {
        return 'form-fields.basic-fields.input';
    }
}
