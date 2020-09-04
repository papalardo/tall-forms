<?php

namespace App\FormFields\LivewireFields\Fields;

use App\Forms\Fields\Traits\HasPlaceholder;

class DateTimePickerField extends BaseField
{
    public $format;

    public function getView() : string
    {
        return 'form-fields.livewire-fields.date-time-picker-vue';

        return 'form-fields.livewire-fields.date-time-picker';
    }

    /**
     * https://www.unicode.org/reports/tr35/tr35-dates.html#Date_Field_Symbol_Table
     */
    public function format($format) : string
    {
        $this->format = $format;
    }
}
