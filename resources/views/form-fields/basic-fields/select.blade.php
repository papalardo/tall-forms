<label class="block">
    <span class="text-gray-700">
        {{ $field->getLabel() }}
    </span>
    <select class="form-select block w-full mt-1 @error($field->getName()) form-select-error @enderror">
        <option>{{ $field->getPlaceholder() ?? 'Selecione uma opção' }}</option>
        @foreach($field->getOptions() as $value => $option)
            <option 
                value="{{ $value }}" 
                @if($field->getValue() == $value) selected @endif
            >{{ $option }}</option>
        @endforeach
    </select>

    {{-- @include('fields.error-help') --}}
</label>