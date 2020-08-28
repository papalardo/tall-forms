<?php

namespace App\Http\Livewire;

use App\User;
use App\Models\Media;
use App\Forms\HasRules;
use Livewire\Component;
use App\Forms\UploadsFiles;
use Illuminate\Support\Arr;
use App\Forms\HandlesArrays;
use App\Forms\Fields\BaseField;
use App\Forms\Fields\FileField;
use Illuminate\Validation\Rule;
use App\Forms\Fields\InputField;
use App\Forms\Fields\SelectField;
use App\Forms\Fields\CheckboxField;
use App\Forms\Fields\RichTextField;
use App\Forms\Fields\CheckboxesField;
use App\Forms\Fields\MultiSelectField;
use App\Forms\Fields\Interfaces\HasArrayValues;

class FormComponent extends Component
{
    use HasRules;

    use HandlesArrays;

    use UploadsFiles;
    
    public $model;

    public $mounted = false;

    private $fields = [];
    
    public $form_data = [
        'tesing' => [
            'Ruby' => 2,
            'JAVA' => 3,
        ]
    ];

    public $form_data_copy = [];

    protected $listeners = ['fileUpdate', 'multiSelectRemove', 'multiSelectSearch', 'multiSelectClick'];

    public function mount()
    {
        $this->setFormProperties();


        // $user->load('avatar');
    }

    public function updated($field)
    {
        $this->updateFields();

        $this->validateOnly($field, $this->rules(true));
    }

    public function updateFields()
    {
        $this->setFields();
        $this->setHiddenFields();
    }

    private function setFields()
    {
        $this->fields = [];

        $this->addField(InputField::class, 'Nome', 'name')
            ->hiddenIf(function ($values) {
                return $values['is_admin'] == true;
            })
            ->size(6);
        
        $this->addField(SelectField::class, 'Gênero', 'gender')
            ->options([
                'Masculino' => 'm',
                'Fêminino' => 'f'
            ])
            ->size(6);

        $this->addField(CheckboxField::class, 'Admin', 'is_admin')
            ->default(false);
        
        

        $this->addField(MultiSelectField::class, 'Que tipo de música você curte ?', 'musics')
            ->options([
                'Rock' => 'rock',
                'Hip hop' => 'hip_hop',
                'Samba' => 'samba'
            ])
            ->rules([
                'required',
                '.*' => Rule::in(['Teste222']),
            ]);

        $this->addField(FileField::class, 'Avatar')
            ->dir('avatar')
            ->disk('images')
            ->multiple()
            ->accept('image/*')
            ->rules(['required']);

        $this->addField(RichTextField::class, 'Escreva um pouco sobre você', 'about');
    }

    public function setHiddenFields()
    {
        foreach ($this->fields() as $field) {
            $field->callHiddenFn($this->form_data);
        }
    }

    private function addField($field, $label, $name = null)
    {
        $fieldClass = app($field, [
            'label' => $label,
            'name' => $name
        ]);

        if (! $fieldClass instanceof BaseField) {
            throw new \Exception("Field [$field] not extending {BaseField::class}");
        }

        array_push($this->fields, $fieldClass);

        return $fieldClass;
    }

    public function getAvailableFields()
    {
        return array_filter($this->fields(), function ($field) {
            return $field->is_hidden === false;
        });
    }

    public function fields()
    {
        return $this->fields;
        // is_hidden

        $fields = [
            InputField::make('Nome', 'name'),
            InputField::make('Email', 'email')->type('email'),
            InputField::make('Senha', 'password')->type('password'),
            
            FileField::make('Avatar')
                ->dir('avatar')
                ->disk('images')
                ->multiple()
                ->accept('image/*')
                ->rules(['required']),

            MultiSelectField::make('tesing')
                ->options([
                    'teste',
                    'hellow'
                ])
                ->rules([
                    'required',
                    '.*' => Rule::in(['Teste222']),
                ]),
            MultiSelectField::make('tesing2')
                ->options(function ($keyword) {
                    return User::where('email', 'like', "%{$keyword}%")->limit(10)->get()->pluck('id', 'email')->toArray();
                })
                ->rules([
                    'required'
                ]),
            RichTextField::make('richtext')
        ];

        if (!empty($this->form_data['name']) && $this->form_data['name']  == 'teste') {
            $fields[] = InputField::make('Password')->type('password');
        }
        
        return $fields;
    }

    public function setFormProperties($model = null)
    {
        $this->setFields();

        $this->model = $model;
        if ($model) {
            $this->form_data = $model->toArray();
        }

        foreach ($this->fields() as $field) {
            if (!isset($this->form_data[$field->name])) {
                $array = $field instanceof HasArrayValues || (property_exists($field, 'is_multiple') && $field->is_multiple);
                $this->form_data[$field->name] = $field->default ?? ($array ? [] : null);
            }
        }

        $this->setHiddenFields();
    }

    public function formView()
    {
        return view('livewire.form-component', [
            'fields' => $this->getAvailableFields()
            // 'fields' => $this->fields()
        ]);
    }

    public function render()
    {
        return $this->formView();
    }

    public function submit()
    {
        // dd($this->form_data);

        
        $this->validate($this->rules());

        dd('passou');

        $field_names = [];
        foreach ($this->fields() as $field) {
            $field_names[] = $field->name;
        }
        $this->form_data = Arr::only($this->form_data, $field_names);
        
        $this->handleFiles();
        
        $this->success();
    }

    public function errorMessage($message)
    {
        return str_replace('form data.', '', $message);
    }

    public function success()
    {
        $this->model->avatar()->update($this->form_data['avatar']);
        // $user->avatar()->save(new Media($this->form_data['avatar']));
        dd(
            $user
        );
    }

    public function saveAndStay()
    {
        $this->submit();
        $this->saveAndStayResponse();
    }

    public function saveAndStayResponse()
    {
        //
    }

    public function saveAndGoBack()
    {
        $this->submit();
        $this->saveAndGoBackResponse();
    }

    public function saveAndGoBackResponse()
    {
        //
    }

    public function multiSelectSearch($fieldKey, $keyword)
    {
        $field = $this->fields()[$fieldKey];
        if ($field->is_realtime_search) {
            $this->emit('multiselect-options-changed.' . $fieldKey, $field->search($keyword));
        }
    }
}
