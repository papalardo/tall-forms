<div class="block">
    @if($field->getLabel())
        <label class="text-gray-700" for="{{ $field->getName() }}">{{ $field->getLabel() }}</label>
    @endif
    <input
        id="{{ $field->getName() }}" 
        type="{{ $field->getType() }}" 
        class="form-input mt-1 block w-full" 
        wire:model.lazy="{{ $field->key }}"
        placeholder="{{ $field->getPlaceholder() }}"
    />
    @include('form-fields.livewire-fields.error-help')
</div>