<?php

namespace App\FormFields\BasicFields\Fields;

use Illuminate\Support\Str;
use InvalidArgumentException;
use App\FormFields\Traits\HasPlaceholder;
use App\FormFields\BasicFields\Interfaces\IBasicFields;

abstract class BaseField implements IBasicFields
{
    use HasPlaceholder;
    private $value;

    private $name;

    private $label;

    private $size;

    private $default;

    public function __construct(string $label = null, string $name = null) {
        if($label == null && $name == null) {
            throw new InvalidArgumentException("Label or Name cant is not null");
        }
        if($label) {
            $this->label($label);
        }
        if($name) {
            $this->name($name ?? Str::snake(Str::lower($label)));
        }
    }

    public function value(string $value) : IBasicFields
    {
        $this->value = $value;
        return $this;
    }

    public function getValue() 
    {
        return $this->value;
    }

    public function name(string $name) : IBasicFields
    {
        $this->name = $name;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function label(string $label) : IBasicFields
    {
        $this->label = $label;
        return $this;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function size(string $size) : IBasicFields
    {
        $this->size = $size;
        return $this;
    }

    public function getSize()
    {
        return $this->size;
    }

    public function default(string $default) : IBasicFields
    {
        $this->default = $default;
        return $this;
    }

    public function getDefault()
    {
        return $this->default;
    }

    abstract public function getView();
}
