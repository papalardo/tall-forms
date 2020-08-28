<div class="block">
    <span class="text-gray-700">{{ $field->label }}</span>
    <div class="mt-1">
        @if($field->is_multiple)
            @foreach($field->options as $value => $label)
                <div>
                    <label class="inline-flex items-center">
                        <input class="form-checkbox" type="checkbox" id="{{ $field->name }}.{{ $loop->index }}" value="{{ $value }}" wire:model.lazy="{{ $field->key }}">
                        <span class="ml-2">
                            <label for="{{ $field->name }}.{{ $loop->index }}">{{ $label }}</label>
                        </span>
                    </label>
                </div>
            @endforeach
        @else
            <label class="inline-flex items-center">
                <input class="form-checkbox" type="checkbox" id="{{ $field->key }}" wire:model="{{ $field->key }}" wire:model="{{ $field->key }}">
                <span class="ml-2">
                    <label for="{{ $field->key }}">{{ $field->label }}</label>
                </span>
            </label>
        @endif
    </div>
</div>