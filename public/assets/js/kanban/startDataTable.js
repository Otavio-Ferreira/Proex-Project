$(document).ready(function() {
    var table = $('table:not(.exclude)').DataTable({
        info: false,
        ordering: false,
        paging: false,
        searching: true,
        autoWidth: true,  
        scrollCollapse: true,
        scrollY: 'calc(100vh - 195px)',
        border: false,
        language: {
            zeroRecords: " ",
            emptyTable: " ",
        },
    });

    $('#customFilter').on('keyup', function() {
        table.search(this.value).draw();
    });

    $('.customFilter').on('keyup', function() {
        table.search(this.value).draw();
    });
});
