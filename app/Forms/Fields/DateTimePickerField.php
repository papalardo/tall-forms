<?php

namespace App\Forms\Fields;

use App\Forms\Fields\Traits\HasPlaceholder;

class DateTimePickerField extends BaseField
{
    public function view() : string
    {
        return 'fields.date-time-picker';
    }
}
