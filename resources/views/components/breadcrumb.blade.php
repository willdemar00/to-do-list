<div class="line-guide px-0">
    <small>
        <ul>
            @foreach($items as $item)
                <li>
                    @if(is_array($item) && isset($item['route']))
                        <a href="{{ $item['route'] }}">{{ $item['name'] }}</a>
                    @elseif(is_array($item))
                        {{ $item['name'] }}
                    @else
                        {{ $item }}
                    @endif
                </li>
                @if (!$loop->last)
                    <li><i class="fa-solid fa-angle-right"></i></li>
                @endif
            @endforeach
        </ul>
    </small>
</div>