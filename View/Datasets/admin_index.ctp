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
        <?php echo $this->Html->link(__('Add', true), array_merge($url, array('action' => 'add')), array('class' => 'btn btn-default dialogControl')); ?>
    </div>
    <div><?php
        echo $this->Paginator->counter(array(
            'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
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
                <?php if (empty($scope['Dataset.Organization_id'])): ?>
                    <th><?php echo $this->Paginator->sort('Dataset.Organization_id', '組織', array('url' => $url)); ?></th>
                <?php endif; ?>

                <th><?php echo $this->Paginator->sort('Dataset.parent_id', '父項目', array('url' => $url)); ?></th>
                <th><?php echo $this->Paginator->sort('Dataset.name', '名稱', array('url' => $url)); ?></th>
                <th><?php echo $this->Paginator->sort('Dataset.foreign_id', '原始編號', array('url' => $url)); ?></th>
                <th><?php echo $this->Paginator->sort('Dataset.foreign_uri', '原始網址', array('url' => $url)); ?></th>
                <th><?php echo $this->Paginator->sort('Dataset.lft', '左', array('url' => $url)); ?></th>
                <th><?php echo $this->Paginator->sort('Dataset.rght', '右', array('url' => $url)); ?></th>
                <th><?php echo $this->Paginator->sort('Dataset.created', '建立時間', array('url' => $url)); ?></th>
                <th><?php echo $this->Paginator->sort('Dataset.modified', '更新時間', array('url' => $url)); ?></th>
                <th class="actions"><?php echo __('Action', true); ?></th>
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
                    <?php if (empty($scope['Dataset.Organization_id'])): ?>
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
                        echo $item['Dataset']['lft'];
                        ?></td>
                    <td><?php
                        echo $item['Dataset']['rght'];
                        ?></td>
                    <td><?php
                        echo $item['Dataset']['created'];
                        ?></td>
                    <td><?php
                        echo $item['Dataset']['modified'];
                        ?></td>
                    <td>
                        <div class="btn-group">
                            <?php echo $this->Html->link(__('View', true), array('action' => 'view', $item['Dataset']['id']), array('class' => 'btn btn-default dialogControl')); ?>
                            <?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $item['Dataset']['id']), array('class' => 'btn btn-default dialogControl')); ?>
                            <?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $item['Dataset']['id']), array('class' => 'btn btn-default'), __('Delete the item, sure?', true)); ?>
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