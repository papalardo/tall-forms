<div class="p-10">
    <div class="grid grid-cols-12 gap-3">
        @foreach($fields as $fieldKey => $field)
            <div class="col-span-{{ $field->size }}">
                @include($field->view())
            </div>
        @endforeach
        <div>
            <button wire:click="submit">
                Submit
            </button>
        </div>
    </div>
</div>