<?php

namespace App\Forms\Fields;

use App\Forms\Fields\Traits\HasPlaceholder;

class FileField extends BaseField
{
    use HasPlaceholder;
    
    public $is_multiple;

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

    public function multiple()
    {
        $this->is_multiple = true;
        return $this;
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
    
    public function view() : string
    {
        return 'fields.file';
    }
}
