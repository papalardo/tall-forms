<div class="block" wire:ignore>
    <label class="text-gray-700" for="{{ $field->key }}">{{ $field->label }}</label>
    <div class="mt-1">
        <div
            x-data
            x-ref="quillEditor"
            x-init="
                quill = new Quill($refs.quillEditor, {theme: 'snow'});
                quill.on('text-change', function () {
                    $dispatch('input', quill.root.innerHTML);
                });
            "
            wire:model.debounce.2000ms="{{ $field->key }}"
        >
            {!! $form_data[$field->name] ?? '' !!}
        </div>
    </div>
    @include('fields.error-help')
</div>

@push('styles')
  <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endpush

@push('scripts')
  <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
@endpush
{{-- 
@push('scripts')
<script>
    new Quill('#{{ $field->name }}', {
        placeholder: @json($field->placeholder),
        toolbar: '#toolbar'
    })
</script>
@endpush --}}