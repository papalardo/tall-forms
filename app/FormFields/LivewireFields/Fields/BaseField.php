<?php

namespace App\FormFields\LivewireFields\Fields;

use Closure;
use Illuminate\Support\Str;
use App\Forms\Fields\Config\FieldsDefaultConfig;
use App\FormFields\LivewireFields\Interfaces\ILivewireFields;
use App\FormFields\LivewireFields\Config\ConfigLivewireFields;

abstract class BaseField implements ILivewireFields
{
    public $label;

    public $name;
    
    public $key;

    public $default;

    public $rules;

    public $help;

    public $is_hidden = false;

    private $hidden_fn = null;

    public $size = 12;

    public function __construct(string $label = null, string $name = null)
    {
        $this->label = $label;
        $this->name = $name ?? Str::snake(Str::lower($label));
        $this->key = 'form_data.' . $this->name;

        $this->setDefaultConfigs();
    }

    public static function make(string $label = null, string $name = null) : ILivewireFields
    {
        return app(get_called_class(), [
            'label' => $label, 
            'name' => $name
        ]);
    }
    
    public function getLabel()
    {
        return $this->label;
    }

    public function getName()
    {
        return $this->name;
    }

    private function setDefaultConfigs()
    {
        $this->rules = $this->defaultRules();

        $baseConfig = ConfigLivewireFields::make();
        $this->size($baseConfig->input_width_size);
    }

    public function defaultRules() : array
    {
        return [];
    }

    public function size($size) : ILivewireFields
    {
        $this->size = $size;
        return $this;
    }

    public function getSize()
    {
        return $this->size;
    }

    public function value($value) : ILivewireFields
    {
        $this->value = $value;
        return $this;
    }

    public function default($default) : ILivewireFields
    {
        $this->default = $default;
        return $this;
    }

    public function getDefault()
    {
        return $this->default;
    }

    public function help($help) : ILivewireFields
    {
        $this->help = $help;
        return $this;
    }

    public function getHelp()
    {
        return $this->help;
    }

    public function rules(array $rules) : ILivewireFields
    {
        $this->rules = array_merge($this->rules, $rules);
        return $this;
    }

    public function getRules()
    {
        return $this->rules;
    }

    public function hiddenIf(Closure $hidden_fn) : ILivewireFields
    {
        $this->hidden_fn = $hidden_fn;

        return $this;
    }

    public function callHiddenFn(array $values)
    {
        if ($this->hidden_fn instanceof Closure) {
            $fn = $this->hidden_fn;
            $this->is_hidden = $fn($values);
        }
    }

    abstract public function getView() : string;
}
