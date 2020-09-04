<?php

namespace App\Forms\LivewireForms;

use App\User;
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
use App\FormFields\LivewireFields\Traits\HasRules;
use App\FormFields\LivewireFields\Traits\UploadsFiles;
use App\FormFields\LivewireFields\Interfaces\ILivewireFields;

class FormComponent extends \Livewire\Component
{
    use HasRules;

    use UploadsFiles;
    
    public $model;
    
    public $rich_text_media_ids = [];
    
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

    protected function addField(ILivewireFields $field)
    {
        array_push($this->fields, $field);
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
                $fieldIsArray = $field instanceof IMultipleFields && $field->isMultiple();
                $this->form_data[$field->name] = $field->default ?? ($fieldIsArray ? [] : null);
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
        if (method_exists($field, 'realtimeSearchEnabled') && $field->realtimeSearchEnabled()) {
            $this->emit('multiselect-options-changed.' . $fieldKey, $field->search($keyword));
        }
    }
}
