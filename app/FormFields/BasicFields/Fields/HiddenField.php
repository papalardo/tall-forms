<?php

namespace App\FormFields\BasicFields\Fields;

class HiddenField extends BaseField
{
    public static function make(string $name) {
        $field = new static(null, $name);
        return $field;
    }

    public function getView()
    {
        return 'form-fields.basic-fields.hidden';
    }
}
