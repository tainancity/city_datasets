var selectedItem = false;
$(function () {
    $('input#datasetHelper').autocomplete({
        source: function (request, response) {
            currentTerm = request.term;
            $.ajax({
                url: queryUrl + request.term,
                dataType: "json",
                data: {},
                success: function (data) {
                    response(data.result);
                }
            });
        },
        select: function (event, ui) {
            selectedItem = ui.item;
        },
        minLength: 1
    });
    $('input.tagItem').autocomplete({
        source: function (request, response) {
            currentTerm = request.term;
            $.ajax({
                url: queryUrl + request.term,
                dataType: "json",
                data: {},
                success: function (data) {
                    response(data.result);
                }
            });
        },
        select: function (event, ui) {
            var tagId = $(this).attr('data-id');
            $.get(tagSetUrl + ui.item.id + '/' + tagId + '/on');
            $('#tagList' + tagId).append('<li class="ui-state-default" data-tag-id="' + tagId + '" id="' + ui.item.id + '">' + ui.item.name + '</li>');
        },
        minLength: 1
    });
    $('a#tagAdd').click(function () {
        $.post(tagAddUrl, {Tag: {
                model: 'Dataset',
                name: $('input#datasetHelper').val()
            }}, function (r) {
            if (r.result === 'ok') {
                $.get(tagSetUrl + selectedItem.id + '/' + r.id + '/on', {}, function () {
                    location.href = currentUrl;
                });
            }
        }, 'json');
        return false;
    });
    $("ul.droptrue").sortable({
        connectWith: "ul"
    });

    $('input.tagName').change(function () {
        var tagId = $(this).attr('data-id');
        $.post(tagEditUrl + tagId, {Tag: {
                name: $(this).val()
            }}, function () {
            showsave();
        });
    });

    $("ul.droptrue").droppable({
        tolerance: 'touch',
        drop: function (event, ui) {
            var oTagId = ui.draggable.attr('data-tag-id');
            var nTagId = $(this).attr('data-tag-id');
            var datasetId = ui.draggable.attr('id');
            if (oTagId !== nTagId) {
                ui.draggable.attr('data-tag-id', nTagId);
                $(ui.draggable).detach().appendTo(this);//先把項目移過去
                $.get(tagSetUrl + datasetId + '/' + oTagId + '/off');
                $.get(tagSetUrl + datasetId + '/' + nTagId + '/on');
                showsave();
            }
        }
    });

});
function showsave()
{
    $('#savemsg').show();
    setTimeout(function () {
        $('#savemsg').fadeOut();
    }, 2000);
}