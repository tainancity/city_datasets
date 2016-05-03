<div id="DatasetsAdminTags">
    <h2>待標籤資料集</h2>
    <div class="btn-group">
        <?php echo $this->Html->link('新增', array('action' => 'add'), array('class' => 'btn btn-default')); ?>
        <?php echo $this->Html->link('列表', array('action' => 'index'), array('class' => 'btn btn-default')); ?>
        <?php echo $this->Html->link('待標籤', array('action' => 'tags'), array('class' => 'btn btn-primary')); ?>
    </div>
    <div><?php
        echo $this->Paginator->counter(array(
            'format' => '第 {:page} 頁 / 共 {:pages} 頁，總數： {:count}  筆'
        ));
        ?></div>
    <div class="paging"><?php echo $this->element('paginator'); ?></div>
    <table class="table table-bordered" id="DatasetsAdminTagsTable">
        <thead>
            <tr>
                <?php
                if (!empty($op)) {
                    echo '<th>&nbsp;</th>';
                }
                ?>
                <th>地方縣市</th>
                <th>名稱</th>
                <th><?php echo $this->Paginator->sort('Dataset.modified', '更新時間', array('url' => $url)); ?></th>
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
                        if (empty($item['Organization']['id'])) {
                            echo '--';
                        } else {
                            echo $this->Html->link($item['Organization']['name'], array(
                                'controller' => 'organizations',
                                'action' => 'view',
                                $item['Organization']['id']
                                    ), array('target' => '_blank'));
                        }
                        ?></td>
                    <td><?php
                        echo $this->Html->link($item['Dataset']['name'], array('action' => 'view', $item['Dataset']['id']), array('target' => '_blank'));
                        ?></td>
                    <td><?php
                        echo $item['Dataset']['modified'];
                        ?></td>
                </tr>
            <?php } // End of foreach ($items as $item) {  ?>
        </tbody>
    </table>
    <div class="paging"><?php echo $this->element('paginator'); ?></div>
    <div id="DatasetsAdminTagsPanel"></div>
    <script type="text/javascript">
        //<![CDATA[
        $(function () {
<?php
if (!empty($op)) {
    $remoteUrl = $this->Html->url(array('action' => 'habtmSet', $foreignModel, $foreignId));
    ?>
                $('#DatasetsAdminTagsTable input.habtmSet').click(function () {
                    var remoteUrl = '<?php echo $remoteUrl; ?>/' + this.value + '/';
                    if (this.checked == true) {
                        remoteUrl = remoteUrl + 'on';
                    } else {
                        remoteUrl = remoteUrl + 'off';
                    }
                    $('div#messageSet' + this.value).load(remoteUrl);
                });
    <?php
}
?>
        });
        //]]>
    </script>
</div>