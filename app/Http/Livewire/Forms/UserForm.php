<?php

namespace App\Http\Livewire\Forms;

use App\User;
use App\Forms\Fields\FileField;
use Illuminate\Validation\Rule;
use App\Forms\Fields\InputField;
use App\Forms\Fields\SelectField;
use App\Forms\Fields\CheckboxField;
use App\Forms\Fields\RichTextField;
use App\Http\Livewire\FormComponent;
use App\Forms\Fields\MultiSelectField;

class UserForm extends FormComponent
{
    public function mount()
    {
        $this->setFormProperties();
    }

    protected function setFields()
    {
        $this->fields = [];

        $this->addField(InputField::class, 'Nome', 'name')
            ->hiddenIf(function ($values) {
                return $values['is_admin'] == true;
            })
            ->size(6)
            ->rules([
                'required'
            ]);

        $this->addField(InputField::class, 'Senha', 'password')
            ->type('password')
            ->size(6);
        
        $this->addField(SelectField::class, 'Gênero', 'gender')
            ->options([
                'Masculino' => 'm',
                'Fêminino' => 'f'
            ]);

        $this->addField(CheckboxField::class, 'Admin', 'is_admin')
            ->default(false);

        $this->addField(MultiSelectField::class, 'Quem te recomendou ?', 'who_recommended')
            ->options(function ($keyword) {
                return User::where('email', 'like', "%{$keyword}%")->limit(10)->get()->pluck('id', 'email')->toArray();
            })
            ->rules([
                'required'
            ])
            ->help('Este campo atualiza em tempo real.');

        $this->addField(MultiSelectField::class, 'Que tipo de música você curte ?', 'musics')
            ->options([
                'Rock' => 'rock',
                'Hip hop' => 'hip_hop',
                'Samba' => 'samba'
            ])
            ->rules([
                'required',
                '.*' => Rule::in([
                    'rock',
                    'hip_hop',
                    'samba',
                ]),
            ]);

        $this->addField(FileField::class, 'Avatar')
            ->dir('avatar')
            ->disk('images')
            ->multiple()
            ->accept('image/*')
            ->rules(['required']);

        $this->addField(RichTextField::class, 'Escreva um pouco sobre você', 'about');
    }

    public function success()
    {
        dd(
            $this->form_data
        );
        // User::create($this->form_data);
    }

    public function saveAndStayResponse()
    {
        return redirect()->route('users.create');
    }

    public function saveAndGoBackResponse()
    {
        return redirect()->route('users.index');
    }
}
