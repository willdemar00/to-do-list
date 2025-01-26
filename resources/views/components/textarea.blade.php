<div class="form-group">
    <textarea name="{{ $name }}" 
        @foreach ($attr as $key => $valueAttr)
           @if ($errors->has($name) && $key === 'class')
               class="{{ $valueAttr }} is-invalid "
           @endif
               @if (is_string($key))
                   {{ $key }}="{{ $valueAttr }}"
               @else
                   {{$valueAttr }}
               @endif 
            @endforeach
               >{{ $value }}</textarea>
    @if ($errors->has($name))
        <div class="alert-danger">{{ $errors->first($name) }}</div>
    @endif
</div>
