<li class="nav-item  {{ isset($links) ? 'dropdown' : '' }} {{ $isActive == true ? 'active' : '' }}">
    <a class="nav-link {{ isset($links) ? 'dropdown-toggle' : '' }}" href="{{ isset($route) ? $route : '#' }}" @if (isset($links)) data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false" @endif>
        <span class="nav-link-icon d-md-none d-lg-inline-block">
            <i class="ti {{ $icon }}" style="font-size: 20px;"></i>
        </span>
        <span class="nav-link-title">
            {{ $title }}
        </span>
    </a>
    @isset($links)
    <div class="dropdown-menu" >
        {!!$links!!}
    </div>
    @endisset
</li>