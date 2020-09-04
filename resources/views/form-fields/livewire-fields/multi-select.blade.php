<div class="block">
    <label class="text-gray-700" for="{{ $field->key }}">{{ $field->label }}</label>
    <div class="w-full flex flex-col items-center mx-auto mt-1">
        <div class="w-full">
            <multi-select
                :limit="{{ json_encode($field->getChoiceLimit()) }}"
                :add-on-enter="@json($field->getAddOnEnter())"
                wire:model="{{ $field->key }}"
                placeholder="{{ $field->getPlaceholder() }}"
                :options="{{ json_encode($field->getOptions()) }}"
                :value="{{ json_encode($form_data[$field->name] ?: null) }}"
                :realtime-search-enabled="@json($field->realtimeSearchEnabled())"
                livewire-field-key="{{ $fieldKey }}"
                livewire-ctx="@this"
            ></multi-select>
        </div>
    </div>
    @include('form-fields.livewire-fields.error-help')
    @include('form-fields.livewire-fields.error-help', [
        'key' => $field->key . ".*",
        'help' => false
    ])
</div>
