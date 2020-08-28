<?php

namespace App\Forms\Fields\Interfaces;

interface IBaseField
{
    public function __construct($label, $name);

    public function defaultRules() : array;

    public function default($default) : IBaseField;

    public function help($help) : IBaseField;

    public function rules($rules) : IBaseField;

    public function view() : string;
}
