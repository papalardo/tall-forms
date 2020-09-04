<div class="block">
    <label class="text-gray-700" for="{{ $field->key }}">{{ $field->getLabel() }}</label>
    <span class="is-v">
        <date-time-picker
            wire:model="{{ $field->key }}" 
            value="{{ $form_data[$field->getName()] ?? '' }}" 
            format="{{ $field->format }}"
        ></date-time-picker>
    </span>
    @include('form-fields.livewire-fields.error-help')
</div>