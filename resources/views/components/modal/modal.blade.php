<div class="modal modal-blur fade" id="{{ isset($id) ? $id : '' }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog {{ isset($class) ? $class : '' }}" role="document">
        <form action="{{ isset($route) ? $route : '' }}" method="post" class="modal-content" id="modal-form{{ isset($id) ? $id : '' }}">
            @if (isset($title))
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">{{ isset($title) ? $title : '' }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            @endif
            <div class="modal-body {{ isset($classBody) ? $classBody : '' }}">
                {!! isset($content) ? $content : '' !!}
            </div>
            <div class="modal-footer">
                <button type="{{ isset($typeBtnClose) ? $typeBtnClose : '' }}" class="btn {{ isset($classBtnClose) ? $classBtnClose : '' }}" data-bs-dismiss="modal">
                    @isset($iconBtnClose)
                    <i class="ti icon me-2 {{ $iconBtnClose }}"></i>
                    @endisset
                    {{ isset($textBtnClose) ? $textBtnClose : '' }}
                </button>
                <button type="{{ isset($typeBtnSave) ? $typeBtnSave : '' }}" class="btn {{ isset($classBtnSave) ? $classBtnSave : '' }}" form="modal-form{{ isset($id) ? $id : '' }}">
                    @isset($iconBtnSave)
                    <i class="ti icon me-2 {{ $iconBtnSave }}"></i>
                    @endisset
                    {{ isset($textBtnSave) ? $textBtnSave : '' }}
                </button>
            </div>
        </form>
    </div>
</div>