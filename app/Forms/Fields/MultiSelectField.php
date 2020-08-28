<?php

namespace App\Forms\Fields;

use Closure;
use App\Forms\Fields\Traits\HasOptions;
use App\Forms\Fields\Traits\HasPlaceholder;
use Illuminate\Support\Arr;

class MultiSelectField extends BaseField
{
    use HasPlaceholder, HasOptions;
    
    public $is_multiple = true;

    public $fnSearch;

    public $is_realtime_search = false;
    
    public function view() : string
    {
        return 'fields.multi-select';
    }

    public function query(Closure $fn)
    {
        $this->is_realtime_search = true;
        $this->fnSearch = $fn;
        return $this;
    }

    public function options($options)
    {
        $this->options = [];

        if (is_array($options)) {
            $this->options = Arr::isAssoc($options) ? array_flip($options) : array_combine($options, $options);
        } elseif ($options instanceof Closure) {
            $this->options = $this->query($options)->search();
        }

        return $this;
    }

    public function search($keyword = null)
    {
        $fn = $this->fnSearch;

        if (! $fn) {
            return [];
        }

        return $fn($keyword);
    }
}
