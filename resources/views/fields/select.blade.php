<label class="block">
    <span class="text-gray-700">
        {{ $field->label }}
    </span>
    <select class="form-select block w-full mt-1 @error($field->key) form-select-error @enderror" wire:model="{{ $field->key }}">
        <option value="">{{ $field->placeholder ?? 'Selecione uma opção' }}</option>
        @foreach($field->options as $key => $option)
            <option value="{{ $key }}">{{ $option }}</option>
        @endforeach
    </select>

    @include('fields.error-help')
</label>