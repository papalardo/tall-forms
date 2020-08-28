<?php

namespace App\Forms\Fields;

use Closure;
use Illuminate\Support\Str;
use App\Forms\Fields\Interfaces\IBaseField;

abstract class BaseField implements IBaseField
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

    public function __construct($label, $name)
    {
        $this->label = $label;
        $this->name = $name ?? Str::snake(Str::lower($label));
        $this->key = 'form_data.' . $this->name;
        
        $this->rules = $this->defaultRules();
    }

    public static function make($label, $name = null)
    {
        return new static($label, $name);
    }

    public function defaultRules() : array
    {
        return [];
    }

    public function size($size) : IBaseField
    {
        $this->size = $size;
        return $this;
    }

    public function default($default) : IBaseField
    {
        $this->default = $default;
        return $this;
    }

    public function help($help) : IBaseField
    {
        $this->help = $help;
        return $this;
    }

    public function rules($rules) : IBaseField
    {
        $this->rules = array_merge($this->rules, $rules);
        return $this;
    }

    public function hiddenIf(Closure $hidden_fn) : IBaseField
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

    abstract public function view() : string;
}
