<?php
if (!isset($url)) {
    $url = array();
}
?>
<div id="OrganizationsAdminIndex">
    <h2><?php echo __('組織', true); ?></h2>
    <div class="btn-group">
        <?php echo $this->Html->link('新增', array('action' => 'add'), array('class' => 'btn btn-default')); ?>
    </div>
    <div><?php
        echo $this->Paginator->counter(array(
            'format' => __('第 {:page} 頁 / 共 {:pages} 頁，總數： {:count}  筆')
        ));
        ?></div>
    <div class="paging"><?php echo $this->element('paginator'); ?></div>
    <table class="table table-bordered" id="OrganizationsAdminIndexTable">
        <thead>
            <tr>
                <?php
                if (!empty($op)) {
                    echo '<th>&nbsp;</th>';
                }
                ?>
                <th><?php echo $this->Paginator->sort('Organization.parent_id', '父項目', array('url' => $url)); ?></th>
                <th><?php echo $this->Paginator->sort('Organization.name', '名稱', array('url' => $url)); ?></th>
                <th><?php echo $this->Paginator->sort('Organization.foreign_id', '原始編號', array('url' => $url)); ?></th>
                <th><?php echo $this->Paginator->sort('Organization.foreign_uri', '原始網址', array('url' => $url)); ?></th>
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
                        $options = array('value' => $item['Organization']['id'], 'class' => 'habtmSet');
                        if ($item['option'] == 1) {
                            $options['checked'] = 'checked';
                        }
                        echo $this->Form->checkbox('Set.' . $item['Organization']['id'], $options);
                        echo '<div id="messageSet' . $item['Organization']['id'] . '"></div></td>';
                    }
                    ?>

                    <td><?php
                        echo $item['Organization']['parent_id'];
                        ?></td>
                    <td><?php
                        echo $item['Organization']['name'];
                        ?></td>
                    <td><?php
                        echo $item['Organization']['foreign_id'];
                        ?></td>
                    <td><?php
                        echo $item['Organization']['foreign_uri'];
                        ?></td>
                    <td>
                        <div class="btn-group">
                            <?php echo $this->Html->link('檢視', array('action' => 'view', $item['Organization']['id']), array('class' => 'btn btn-default')); ?>
                            <?php echo $this->Html->link('編輯', array('action' => 'edit', $item['Organization']['id']), array('class' => 'btn btn-default')); ?>
                            <?php echo $this->Html->link('刪除', array('action' => 'delete', $item['Organization']['id']), array('class' => 'btn btn-default'), '確定要刪除？'); ?>
                        </div>
                    </td>
                </tr>
            <?php } // End of foreach ($items as $item) {  ?>
        </tbody>
    </table>
    <div class="paging"><?php echo $this->element('paginator'); ?></div>
    <div id="OrganizationsAdminIndexPanel"></div>
    <script type="text/javascript">
        //<![CDATA[
        $(function () {
<?php
if (!empty($op)) {
    $remoteUrl = $this->Html->url(array('action' => 'habtmSet', $foreignModel, $foreignId));
    ?>
                $('#OrganizationsAdminIndexTable input.habtmSet').click(function () {
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