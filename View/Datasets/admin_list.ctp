<?php
if (!isset($url)) {
    $url = array();
}

if (!empty($foreignId) && !empty($foreignModel)) {
    $url = array($foreignModel, $foreignId);
}
?>
<div id="DatasetsAdminIndex">
    <h2><?php echo __('資料集', true); ?></h2>
    <div class="btn-group">
        <?php echo $this->Html->link('新增', array_merge($url, array('action' => 'add')), array('class' => 'btn btn-default')); ?>
    </div>
    <div><?php
        echo $this->Paginator->counter(array(
            'format' => '第 {:page} 頁 / 共 {:pages} 頁，總數： {:count}  筆'
        ));
        ?></div>
    <div class="paging"><?php echo $this->element('paginator'); ?></div>
    <table class="table table-bordered" id="DatasetsAdminIndexTable">
        <thead>
            <tr>
                <?php
                if (!empty($op)) {
                    echo '<th>&nbsp;</th>';
                }
                ?>
                <?php if (empty($scope['Dataset.organization_id'])): ?>
                    <th><?php echo $this->Paginator->sort('Dataset.organization_id', '地方縣市', array('url' => $url)); ?></th>
                <?php endif; ?>

                <th><?php echo $this->Paginator->sort('Dataset.parent_id', '父項目', array('url' => $url)); ?></th>
                <th><?php echo $this->Paginator->sort('Dataset.name', '名稱', array('url' => $url)); ?></th>
                <th><?php echo $this->Paginator->sort('Dataset.foreign_id', '原始編號', array('url' => $url)); ?></th>
                <th><?php echo $this->Paginator->sort('Dataset.foreign_uri', '原始網址', array('url' => $url)); ?></th>
                <th><?php echo $this->Paginator->sort('Dataset.modified', '更新時間', array('url' => $url)); ?></th>
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
                    <?php
                    if (!empty($op)) {
                        echo '<td>';
                        $options = array('value' => $item['Dataset']['id'], 'class' => 'habtmSet');
                        if ($item['option'] == 1) {
                            $options['checked'] = 'checked';
                        }
                        echo $this->Form->checkbox('Set.' . $item['Dataset']['id'], $options);
                        echo '<div id="messageSet' . $item['Dataset']['id'] . '"></div></td>';
                    }
                    ?>
                    <?php if (empty($scope['Dataset.organization_id'])): ?>
                        <td><?php
                            if (empty($item['Organization']['id'])) {
                                echo '--';
                            } else {
                                echo $this->Html->link($item['Organization']['id'], array(
                                    'controller' => 'organizations',
                                    'action' => 'view',
                                    $item['Organization']['id']
                                ));
                            }
                            ?></td>
                    <?php endif; ?>

                    <td><?php
                        echo $item['Dataset']['parent_id'];
                        ?></td>
                    <td><?php
                        echo $item['Dataset']['name'];
                        ?></td>
                    <td><?php
                        echo $item['Dataset']['foreign_id'];
                        ?></td>
                    <td><?php
                        echo $item['Dataset']['foreign_uri'];
                        ?></td>
                    <td><?php
                        echo $item['Dataset']['modified'];
                        ?></td>
                    <td>
                        <div class="btn-group">
                            <?php echo $this->Html->link('檢視', array('action' => 'view', $item['Dataset']['id']), array('class' => 'btn btn-default')); ?>
                            <?php echo $this->Html->link('編輯', array('action' => 'edit', $item['Dataset']['id']), array('class' => 'btn btn-default')); ?>
                            <?php echo $this->Html->link('刪除', array('action' => 'delete', $item['Dataset']['id']), array('class' => 'btn btn-default'), '確定要刪除？'); ?>
                        </div>
                    </td>
                </tr>
            <?php } // End of foreach ($items as $item) {  ?>
        </tbody>
    </table>
    <div class="paging"><?php echo $this->element('paginator'); ?></div>
    <div id="DatasetsAdminIndexPanel"></div>
    <script type="text/javascript">
        //<![CDATA[
        $(function () {
<?php
if (!empty($op)) {
    $remoteUrl = $this->Html->url(array('action' => 'habtmSet', $foreignModel, $foreignId));
    ?>
                $('#DatasetsAdminIndexTable input.habtmSet').click(function () {
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