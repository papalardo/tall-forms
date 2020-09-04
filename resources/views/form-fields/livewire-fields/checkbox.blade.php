<div class="block">
    <div class="mt-1">
        @if($field->isMultiple())
            <span class="text-gray-700">{{ $field->getLabel() }}</span>
            @foreach($field->getOptions() as $value => $label)
                <div>
                    <label class="inline-flex items-center">
                        <input class="form-checkbox" type="checkbox" id="{{ $field->getName() }}.{{ $loop->index }}" value="{{ $value }}" wire:model="{{ $field->key }}" wire:key="{{ $loop->index }} ">
                        <span class="ml-2">
                            <label for="{{ $field->getName() }}.{{ $loop->index }}">{{ $label }}</label>
                        </span>
                    </label>
                </div>
            @endforeach
        @else
            <label class="inline-flex items-center">
                <input class="form-checkbox" type="checkbox" id="{{ $field->key }}" wire:model="{{ $field->key }}" wire:model="{{ $field->key }}">
                <span class="ml-2">
                    <label for="{{ $field->key }}">{{ $field->getLabel() }}</label>
                </span>
            </label>
        @endif
    </div>
</div>