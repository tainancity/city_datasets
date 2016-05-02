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
    <!--	
<table class="table table-bordered" id="TagsAdminIndexTable">
    <thead>
        <tr>
            <th>名稱</th>
            <th class="actions">操作</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $i = 0;
    foreach ($items as $item) {
        $class = null;
        if ($i++ % 2 == 0) {
            $class = ' class="altrow"';
        }
        ?>
                        <tr<?php echo $class; ?>>
                            <td><?php
        echo $this->Html->link($item['Organization']['name'], '/admin/organizations/view/' . $item['Organization']['id']);
        ?></td>
                            <td>
                                <div class="btn-group">
                                    <a href="#" class="removeTag btn btn-default" data-tag-id="<?php echo $this->data['Tag']['id']; ?>" data-id="<?php echo $item['Organization']['id']; ?>">移除</a>
                                </div>
                            </td>
                        </tr>
    <?php } // End of foreach ($items as $item) {   ?>
    </tbody>
</table>
    -->
    <?php
    foreach ($items as $item) {
        echo '<div  class="list" >';

        $packages = 0;
        $msg_datasets = "";
        foreach ($item['Organization']['datasets'] as $item_datasets) {
            //print_r($item_datasets);
            $msg_datasets.= '<div class="list_dataset">';
            $msg_datasets.= $this->Html->link($item_datasets['Dataset']['name'], '/admin/datasets/view/' . $item_datasets['Dataset']['id'], array('target' => '_blank'));
            $msg_datasets.= '</div>';
            $packages++;
        }
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