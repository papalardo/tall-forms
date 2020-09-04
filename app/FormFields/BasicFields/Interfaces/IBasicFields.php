<?php

namespace App\FormFields\BasicFields\Interfaces;

interface IBasicFields
{
    public function __construct(string $label, string $name);

    public function value(string $value) : IBasicFields;

    public function getValue();

    public function name(string $value) : IBasicFields;

    public function getName();

    public function label(string $value) : IBasicFields;

    public function getLabel();

    public function size(string $value) : IBasicFields;

    public function getSize();

    public function default(string $value) : IBasicFields;

    public function getDefault();

    public function getView();
}
