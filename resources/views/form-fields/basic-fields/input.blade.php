<div class="block">
    @if($field->getLabel())
        <label class="text-gray-700" for="{{ $field->getName() }}">{{ $field->getLabel() }}</label>
    @endif
    <input
        id="{{ $field->getName() }}" 
        type="{{ $field->getType() }}" 
        name="{{ $field->getName() }}"
        class="form-input mt-1 block w-full"
        placeholder="{{ $field->getPlaceholder() }}"
        value="{{ $field->getValue() }}"
    />
    {{-- @include('fields.error-help') --}}
</div>