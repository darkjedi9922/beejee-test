/// <reference path="..\node_modules\\@types\\jquery\\index.d.ts" />

$('.todo-status-checkbox').change(function() {
    var isChecked = $(this).is(':checked');
    var statusLabel = $(this).next();
    
    // this checkbox is located as tr > td > div > input
    var itemId = $(this).parent().parent().parent().data('item-id');
    
    if (isChecked) {
        statusLabel.removeClass('badge-light');
        statusLabel.addClass('badge-success');
        statusLabel.text('Выполнено');
    } else {
        statusLabel.removeClass('badge-success');
        statusLabel.addClass('badge-light');
        statusLabel.text('Не выполнено');
    }
    
    $.ajax({
        url: '/item/edit?id=' + itemId,
        method: 'post',
        data: { status: isChecked ? '1' : '0' },
        statusCode: {
            403: function () {
                window.location.replace("/login");
            }
        }
    })
});

var startItemTextEditing = function () {
    var tableCell = $(this).parent();
    var tableCellHtml = tableCell.html();
    var oldText = tableCell.find('.todo-item-text').first().text();
    var itemId = tableCell.parent().data('item-id');

    var updateText = function (textInput) {
        $.ajax({
            url: '/item/edit?id=' + itemId,
            method: 'post',
            data: { text: textInput.value },
            statusCode: {
                403: function() {
                    window.location.replace("/login");
                }
            }
        })
    }

    var hideInput = function (textInput) {
        tableCell.html(tableCellHtml);
        tableCell.find('.todo-item-text').first().text(textInput.value);

        if (textInput.value !== oldText) updateText(textInput);

        // Since in the new html appears new edit button, it does not have this
        // callback, so we need to set it again.
        tableCell.find('.todo-item-text-edit').click(startItemTextEditing);
    }

    var showInput = function () {
        var textInput = document.createElement('input');
        textInput.type = 'text';
        textInput.className = 'form-control';
        textInput.value = oldText;
        $(tableCell).html(textInput);

        // Catch event when editing is finished and the text IS changed.
        $(textInput).change(function() { hideInput(textInput) });

        // Catch event when editing is finished and the text IS NOT changed.
        $(textInput).keypress(function () {
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if (keycode == '13' && textInput.value === oldText) {
                // Enter pressed, so we need to hide input.
                hideInput(textInput);
            }

            // Stop the event from propogation to other handlers
            // If this line will be removed, then keypress event handler attached 
            // at document level will also be triggered
            event.stopPropagation();
        })

        textInput.focus();
    }

    showInput();
};

$('.todo-item-text-edit').click(startItemTextEditing);