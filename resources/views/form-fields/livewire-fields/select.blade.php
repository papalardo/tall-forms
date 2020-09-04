<label class="block">
    <span class="text-gray-700">
        {{ $field->getLabel() }}
    </span>
    <select class="form-select block w-full mt-1 @error($field->key) form-select-error @enderror" wire:model="{{ $field->key }}">
        <option>{{ $field->getPlaceholder() ?? 'Selecione uma opção' }}</option>
        @foreach($field->getOptions() as $key => $option)
            <option value="{{ $key }}">{{ $option }}</option>
        @endforeach
    </select>

    @include('form-fields.livewire-fields.error-help')
</label>