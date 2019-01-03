<button
        @if($dismissModal ?? false)
                data-dismiss="modal"
        @endif

        type="{{ $type ?? 'button' }}"
        class="btn btn-{{ $class ?? 'default' }} {{ $extraClass ?? '' }}"
>
    @if($icon ?? false)
        <em class="fa fa-{{ $iconClass ?? 'check' }}"></em>
    @endif
    {{ $label ?? 'Submit' }}
</button>