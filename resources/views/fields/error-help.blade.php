
@error($key ?? $field->key)
    <div class="text-sm text-red-600" role="alert">
        {{ $this->errorMessage($message) }}
    </div>
@elseif($field->help && (!isset($help) || $help !== false))
    <small class="form-text text-muted">{{ $field->help }}</small>
@enderror