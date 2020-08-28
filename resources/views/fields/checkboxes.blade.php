<div>
    @foreach($field->options as $value => $label)
        <input type="checkbox" id="{{ $field->name }}.{{ $loop->index }}" value="{{ $value }}" wire:model.lazy="{{ $field->key }}">
        <label for="{{ $field->name }}.{{ $loop->index }}">{{ $label }}</label>
    @endforeach
</div>