var selectedItem = false;
var tagCount = tagComplted = 0;
$(function () {
    $('input#datasetHelper').autocomplete({
        source: function (request, response) {
            if ($('#auto_btn').prop("checked"))
            {
                currentTerm = request.term;
                $.ajax({
                    url: queryUrl + request.term,
                    dataType: "json",
                    data: {},
                    success: function (data) {
                        $('#list_all_ul').html('');
                        for (i = 0; i < data.result.length; i++)
                        {
                            $('#list_all_ul').append('<li class="ui-state-default"  id="' + data.result[i].id + '"><input name="item_ids" class="item_ids" type="checkbox" value=1 item_id="' + data.result[i].id + '">' + data.result[i].label + '</li>');
                        }
                    }
                });
            }
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
            $('#tagList' + tagId).append('<li class="ui-state-default" data-tag-id="' + tagId + '" id="' + ui.item.id + '"><a href="' + viewUrl + ui.item.id + '" target="_blank">' + ui.item.name + '</a></li>');
        },
        minLength: 1
    });
    $('a#tagAdd').click(function () {
        $('div#waiting').dialog();
        $.post(tagAddUrl, {Tag: {
                model: 'Dataset',
                name: $('input#datasetHelper').val()
            }}, function (r) {
            if (r.result === 'ok') {
                tagCount = $('[name="item_ids"]:checked').length;
                $('[name="item_ids"]:checked').each(function () {
                    $.get(tagSetUrl + $(this).attr('item_id') + '/' + r.id + '/on', {}, function () {
                        if (++tagComplted === tagCount) {
                            location.href = currentUrl
                        }
                    });
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

    $('#item_ids_all').on("click", function () {
        if ($('#item_ids_all').prop("checked"))
        {
            $('.item_ids').prop('checked', true);

        }
        else {
            $('.item_ids').prop('checked', false);
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