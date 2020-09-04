<div 
    class="block" 
    x-data='alpineFile({
        csrfToken: @json(csrf_token()),
        isMultiple: @json((bool) $field->is_multiple),
        fieldModelKey: @json($field->key)
    })'
    x-init="[
        setLivewireCtx(@this)
    ]"
    wire:model="{{ $field->key }}"
    x-on:files-changed="dispatchInputEvent($el, $event)"
    >
    <label class="text-gray-700" for="{{ $field->key }}">{{ $field->label }}</label>
    
    @if(!empty($form_data[$field->name]))
        <ul class="list-group mt-1">
            @foreach($field->is_multiple ? $form_data[$field->name] : [$form_data[$field->name]] as $key => $value)
                <li class="flex p-2 mb-1 items-center border border-gray-300 rounded">
                    <div class="flex-initial">
                        <img src="{{ Storage::disk($value['disk'])->url($value['path']) }}" alt="" class="w-10 h-10 bg-red-800 object-cover">
                    </div>
                    <div class="flex flex-auto ml-2 items-center">
                        <div class="flex-auto">
                            <div class="flex flex-col">
                                <a href="{{ Storage::url($value['path']) }}" target="_blank" class="truncate max-w-xs">
                                    {{ $value['name'] }}
                                </a>
                            </div>
                            <span class="truncate max-w-xs">{{ \App\Helper::formatBytes($value['size'], 'K') }}kb</span>
                        </div>
                        <div class="ml-2">
                            <button class="bg-red-600 rounded-full p-2"
                                    onclick="confirm('{{ __('Are you sure?') }}') || event.stopImmediatePropagation();"
                                    x-on:click="removeFile($dispatch, @json($key))">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="fill-current text-white w-3 h-3"><path d="M3 6v18h18v-18h-18zm5 14c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm5 0c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm5 0c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm4-18v2h-20v-2h5.711c.9 0 1.631-1.099 1.631-2h5.315c0 .901.73 2 1.631 2h5.712z"/></svg>
                            </button>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    @endif
    

    <div 
        class="p-3 mt-1 form-input hover:bg-teal-700 hover:text-teal-100 text-teal-700 cursor-pointer" 
        id="drop-area-{{ $field->name }}" 
        x-on:drop="onDrop($dispatch, $event)"
        wire:ignore
    >
        <label class="w-full flex flex-col items-center px-2 py-4 tracking-wide border border-dashed border-gray-300 cursor-pointer">
            <svg class="w-8 h-8 fill-current" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
            </svg>
            <span class="mt-2 text-base">{{ $field->placeholder ?? 'Arraste arquivos ou Clique para escolher' }}</span>
            <input type='file' accept="{{ $field->accept }}" class="hidden" id="input-file-{{ $field->name }}" multiple="@json((bool) $field->is_multiple)" x-on:change="onChange($event, $dispatch)" x-on:input.stop />
        </label>
    </div>

    @include('form-fields.livewire-fields.error-help')

</div>

@push('scripts')
<script>
    function alpineFile(args) {
        return {
            csrfToken: args.csrfToken,
            fieldModelKey: args.fieldModelKey,
            isMultiple: args.isMultiple || false,
            files: [],
            uploadFiles(files) {
                let form_data = new FormData();
                form_data.append('component', @json(get_class($this)));
                form_data.append('field_name', @json($field->name));
                form_data.append('dir', @json($field->dir));
                // form_data.append('disk', '{{ $field->disk }}');

                for (let i = 0; i < files.length; i++) {
                    form_data.append('files[]', files[i]);
                }

                fetch('{{ route('laravel-livewire-forms.file-upload') }}', {
                    method: 'POST',
                    body: form_data,
                    headers: {
                        'X-CSRF-Token': this.csrfToken
                    }
                })
                .then(res => res.json())
                .then(response => {
                    if(this.isMultiple) {
                        this.files.push(...response.uploaded_files)
                    } else {
                        this.files = response.uploaded_files.shift()
                    }
                });
            },
            setLivewireCtx(livewireCtx) {
                this.livewireCtx = livewireCtx
            },
            onChange($event, $dispatch) {
                this.uploadFiles($event.target.files)

                this.$nextTick(() => {
                    $dispatch('files-changed', this.files)
                })
            },
            onDrop($dispatch, $event) {
                this.uploadFiles(event.dataTransfer.files)

                this.$nextTick(() => {
                    $dispatch('files-changed', this.files)
                })
            },
            dispatchInputEvent($el, $event) {
                $el.value = $event.detail
                $el.dispatchEvent(new Event('input', {
                    'bubbles': true,
                    'cancelable': true              
                }))
            },
            removeFile($dispatch, index) {
                if(this.isMultiple) {
                    this.files.splice(index, 1)
                } else {
                    this.files = []
                }

                this.$nextTick(() => {
                    $dispatch('files-changed', this.files)
                })
            }
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const dropContainer = document.getElementById('drop-area-{{ $field->name }}')
        
        ;['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => dropContainer.addEventListener(eventName, (e) => (e.preventDefault(), e.stopPropagation()), false))

        ;['dragenter', 'dragover'].forEach(eventName => {
            dropContainer.addEventListener(eventName, highlight, false)
        })

        ;['dragleave', 'drop'].forEach(eventName => {
            dropContainer.addEventListener(eventName, unhighlight, false)
        })

        function highlight(e) {
            dropContainer.classList.add('bg-blue-800')
        }

        function unhighlight(e) {
            dropContainer.classList.remove('bg-blue-800')
        }
    });
</script>
@endpush