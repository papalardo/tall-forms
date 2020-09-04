<?php

namespace App\FormFields\LivewireFields\Fields;

use Closure;
use Illuminate\Support\Arr;
use App\FormFields\Traits\HasOptions;
use App\FormFields\Traits\HasMultiple;
use App\FormFields\Traits\HasPlaceholder;
use App\FormFields\LivewireFields\Interfaces\ILivewireFields;
use App\FormFields\LivewireFields\Interfaces\IMultipleFields;

class MultiSelectField extends BaseField implements IMultipleFields
{
    use HasPlaceholder, HasOptions, HasMultiple;
    
    private $choice_limit = 999;

    private $add_on_enter = false;

    private $fnSearch;

    private $realtime_search_enabled = false;

    public function __construct(string $label = null, string $name = null, $options = [])
    {
        parent::__construct($label, $name);

        $this->multiple();
        $this->options($options);
    }

    public static function make(string $label = null, string $name = null, $options = []) : ILivewireFields
    {
        return app(get_called_class(), [
            'label' => $label, 
            'name' => $name,
            'options' => $options
        ]);
    }

    public function getView() : string
    {
        return 'form-fields.livewire-fields.multi-select';
    }

    public function realtimeSearchEnabled() : bool
    {
        return (bool) $this->realtime_search_enabled;
    }

    public function query(Closure $fn)
    {
        $this->realtime_search_enabled = true;
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
        } else {
            throw new LogMethodException(sprintf("Options {%s} not supported", gettype($options)));
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

    public function choiceLimit(int $limit = null) : MultiSelectField
    {
        $this->choice_limit = $limit;
        return $this;
    }

    public function getChoiceLimit() : int
    {
        return (int) $this->choice_limit;
    }

    public function addOnEnter(bool $add_on_enter = true) : MultiSelectField
    {
        $this->add_on_enter = $add_on_enter;
        return $this;
    }

    public function getAddOnEnter() : bool
    {
        return (bool) $this->add_on_enter;
    }
}
