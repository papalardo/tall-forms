<?php

namespace App\FormFields\LivewireFields\Interfaces;

interface ILivewireFields
{
    public function defaultRules() : array;

    public function default($default) : ILivewireFields;

    public function getDefault();

    public function help(string $help) : ILivewireFields;

    public function getHelp();

    public function rules(array $rules) : ILivewireFields;

    public function getRules();

    public function getView() : string;
}

