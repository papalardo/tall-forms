<div>
    <form action="{{ $form->getAction() }}" method="{{ $form->getMethod() }}">
        @foreach($fields as $fieldName => $field)
            @include($field->getView())
        @endforeach
        <button type="submit"> Salvar </button>
    </form>
</div>