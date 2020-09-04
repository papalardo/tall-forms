<input
    type="hidden" 
    class="hidden"
    wire:model.lazy="{{ $field->key }}"
    @foreach(["name", "value"] as $attr)
        @if($field->{$attr})
            {{ $attr }}="{{ $field->{$attr} }}"
        @endif
    @endforeach
/>