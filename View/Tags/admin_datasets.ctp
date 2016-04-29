<style>
    .list{  margin: 5px; float: left; background: #eee; padding: 5px;}
    ul{ list-style-type: none; margin: 0px;padding: 5px; }
    .list li { margin: 5px; padding: 2px; font-size: 15px;  }
    input{font-size:18px;}
    .link{text-decoration:none;color:#fff;background:#BD0000}
    #savemsg{display:none;position:fixed;padding:20px;width:100px;text-align:center;background:rgba(200,200,200,0.8);border:2px solid #333;top:45%;left:45%}
</style>

<?php
$teno_o_organ_index = 0;
foreach ($items AS $item) {
    ++$teno_o_organ_index;
    echo '<div class="col-md-3 list">';
    echo '<input type=text class="col-md-12 tagName" value="' . $item['Tag']['name'] . '" data-id="' . $item['Tag']['id'] . '" />';
    echo '<ul class="sortable droptrue" data-tag-id="' . $item['Tag']['id'] . '" >';
    foreach ($item['Dataset'] AS $dataset) {
        echo '<li class="ui-state-default" data-tag-id="' . $item['Tag']['id'] . '" id="' . $dataset['Dataset']['id'] . '">';
        echo $this->Html->link($dataset['Dataset']['name'] . ' - ' . $dataset['Organization']['name'], '/admin/datasets/view/' . $dataset['Dataset']['id'], array('target' => '_blank'));
        echo '</li>';
    }
    echo '</ul></div>';
}
?>
<div class="clearfix"></div>
<hr />
<div class="col-md-12">
    <div class="col-md-6">
        <input type="text" id="datasetHelper" class="form-control" />
    </div>
    <div class="col-md-6">
        <a href="#" id="tagAdd" class="btn btn-default">新增標籤</a>
    </div>
</div>
<div id="savemsg" style="display: none;">已儲存</div>
<div class="paging"><?php echo $this->element('paginator'); ?></div>
<script>
    var currentUrl = '<?php echo $this->Html->url(array()); ?>';
    var queryUrl = '<?php echo $this->Html->url('/datasets/q/'); ?>';
    var tagAddUrl = '<?php echo $this->Html->url('/admin/tags/add/'); ?>';
    var tagEditUrl = '<?php echo $this->Html->url('/admin/tags/edit/'); ?>';
    var tagSetUrl = '<?php echo $this->Html->url('/admin/tags/habtmSet/Dataset/'); ?>';
</script>
<script>
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
</script>