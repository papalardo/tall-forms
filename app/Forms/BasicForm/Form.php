<?php

namespace App\Forms\BasicForm;

use Illuminate\Support\Str;
use App\Forms\Fields\InputField;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Database\Eloquent\Model;
use App\Forms\Fields\Interfaces\IBaseField;
use App\FormFields\StaticFields\HiddenField;
use App\FormFields\BasicFields\Interfaces\IBasicFields;
use App\FormFields\StaticFields\Interfaces\IStaticFields;

class Form
{
    private $fields = [];

    private $action;

    private $method = 'POST';

    private $view = 'form';
    
    public $form_data = [];

    public function __construct(string $action, $method = 'POST')
    {
        $this->setAction($action);
        $this->setMethod($method);
    }

    public static function make(string $action, $method = 'POST')
    {
        return new static($action, $method);
    }

    public static function model(Model $model, string $action, $method = 'POST')
    {
        $form = new static($action, $method);
        $form->setValues($model);
        return $form;
    }

    public static function array(array $model, string $action, $method = 'POST')
    {
        $form = new static($action, $method);
        $form->setValues($model);
        return $form;
    }

    public function setValues($values)
    {
        if ($values instanceof Model) {
            $values = $values->toArray();
        }
        
        foreach ($values as $key => $value) {
            $this->form_data[$key] = $value;
        }
    }

    public function addFields(array $fields)
    {
        foreach($fields as $field) {
            $this->addField($field);
        }
        return $this;
    }

    public function addField(IBasicFields $field)
    {
        array_push($this->fields, $field);
        return $this;
    }

    private function setMethod($method)
    {
        $this->method = Str::upper($method);
        
        if (!in_array($this->method, ['POST', 'GET'])) {
            $this->addField(HiddenField::make('_method')->value($this->method));
            $this->method = 'POST';
        }

        return $this;
    }

    public function getMethod()
    {
        return $this->method;
    }
        
    public function setView($view)
    {
        $this->view = $view;
        return $this;
    }

    public function getView()
    {
        return $this->view;
    }

    public function setAction($action)
    {
        $this->action = URL::to($action);
        return $this;
    }

    public function getAction()
    {
        return $this->action;
    }

    private function prepareToRender()
    {
        foreach ($this->fields as $field) {
            if (isset($this->form_data[$field->getName()])) {
                $field->value($this->form_data[$field->getName()]);
                continue;
            }
            if(! empty($field->getDefault())) {
                $field->value($field->getDefault());
            }
        }
    }

    public function render()
    {
        $this->prepareToRender();

        return View::make($this->getView(), [
            'form' => $this,
            'fields' => $this->fields
        ]);
    }
}
