<div class="offcanvas {{ isset($class) ? $class : '' }}" tabindex="-1" id="{{ isset($id) ? $id : '' }}"
  aria-labelledby="offcanvasExampleLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasExampleLabel">{{ isset($title) ? $title : '' }}</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <form action="{{ isset($route) ? $route : '' }}" method="post" class="modal-content"
      id="offcanvas-form{{ isset($id) ? $id : '' }}">
      @csrf
      <div class="modal-body {{ isset($classBody) ? $classBody : '' }}">
        {!! isset($content) ? $content : '' !!}
      </div>

      @isset($route)
        <div class="d-flex w-100 justify-content-between mt-3">
          <button type="submit"
            class="btn btn-success ms-auto {{ isset($classBtnSave) ? $classBtnSave : '' }}" form="offcanvas-form{{ isset($id) ? $id : '' }}">Salvar</button>
        </div>
      @endisset
    </form>
  </div>
</div>
