<div id="TagsAdminIndex">
    <h2>標籤</h2>
    <div class="btn-group">
        <?php echo $this->Html->link('列表', array('action' => 'index'), array('class' => 'btn btn-default')); ?>
        <?php echo $this->Html->link('組織', array('action' => 'organizations'), array('class' => 'btn btn-primary')); ?>
        <?php echo $this->Html->link('資料集', array('action' => 'datasets'), array('class' => 'btn btn-default')); ?>
    </div>
    <div><?php
        echo $this->Paginator->counter(array(
            'format' => '第 {:page} 頁 / 共 {:pages} 頁，總數： {:count}  筆'
        ));
        ?></div>
    <div class="paging"><?php echo $this->element('paginator'); ?></div>
    <?php
    $teno_o_organ_index = 0;
    foreach ($items AS $item) {
        ++$teno_o_organ_index;
        //echo '<div class="col-md-3 list">';		
        //echo '<input type=text class="col-md-12 tagName" value="' . $item['Tag']['name'] . '" data-id="' . $item['Tag']['id'] . '" />';
        echo '<div class="list">';
        echo '<input type=text class="tagName" value="' . $item['Tag']['name'] . '" data-id="' . $item['Tag']['id'] . '" size=15 />';
        echo '<ul class="sortable droptrue" data-tag-id="' . $item['Tag']['id'] . '" >';
        foreach ($item['Organization'] AS $organization) {
            echo '<li class="ui-state-default" data-tag-id="' . $item['Tag']['id'] . '" id="' . $organization['Organization']['id'] . '">';
            echo $this->Html->link($organization['Organization']['name'] . ' - ' . $organization['Parent']['name'], '/admin/datasets/view/' . $organization['Organization']['id'], array('target' => '_blank'));
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
            <input name="auto_btn" id="auto_btn" type="checkbox" value=1 checked >自動篩選
        </div>
    </div>

    <div class="clearfix"></div>
    <hr />
    <?php
    echo '<div class=list_all>';
    echo '尚未歸類組織';
    echo '<div style="text-align:right"><input name="item_ids_all" id="item_ids_all" type="checkbox" value=1  >全選</div>';
    echo '<ul class="sortable droptrue" id="list_all_ul" data-tag-id="" >';
    $teno_o_organ_index = 0;
    //print_r($allOrganizations);
    foreach ($allOrganizations AS $allOrganization) {

        echo '<li class="ui-state-default" data-tag-id="" id="' . $allOrganization['Organization']['id'] . '">';
        echo '<input name="item_ids" class="item_ids" type="checkbox" value=1 item_id="' . $allOrganization['Organization']['id'] . '">';
        echo $this->Html->link($allOrganization['Organization']['name'] . ' - ' . $allOrganization['Parent']['name'], '/admin/datasets/view/' . $allOrganization['Organization']['id'], array('target' => '_blank'));
        echo '</li>';
    }
    echo '</ul></div>';
    ?>
    <div class="clearfix"></div>

    <div id="savemsg" style="display: none;">已儲存</div>
    <div class="paging"><?php echo $this->element('paginator'); ?></div>
</div>
<script>
    var currentUrl = '<?php echo $this->Html->url(array()); ?>';
    var queryUrl = '<?php echo $this->Html->url('/organizations/q/'); ?>';
    var viewUrl = '<?php echo $this->Html->url('/admin/organizations/view/'); ?>';
    var tagAddUrl = '<?php echo $this->Html->url('/admin/tags/add/'); ?>';
    var tagEditUrl = '<?php echo $this->Html->url('/admin/tags/edit/'); ?>';
    var tagDelUrl = '<?php echo $this->Html->url('/admin/tags/delete/'); ?>';
    var tagSetUrl = '<?php echo $this->Html->url('/admin/tags/habtmSet/Organization/'); ?>';
</script>
<?php
$this->Html->script('c/tags/organizations', array('inline' => false));
