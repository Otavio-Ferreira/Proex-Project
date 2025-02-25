<div class="dropdown-menu {{ isset($class) ? $class : '' }}" data-bs-theme="{{ isset($theme) ? $theme : '' }}">
    @if (isset($header))
        <span class="dropdown-header {{ isset($classHeader) ? $classHeader : '' }}">{{ $header }}</span>
    @endif
    @if (isset($slot))
        {!! $slot !!}
    @else
        @if (count($links) > 0)
            @foreach ($links as $link)
                <a class="dropdown-item {{ isset($link['class']) ? $link['class'] : '' }}" href="{{ isset($link['href']) ? $link['href'] : '' }}">
                    @isset($link['icon'])
                        <i class="ti icon me-2 {{ $link['icon'] }}"></i>
                    @endisset
                    {{ isset($link['text']) ? $link['text'] : '' }}
                    {!! isset($link['span']) ? $link['span'] : '' !!}
                </a>
                @if(isset($link['divider']) && $link['divider'] == true)
                    <div class="dropdown-divider"></div>
                @endif
            @endforeach
        @endif
    @endif
</div>