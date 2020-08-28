<div class="block">
    <label class="text-gray-700" for="{{ $field->key }}">{{ $field->label }}</label>
    <input class="form-input mt-1 block w-full" type="{{ $field->type }}" wire:model.lazy="{{ $field->key }}" id="{{ $field->key }}" placeholder="{{ $field->placeholder }}">
    @include('fields.error-help')
</div>