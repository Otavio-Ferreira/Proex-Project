<form class="w-100" method="{{ isset($method) ? $method : '' }}" action="{{ isset($route) ? $route : '' }}">
  <div class="d-flex align-items-center w-100">
    <div class="input-icon me-2 w-100">
      <input type="text" name="search" class="form-control w-100" placeholder="{{ isset($placeholder) ? $placeholder : '' }}"
        value="{{ isset($value) ? $value : '' }}">
      {{-- <span class="input-icon-addon">
        <i class="ti icon text-primary ti-search"></i>
      </span> --}}
    </div>
    @if (isset($button) && $button == true)
        <button type="submit" class="btn">Pesquisar</button>
    @endif
  </div>
</form>
