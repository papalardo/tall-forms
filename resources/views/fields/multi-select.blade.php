<div class="block">
    <label class="text-gray-700" for="{{ $field->key }}">{{ $field->label }}</label>
    <div class="w-full flex flex-col items-center mx-auto mt-1">
        <div class="w-full">
            <div class="flex flex-col items-center relative" 
                x-data='alpineMultiSelectField({
                    options: @json($field->options, JSON_HEX_APOS),
                    selectedValues: @json($form_data[$field->name] ?? []),
                    realtimeSearchEnabled: @json((bool) $field->is_realtime_search),
                    fieldKey: {{ $fieldKey }},
                    fieldModelKey: @json($field->key)
                })'
                x-init="() => {
                    setLivewireCtx(@this)
                    onMount()
                }"
                wire:ignore
                x-on:click.away="open = false"
            >
                <div class="w-full " x-ref="input">
                    <div class="p-1 flex form-input">
                        <div class="flex flex-auto flex-wrap">
                            <template x-for="([label, value]) in Object.entries(selectedValues)">
                                <div class="flex justify-center items-center m-1 font-medium py-1 px-2 bg-white rounded-full text-teal-700 bg-teal-100 border border-teal-300">
                                    <div class="text-xs font-normal leading-none max-w-full flex-initial" x-text="label"></div>
                                    <div class="flex flex-auto flex-row-reverse" x-on:click="open = false, toggle($dispatch, label, value)" wire:key="value">
                                        <div>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x cursor-pointer hover:text-teal-400 rounded-full w-4 h-4 ml-2">
                                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                                <line x1="6" y1="6" x2="18" y2="18"></line>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </template>
                            <div class="flex-1">
                                <input autocomplete="none" class="bg-transparent p-1 px-2 appearance-none outline-none h-full w-full text-gray-800" x-on:focus="open = true" id="{{ $field->key }}" x-model.debounce.1000ms="search">
                            </div>
                        </div>
                        <div class="text-gray-300 w-8 py-1 pl-2 pr-1 border-l flex items-center border-gray-200" x-on:click="open = !open">
                            <button x-bind:class="{'cursor-pointer w-6 h-6 text-gray-600 outline-none focus:outline-none transform transition duration-200 origin-center': true, 'rotate-180': open }">
                                <svg xmlns="http://www.w3.org/2000/svg" style="margin: 2px" width="100%" height="100%" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-up w-4 h-4">
                                    <polyline points="18 15 12 9 6 15"></polyline>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <div 
                    class="absolute shadow top-100 bg-white z-40 w-full lef-0 rounded max-h-select overflow-y-auto" 
                    x-show="open" 
                    x-bind:style="['top: ' + topPositionOptions + 'px']"
                    x-cloak
                >
                    <div class="flex flex-col w-full" style="max-height: 20rem">
                        <template x-for="([label, value]) in Object.entries(realtimeSearchEnabled ? options : filtredOptions)">
                            <div class="cursor-pointer w-full border-gray-100 rounded-t border-b hover:bg-teal-100" x-on:click="toggle($dispatch, label, value)">
                                <div x-bind:class="{'flex w-full items-center p-2 pl-2 border-transparent border-l-2 relative hover:border-teal-600': true, 'border-teal-600': selectedValues.hasOwnProperty(label) }" x-key="value">
                                    <div class="w-full items-center flex">
                                        <div class="mx-2 leading-6" x-text="label"></div>
                                    </div>
                                </div>
                            </div>
                        </template>
                        <div class="cursor-wait w-full border-gray-100 rounded-t border-b" x-show="busy">
                            <div class="flex w-full items-center justify-center p-2 pl-2 border-transparent">
                                <div class="loader ease-linear rounded-full border-8 border-t-8 border-gray-200 h-3 w-3"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('fields.error-help')
    @include('fields.error-help', [
        'key' => $field->key . ".*",
        'help' => false
    ])
</div>
