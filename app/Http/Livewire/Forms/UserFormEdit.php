<?php

namespace App\Http\Livewire\Forms;

use App\User;
use Illuminate\Validation\Rule;
use App\Forms\LivewireForms\FormComponent;
use App\Forms\Fields\Config\FieldsDefaultConfig;
use App\FormFields\LivewireFields\Fields\FileField;
use App\FormFields\LivewireFields\Fields\InputField;
use App\FormFields\LivewireFields\Fields\SelectField;
use App\FormFields\LivewireFields\Fields\CheckboxField;
use App\FormFields\LivewireFields\Fields\RichTextField;
use App\FormFields\LivewireFields\Fields\MultiSelectField;
use App\FormFields\LivewireFields\Fields\DateTimePickerField;

class UserFormEdit extends FormComponent
{
    public function mount(User $user)
    {
        $user->musics = ['Samba' => 'samba'];
        $user->how_meet = [];
        $this->setFormProperties($user);
    }

    protected function setFields()
    {
        $this->addField(
            InputField::make('Nome', 'name')
                ->hiddenIf(function ($values) {
                    return isset($values['is_admin']) && $values['is_admin'] == true;
                })
                ->size(6)
                ->rules(['required'])
        );
            
        $this->addField(
            DateTimePickerField::make('Data de nascimento', 'email_verified_at')
                ->rules(['required'])
        );

        $this->addField(
            InputField::make('Senha', 'password')
                ->type('password')
                ->size(6)
        );
        
        $this->addField(
            RichTextField::make('Escreva um pouco sobre você', 'about')
        );

        $this->addField(
            SelectField::make('Gênero', 'gender', [
                'Masculino' => 'm',
                'Fêminino' => 'f'
            ])
        );
            

        $this->addField(
            MultiSelectField::make('Que tipo de música você curte ?', 'musics')->options([
                'Rock' => 'rock',
                'Hip hop' => 'hip_hop',
                'Samba' => 'samba'
            ])
            ->choiceLimit(2)
            ->addOnEnter()
            ->help('Pressione enter para adicionar um novo. Limite de 2 itens.')
            ->rules([
                // 'required',
                // '.*' => Rule::in([
                //     'rock',
                //     'hip_hop',
                //     'samba',
                // ]),
            ])
        );
        
        $this->addField(
            MultiSelectField::make('Quem te recomendou ?', 'who_recommended')
                ->options(function ($keyword) {
                    return User::where('email', 'like', "%{$keyword}%")->limit(10)->get()->pluck('id', 'name')->toArray();
                })
                // ->rules([
                //     'required'
                // ])
                ->help('Busca em tempo real.')
        );

        $this->addField(
            FileField::make('Avatar')
                ->dir('avatar')
                ->disk('images')
                ->accept('image/*')
                ->rules(['required'])
                ->help('Máximo de 1 arquivo')
        );

        $this->addField(
            CheckboxField::make('É admin', 'is_admin')
        );

        $this->addField(
            CheckboxField::make('Como conheceu', 'how_meet')->options(['Internet', 'TV', 'Amigos'])
        );
        
        $this->addField(
            FileField::make('Gallery')
                ->dir('gallery')
                ->disk('images')
                ->multiple()
                ->accept('image/*')
                ->rules(['required'])
        );
    }

    public function success()
    {
        $this->model->update([
            'email_verified_at' => $this->form_data['email_verified_at']
        ]);
        dd(
            $this->model->toArray(),
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
