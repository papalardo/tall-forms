<div class="block">
    <label class="text-gray-700" for="{{ $field->getName() }}">{{ $field->getLabel() }}</label>
    <file-input
        accept="{{ $field->getAccept() }}"
        name="{{ $field->getName() }}"
        wire:model="{{ $field->key }}"
        endpoint="{{ route('laravel-livewire-forms.file-upload') }}"
        class-namespace="{{ get_class($this) }}"
        :multiple="{{ json_encode((bool) $field->isMultiple()) }}"
        csrf-token="{{ csrf_token() }}"
        files-directory="{{ $field->dir }}"
    ></file-input>
    @include('form-fields.livewire-fields.error-help')
</div>
