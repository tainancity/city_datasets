<div id="TagsAdminIndex">
    <h2>標籤</h2>
    <div class="btn-group">
        <?php echo $this->Html->link('列表', array('action' => 'index'), array('class' => 'btn btn-default')); ?>
        <?php echo $this->Html->link('地方縣市', array('action' => 'organizations'), array('class' => 'btn btn-default')); ?>
        <?php echo $this->Html->link('資料集', array('action' => 'datasets'), array('class' => 'btn btn-primary')); ?>
    </div>
    <div class="pull-right"><?php
        echo $this->Form->input('Tag.keyword', array(
            'label' => '查詢',
            'div' => 'form-group',
            'class' => 'form-control',
            'value' => $keyword,
        ));
        ?></div>
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
        echo '<div class="list">';
        echo '<input type=text class="tagName" value="' . $item['Tag']['name'] . '" data-id="' . $item['Tag']['id'] . '" size=15 />';
        echo '<ul class="sortable droptrue" data-tag-id="' . $item['Tag']['id'] . '" id="tagList' . $item['Tag']['id'] . '">';
        foreach ($item['Dataset'] AS $dataset) {
            echo '<li class="ui-state-default" data-tag-id="' . $item['Tag']['id'] . '" id="' . $dataset['Dataset']['id'] . '">';
            echo $this->Html->link($dataset['Dataset']['name'] . ' - ' . $dataset['Organization']['name'], '/admin/datasets/view/' . $dataset['Dataset']['id'], array('target' => '_blank'));
            echo '</li>';
        }
        echo '</ul>';
        echo '<input type=text class="col-md-12 tagItem" placeholder="新增資料項" data-id="' . $item['Tag']['id'] . '" size=15 />';
        echo '</div>';
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
    echo '相關的資料集';
    echo '<div style="text-align:right"><input name="item_ids_all" id="item_ids_all" type="checkbox" value=1  >全選</div>';
    echo '<ul class="sortable droptrue" id="list_all_ul" data-tag-id="" >';

    echo '</ul></div>';
    ?>
    <div class="clearfix"></div>


    <div id="savemsg" style="display: none;">已儲存</div>
    <div id="waiting" style="display: none;">處理中...請稍後</div>
    <div class="paging"><?php echo $this->element('paginator'); ?></div>
</div>
<script>
    var currentUrl = '<?php echo $this->Html->url(array('')); ?>';
    var queryUrl = '<?php echo $this->Html->url('/datasets/q/'); ?>';
    var viewUrl = '<?php echo $this->Html->url('/admin/datasets/view/'); ?>';
    var tagAddUrl = '<?php echo $this->Html->url('/admin/tags/add/'); ?>';
    var tagEditUrl = '<?php echo $this->Html->url('/admin/tags/edit/'); ?>';
    var tagSetUrl = '<?php echo $this->Html->url('/admin/tags/habtmSet/Dataset/'); ?>';
</script>
<?php
$this->Html->script('c/tags/datasets', array('inline' => false));
