<style>
    .list{  margin: 5px; float: left; background: #eee; padding: 5px;}
    ul{ list-style-type: none; margin: 0px;padding: 5px; }
    .list li { margin: 5px; padding: 2px; font-size: 15px;  }
    input{font-size:18px;}
    .link{text-decoration:none;color:#fff;background:#BD0000}
    #savemsg{display:none;position:fixed;padding:20px;width:100px;text-align:center;background:rgba(200,200,200,0.8);border:2px solid #333;top:45%;left:45%}
</style>
<div id="TagsAdminIndex">
    <h2>標籤</h2>
    <div class="btn-group">
        <?php echo $this->Html->link('列表', array('action' => 'index'), array('class' => 'btn btn-default')); ?>
        <?php echo $this->Html->link('組織', array('action' => 'organizations'), array('class' => 'btn btn-default')); ?>
        <?php echo $this->Html->link('資料集', array('action' => 'datasets'), array('class' => 'btn btn-primary')); ?>
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
        echo '<div class="col-md-3 list">';
        echo '<input type=text class="col-md-12 tagName" value="' . $item['Tag']['name'] . '" data-id="' . $item['Tag']['id'] . '" />';
        echo '<ul class="sortable droptrue" data-tag-id="' . $item['Tag']['id'] . '" id="tagList' . $item['Tag']['id'] . '">';
        foreach ($item['Dataset'] AS $dataset) {
            echo '<li class="ui-state-default" data-tag-id="' . $item['Tag']['id'] . '" id="' . $dataset['Dataset']['id'] . '">';
            echo $this->Html->link($dataset['Dataset']['name'] . ' - ' . $dataset['Organization']['name'], '/admin/datasets/view/' . $dataset['Dataset']['id'], array('target' => '_blank'));
            echo '</li>';
        }
        echo '</ul>';
        echo '<input type=text class="col-md-12 tagItem" placeholder="新增資料項" data-id="' . $item['Tag']['id'] . '" />';
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
        </div>
    </div>
    <div id="savemsg" style="display: none;">已儲存</div>
    <div class="paging"><?php echo $this->element('paginator'); ?></div>
</div>
<script>
    var currentUrl = '<?php echo $this->Html->url(array()); ?>';
    var queryUrl = '<?php echo $this->Html->url('/datasets/q/'); ?>';
    var viewUrl = '<?php echo $this->Html->url('/admin/datasets/view/'); ?>';
    var tagAddUrl = '<?php echo $this->Html->url('/admin/tags/add/'); ?>';
    var tagEditUrl = '<?php echo $this->Html->url('/admin/tags/edit/'); ?>';
    var tagSetUrl = '<?php echo $this->Html->url('/admin/tags/habtmSet/Dataset/'); ?>';
</script>
<?php
$this->Html->script('c/tags/datasets', array('inline' => false));