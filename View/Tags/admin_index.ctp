<?php
if (!isset($url)) {
    $url = array();
}
?>
<div id="TagsAdminIndex">
    <h2><?php echo __('標籤', true); ?></h2>
    <div class="btn-group">
        <?php echo $this->Html->link(__('Add', true), array('action' => 'add'), array('class' => 'btn btn-default dialogControl')); ?>
    </div>
    <div><?php
        echo $this->Paginator->counter(array(
            'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
        ));
        ?></div>
    <div class="paging"><?php echo $this->element('paginator'); ?></div>
    <table class="table table-bordered" id="TagsAdminIndexTable">
        <thead>
            <tr>
                <?php
                if (!empty($op)) {
                    echo '<th>&nbsp;</th>';
                }
                ?>

                <th><?php echo $this->Paginator->sort('Tag.parent_id', '父項目', array('url' => $url)); ?></th>
                <th><?php echo $this->Paginator->sort('Tag.name', '名稱', array('url' => $url)); ?></th>
                <th><?php echo $this->Paginator->sort('Tag.model', 'Model', array('url' => $url)); ?></th>
                <th><?php echo $this->Paginator->sort('Tag.lft', '左', array('url' => $url)); ?></th>
                <th><?php echo $this->Paginator->sort('Tag.rght', '右', array('url' => $url)); ?></th>
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
                        $options = array('value' => $item['Tag']['id'], 'class' => 'habtmSet');
                        if ($item['option'] == 1) {
                            $options['checked'] = 'checked';
                        }
                        echo $this->Form->checkbox('Set.' . $item['Tag']['id'], $options);
                        echo '<div id="messageSet' . $item['Tag']['id'] . '"></div></td>';
                    }
                    ?>

                    <td><?php
                        echo $item['Tag']['parent_id'];
                        ?></td>
                    <td><?php
                        echo $item['Tag']['name'];
                        ?></td>
                    <td><?php
                        echo $item['Tag']['model'];
                        ?></td>
                    <td><?php
                        echo $item['Tag']['lft'];
                        ?></td>
                    <td><?php
                        echo $item['Tag']['rght'];
                        ?></td>
                    <td>
                        <div class="btn-group">
                            <?php echo $this->Html->link(__('View', true), array('action' => 'view', $item['Tag']['id']), array('class' => 'btn btn-default dialogControl')); ?>
                            <?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $item['Tag']['id']), array('class' => 'btn btn-default dialogControl')); ?>
                            <?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $item['Tag']['id']), array('class' => 'btn btn-default'), __('Delete the item, sure?', true)); ?>
                        </div>
                    </td>
                </tr>
            <?php } // End of foreach ($items as $item) {  ?>
        </tbody>
    </table>
    <div class="paging"><?php echo $this->element('paginator'); ?></div>
    <div id="TagsAdminIndexPanel"></div>
    <script type="text/javascript">
        //<![CDATA[
        $(function () {
<?php
if (!empty($op)) {
    $remoteUrl = $this->Html->url(array('action' => 'habtmSet', $foreignModel, $foreignId));
    ?>
                $('#TagsAdminIndexTable input.habtmSet').click(function () {
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