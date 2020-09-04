<?php

namespace App\FormFields\LivewireFields\Traits;

use App\Forms\Fields\MultiSelectField;

trait HasRules
{
    public function rules($realtime = false)
    {
        $rules = [];
        $rules_ignore = $realtime ? $this->rulesIgnoreRealtime() : [];

        foreach ($this->getAvailableFields() as $key => $field) {
            if ($field->rules) {
                foreach ($this->fieldRules($field, $rules_ignore) as $key => $rule) {
                    if (is_string($key)) {
                        $rules[$field->key . $key] = $rule;
                    } else {
                        $rules[$field->key] = $rule;
                    }
                }
            }

            // File fields need more complex logic since they are technically arrays
            // Right now we can only do simple validation with file fields

            // foreach ($field->array_fields as $array_field) {
            //     if ($array_field->rules) {
            //         $rules[$field->key . '.*.' . $array_field->name] = $this->fieldRules($array_field, $rules_ignore);
            //     }
            // }
        }

        return $rules;
    }

    public function fieldRules($field, $rules_ignore)
    {
        $field_rules = is_array($field->rules) ? $field->rules : explode('|', $field->rules);

        if ($rules_ignore) {
            $field_rules = array_udiff($field_rules, $rules_ignore, function ($a, $b) {
                return $a != $b;
            });
        }

        return $field_rules;
    }

    public function rulesIgnoreRealtime()
    {
        return [];
    }
}
