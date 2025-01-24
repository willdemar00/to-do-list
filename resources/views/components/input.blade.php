<div class="form-group">
    <input name="{{ $name }}" type="{{ $type }}" value="{{ $value }}"
        @foreach ($attr as $key => $value)
           @if ($errors->has($name) && $key === 'class')
               class="{{ $value }} is-invalid "
           @endif
               @if (is_string($key))
                   {{ $key }}="{{ $value }}"
               @else
                   {{ $value }}
               @endif @endforeach>
    @if ($errors->has($name))
        <div class="alert-danger">{{ $errors->first($name) }}</div>
    @endif
</div>
