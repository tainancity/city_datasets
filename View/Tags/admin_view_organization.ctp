<style>
    .list{ list-style-type: none; margin: 5px; float: left; margin-right: 10px; background: #eee; padding: 5px; width: 200px;overflow:hidden;font-size:18px;}
    .list_dataset{background:#fff;border:1px solid #f1f1f1;padding:2px;margin:2px;font-size:15px;color: #1c94c4;}
    .list_dataset a{color: #1c94c4;}
</style>
<div id="TagsAdminView">
    <h3><?php
        echo implode(' > ', array(
            $this->Html->link('標籤', '/admin/tags/index'),
            $this->data['Tag']['name'] . ' / ' . $this->data['Tag']['model'],
        ));
        ?></h3><hr />
    <h4>已標籤資料</h4>
    <?php
    foreach ($tags AS $tag) {
        echo '<div class="col-md-12">';
        echo '<b>' . $tag['Tag']['name'] . '</b><br />';
        foreach ($items as $item) {
            if (!empty($tag['Organization'][$item['Organization']['id']])) {
                $msg_datasets = '';
                foreach ($tag['Organization'][$item['Organization']['id']] AS $dataset) {
                    $msg_datasets.= '<div class="list_dataset">';
                    $msg_datasets.= $this->Html->link($dataset['Dataset']['name'], '/admin/datasets/view/' . $dataset['Dataset']['id'], array('target' => '_blank'));
                    $msg_datasets.= '</div>';
                }
            } else {
                $msg_datasets = '<div class="list_dataset"> ~ 無 ~ </div>';
            }
            echo '<div class="list">';
            echo $this->Html->link($item['Organization']['name'], '/admin/organizations/view/' . $item['Organization']['id'], array('target' => '_blank'));
            echo $msg_datasets;
            echo '</div>';
        }
        echo '</div>';
    }
    ?>
    <div class="clearfix"></div>
    <hr />
    <h4>未標籤資料</h4>
    <?php
    foreach ($items as $item) {
        $packages = 0;
        $msg_datasets = "";
        foreach ($item['Organization']['datasets'] as $dataset) {
            if (empty($dataset['Dataset']['name'])) {
                continue;
            }
            if (empty($dataset['LinksTag'])) {
                $msg_datasets.= '<div class="list_dataset">';
                $msg_datasets.= $this->Html->link($dataset['Dataset']['name'], '/admin/datasets/view/' . $dataset['Dataset']['id'], array('target' => '_blank'));
                $msg_datasets.= '</div>';
            }
            $packages++;
        }
        echo '<div class="list">';
        echo $this->Html->link($item['Organization']['name'] . "(" . $packages . ")", '/admin/organizations/view/' . $item['Organization']['id'], array('target' => '_blank'));
        echo $msg_datasets;
        echo '</div>';
    }
    ?>
    <div class="clearfix"></div>
</div>
<script>
    var tagSetUrl = '<?php echo $this->Html->url('/admin/tags/habtmSet/Organization/'); ?>';
    var clickedLine = null;
    $(function () {
        $('a.removeTag').click(function () {
            var organizationId = $(this).attr('data-id');
            var tagId = $(this).attr('data-tag-id');
            clickedLine = $(this).parents('tr');
            $.get(tagSetUrl + organizationId + '/' + tagId + '/off', {}, function () {
                clickedLine.remove();
            });
            return false;
        });
    })
</script>