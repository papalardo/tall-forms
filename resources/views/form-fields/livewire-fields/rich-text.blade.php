<div class="block">
    <label class="text-gray-700" for="{{ $field->key }}">{{ $field->getLabel() }}</label>
    <div class="mt-1 is-v rich-text-component">
        <rich-text
            value="{{ $form_data[$field->getName()] }}"
            wire:model.lazy.debounce.2s="{{ $field->key }}"
            livewire-ctx="@this"
            :livewire-set-media-ids="true"
            csrf-token="{{ csrf_token() }}"
            upload-image-endpoint="{{ route('laravel-livewire-forms.rich-text-media') }}"
            name="{{ $field->getName() }}"
        />
    </div>
    @include('form-fields.livewire-fields.error-help')
</div>