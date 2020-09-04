<?php

namespace App\FormFields\LivewireFields\Traits;

trait HasMultiSelectSearch
{
    public function multiSelectSearch($fieldKey, $keyword)
    {
        $field = $this->fields()[$fieldKey];
        if ($field->is_realtime_search) {
            $this->emit('multiselect-options-changed.' . $fieldKey, $field->search($keyword));
        }
    }
}
