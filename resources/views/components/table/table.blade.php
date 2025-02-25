<table class="table {{ isset($tableClass) ? $tableClass : '' }}">
    <thead>
        <tr>
            {!! isset($ths) ? $ths : '' !!}
        </tr>
    </thead>
    <tbody>
        {!! isset($trs) ? $trs : '' !!}
    </tbody>
</table>
