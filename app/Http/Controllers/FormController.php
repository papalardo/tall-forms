<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Forms\BasicForm\Form;
use App\FormFields\BasicFields\Fields\InputField;
use App\FormFields\BasicFields\Fields\SelectField;

class FormController extends Controller
{
    public function create()
    {
        return view('form-page', [
            'form' => $this->mountForm(Form::make(route('form.store')))
        ]);
    }

    public function store(Request $request)
    {
        dd($request->all());
    }

    private function mountForm(Form $form)
    {
        return $form->addFields([
                InputField::make('Nome', 'name')->placeholder('Selecione um nome'),
                SelectField::make('Nome', 'name', ['L' => 'Large', 'S' => 'Small'])->placeholder('Selecione um nome'),
                SelectField::make('Senha', 'password', ['L' => 'Large', 'S' => 'Small'])
            ]);
    }
}
