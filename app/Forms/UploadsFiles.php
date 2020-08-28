<?php

namespace App\Forms;

use App\Helper;
use Illuminate\Support\Str;
use App\Forms\Fields\FileField;
use Illuminate\Support\Facades\Storage;

trait UploadsFiles
{
    public static function fileUpload()
    {
        $storage_disk = 'temp';
        $storage_path = Helper::normalizePath(implode('/', [request()->input('dir', '/'), (string) Str::uuid()]));
        $files = [];

        foreach (request()->file('files') as $file) {
            $files[] = [
                'path' => $file->storeAs($storage_path, $file->getClientOriginalName(), $storage_disk),
                'disk' => $storage_disk,
                'dir' => $storage_path,
                'name' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'mime_type' => $file->getMimeType()
            ];
        }

        return ['field_name' => request()->input('field_name'), 'uploaded_files' => $files];
    }

    public function fileUpdate($field_name, $uploaded_files)
    {
        foreach ($this->fields() as $field) {
            if ($field->name == $field_name) {
                $value = $field->is_multiple ? array_merge($this->form_data[$field_name], $uploaded_files) : $uploaded_files[0];
                break;
            }
        }

        $this->form_data[$field_name] = $value ?? [];
        $this->updated('form_data.' . $field_name);
    }

    public function fileIcon($mime_type)
    {
        $icons = [
            'image' => 'fa-file-image',
            'audio' => 'fa-file-audio',
            'video' => 'fa-file-video',
            'application/pdf' => 'fa-file-pdf',
            'application/msword' => 'fa-file-word',
            'application/vnd.ms-word' => 'fa-file-word',
            'application/vnd.oasis.opendocument.text' => 'fa-file-word',
            'application/vnd.openxmlformats-officedocument.wordprocessingml' => 'fa-file-word',
            'application/vnd.ms-excel' => 'fa-file-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml' => 'fa-file-excel',
            'application/vnd.oasis.opendocument.spreadsheet' => 'fa-file-excel',
            'application/vnd.ms-powerpoint' => 'fa-file-powerpoint',
            'application/vnd.openxmlformats-officedocument.presentationml' => 'fa-file-powerpoint',
            'application/vnd.oasis.opendocument.presentation' => 'fa-file-powerpoint',
            'text/plain' => 'fa-file-alt',
            'text/html' => 'fa-file-code',
            'application/json' => 'fa-file-code',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'fa-file-word',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'fa-file-excel',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation' => 'fa-file-powerpoint',
            'application/gzip' => 'fa-file-archive',
            'application/zip' => 'fa-file-archive',
            'application/x-zip-compressed' => 'fa-file-archive',
            'application/octet-stream' => 'fa-file-archive',
        ];

        if (isset($icons[$mime_type])) {
            return $icons[$mime_type];
        }
        $mime_group = explode('/', $mime_type, 2)[0];

        return (isset($icons[$mime_group])) ? $icons[$mime_group] : 'fa-file';
    }

    public function moveFileFromTempDisk($path, $newDisk)
    {
        return Storage::disk($newDisk)->put($path, Storage::disk('temp')->get($path));
    }

    public function handleFiles()
    {
        foreach ($this->fields() as $field) {
            if ($field instanceof FileField) {
                if ($field->is_multiple) {
                    foreach ($this->form_data[$field->name] as $key => $file) {
                        if ($this->moveFileFromTempDisk($file['path'], $field->disk)) {
                            $this->form_data[$field->name][$key]['disk'] = $field->disk;
                        }
                    }
                } else {
                    if ($this->moveFileFromTempDisk($this->form_data[$field->name]['path'], $field->disk)) {
                        $this->form_data[$field->name]['disk'] = $field->disk;
                    }
                }
            }
        }
    }
}
