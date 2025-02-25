window.addEventListener('load', function() {
    let columns = document.querySelectorAll('.kanbanColumn');

    columns.forEach(element => {
        let value = localStorage.getItem(element.id);

        if (value != undefined) {
            $(element).addClass('small')
        }
    });
});

$('.recallColumn').on('click', function() {
    let column = $(this).data('column')
    let id = $(this).data('id')

    $(`.${column}`).addClass('small')

    localStorage.setItem(`${id}`, 'small');
});

$('.returnColumnSize').on('click', function() {
    let column = $(this).data('column')
    let id = $(this).data('id')

    $(`.${column}`).removeClass('small')

    localStorage.removeItem(`${id}`);
});

$(document).ready(function () {
    // componente qnd for table o type
    $('.dt-container').each(function () {
        var item = $(this).find('tbody')

        var hasScrollBar = item[0].scrollHeight > this.clientHeight;

        if (hasScrollBar) {
            $(this).find('.card').css('margin-left', '16px');
            $(this).find('.card').css('margin-right', '8px');
            $(this).css('margin-right', '8px');
        } else {
            $(this).find('.card').css('margin-left', '16px');
            $(this).find('.card').css('margin-right', '16px');
        }
    });

    // componente qnd for qualquer outra coisa (COPIAR ESSE)
    $('.helpers').each(function () {
        var hasScrollBar = this.scrollHeight > this.clientHeight;
        if (hasScrollBar) {
            $(this).find('.cardHelper').css('margin-right', '8px');
            $(this).css('margin-right', '8px');
        } else {
            $(this).find('.cardHelper').css('margin-right', '16px');
        }
    });
});
