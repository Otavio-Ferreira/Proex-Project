<div class="modal modal-blur fade" id="{{ isset($id) ? $id : '' }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog {{ isset($class) ? $class : '' }}" role="document">
        <form method="post" action="{{ isset($route) ? $route : '' }}" class="modal-content">
            @csrf
            @method('DELETE')
            @if (isset($background))
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-status {{ isset($background) ? $background : '' }}"></div>
            @endif
            <div class="modal-body {{ isset($classBody) ? $classBody : '' }}">
                {!! isset($content) ? $content : '' !!}
            </div>
            <div class="modal-footer">
                <div class="w-100">
                    <div class="row">
                        <div class="col">
                            <button type="{{ isset($typeBtnClose) ? $typeBtnClose : '' }}"
                                class="btn {{ isset($classBtnClose) ? $classBtnClose : '' }}" data-bs-dismiss="modal">
                                @isset($iconBtnClose)
                                    <i class="ti icon me-2 {{ $iconBtnClose }}"></i>
                                @endisset
                                {{ isset($textBtnClose) ? $textBtnClose : '' }}
                            </button>
                        </div>
                        <div class="col">
                            <button type="{{ isset($typeBtnSave) ? $typeBtnSave : '' }}"
                                class="btn {{ isset($classBtnSave) ? $classBtnSave : '' }}">
                                @isset($iconBtnSave)
                                    <i class="ti icon me-2 {{ $iconBtnSave }}"></i>
                                @endisset
                                {{ isset($textBtnSave) ? $textBtnSave : '' }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
