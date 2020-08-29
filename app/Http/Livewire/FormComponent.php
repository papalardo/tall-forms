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
use App\Forms\Fields\DateTimePickerField;
use App\Forms\Fields\Interfaces\HasArrayValues;

class FormComponent extends Component
{
    use HasRules;

    use HandlesArrays;

    use UploadsFiles;
    
    public $model;

    public $mounted = false;

    private $fields = [];
    
    public $form_data = [];

    protected $listeners = [
        'multiSelectSearch'
    ];

    protected function setFields()
    {
        //
    }

    public function updated($field)
    {
        $this->updateFields();

        $this->validateOnly($field, $this->rules(true));
    }

    public function updateFields()
    {
        $this->setHiddenFields();
    }

    public function setHiddenFields()
    {
        foreach ($this->fields() as $field) {
            $field->callHiddenFn($this->form_data);
        }
    }

    protected function addField($field, $label, $name = null)
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
        $this->fields = [];

        $this->setFields();

        return $this->fields;
    }

    public function setFormProperties($model = null)
    {
        $this->model = $model;
        if ($model) {
            $this->form_data = $model->toArray();
        }

        foreach ($this->fields() as $field) {
            if (!isset($this->form_data[$field->name])) {
                $array = $field instanceof HasArrayValues || (property_exists($field, 'is_multiple') && $field->is_multiple);
                $this->form_data[$field->name] = $field->default ?? ($array ? [] : null);
            }
            if ($field instanceof DateTimePickerField && isset($this->form_data[$field->name])) {
                $this->form_data[$field->name] = $model->{$field->name}->format('Y-m-d H:i:s');
            }
        }

        $this->setHiddenFields();
    }

    public function formView()
    {
        return view('livewire.form-component', [
            'fields' => $this->getAvailableFields()
        ]);
    }

    public function render()
    {
        return $this->formView();
    }

    public function submit()
    {
        $this->validate($this->rules());

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

    protected function success()
    {
        //
    }

    protected function saveAndStay()
    {
        $this->submit();
        $this->saveAndStayResponse();
    }

    protected function saveAndStayResponse()
    {
        //
    }

    protected function saveAndGoBack()
    {
        $this->submit();
        $this->saveAndGoBackResponse();
    }

    protected function saveAndGoBackResponse()
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
