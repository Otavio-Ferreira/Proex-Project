<ol class="breadcrumb {{isset($type) ? 'breadcrumb-'.$type : ''}} ">
    @foreach ($items as $item)
        <li class="breadcrumb-item {{ $item['active'] ? 'active' : ($item['disabled'] ? 'disabled' : '') }}">
            <a href="{{ $item['url'] }}">{{ $item['label'] }}</a>
        </li>
    @endforeach
</ol>
