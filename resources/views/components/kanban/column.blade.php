<div class="card {{ isset($bgColor) ? 'bg-transparent bg-' . $bgColor : '' }} p-0 kanbanColumn border-0 rounded-3 h-100 shadow-sm overflow-hidden {{ isset($dataColumn) ? $dataColumn : '' }}"
    id="{{ $id }}"
    style="min-width: {{ isset($widthCol) ? $widthCol : '260px' }}; max-width: {{ isset($widthCol) ? $widthCol : '260px' }};">
    <div class="card-body p-0">

        <div class="mb-2 px-3 pt-3">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h6 class="card-title text-uppercase d-flex align-items-center gap-2 returnColumnSize m-0"
                    data-id="{{ $id }}" data-column="{{ isset($dataColumn) ? $dataColumn : '' }}">
                    <span
                        class="title-column bg-{{ isset($colors) ? $colors : 'primary' }} py-1 px-2 rounded-3 text-white d-flex align-items-center gap-2">
                        <i class="ti icon ti-circle-dashed"></i>
                        {{ $title }}
                    </span>
                    <span class="text-black count-regist-kanban">{{ $badgeQtd }}</span>
                </h6>

                {{-- <button class="btn btn-icon btn-sm btn-ghost-secondary recallColumn" data-id="{{ $id }}"
                    data-column="{{ isset($dataColumn) ? $dataColumn : '' }}">
                    <i class="ti icon ti-arrow-badge-left fs-3 h-100 w-100"></i>
                </button> --}}
                {{-- <button class="btn btn-icon btn-sm btn-ghost-secondary recallColumn" >
                </button> --}}
                <span style="cursor: pointer;">
                    @if (isset($filter) && $filter != null)
                        <i class="ti incon ti-filter fs-3 h-100 w-100" data-bs-toggle="collapse"
                            data-bs-target="#filterData" aria-expanded="false" aria-controls="filterData" id="iconFilterDate"></i>
                    @endif
                    <i class="ti icon ti-arrow-badge-left hide-theme-light fs-1 text-{{ isset($colors) ? $colors : 'secondary' }} h-100 w-100 recallColumn"
                        data-id="{{ $id }}" data-column="{{ isset($dataColumn) ? $dataColumn : '' }}"></i>
                    <i class="ti icon ti-arrow-badge-left hide-theme-dark fs-1 text-secondary h-100 w-100 recallColumn"
                        data-id="{{ $id }}" data-column="{{ isset($dataColumn) ? $dataColumn : '' }}"></i>
                </span>
            </div>
            <hr class="m-0">
        </div>

        @if ($type == 'table')
            <table class="w-100 border-0" style="border: none !important;">
                <thead>
                    <tr>
                        <td class="p-0 border-0"></td>
                    </tr>
                </thead>
                <tbody class="{{ $classTbody }}" id="">
                    {{ $slot }}
                </tbody>
            </table>
        @elseif ($type == 'normal')
            <div class="{{ $classTbody }} mt-2 ps-3" style="height: calc(100vh - 257px); overflow-y: auto;">
                {{ $slot }}
            </div>
        @endif
    </div>
</div>
