<?php

namespace App\FormFields\LivewireFields\Fields;

use App\FormFields\Traits\HasMultiple;
use App\FormFields\Traits\HasPlaceholder;
use App\FormFields\LivewireFields\Interfaces\IMultipleFields;

class FileField extends BaseField implements IMultipleFields
{
    use HasPlaceholder, HasMultiple;
    
    /**
     * Examples:
     * .gif,.jpg
     * .doc,.docx
     * audio/*
     * video/*
     * image/*
     */
    public $accept = "*";

    public $dir = '/';

    public $disk = 'public';

    public function type($type)
    {
        $this->type = $type;
        return $this;
    }

    public function accept($accept)
    {
        $this->accept = $accept;
        return $this;
    }

    public function getAccept()
    {
        return $this->accept;
    }

    public function dir($dir)
    {
        $this->dir = $dir;
        return $this;
    }
    
    public function disk($disk)
    {
        $this->disk = $disk;
        return $this;
    }
    
    public function getView() : string
    {
        return 'form-fields.livewire-fields.file';
    }
}
