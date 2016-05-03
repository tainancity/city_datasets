<div id="OrganizationsAdminIndex">
    <?php
    $links = array(
        $this->Html->link('地方縣市', '/admin/organizations/index'),
    );
    if (!empty($path)) {
        foreach ($path AS $item) {
            $links[] = $this->Html->link($item['Organization']['name'], array('action' => 'index', $item['Organization']['id']));
        }
    }
    ?>
    <h2><?php echo implode(' > ', $links); ?></h2>
    <div class="btn-group">
        <?php echo $this->Html->link('新增', array('action' => 'add', $parentId), array('class' => 'btn btn-default')); ?>
        <?php echo $this->Html->link('列表', array('action' => 'index'), array('class' => 'btn btn-primary')); ?>
        <?php echo $this->Html->link('待標籤', array('action' => 'tags'), array('class' => 'btn btn-default')); ?>
    </div>
    <div><?php
        echo $this->Paginator->counter(array(
            'format' => '第 {:page} 頁 / 共 {:pages} 頁，總數： {:count}  筆'
        ));
        ?></div>
    <div class="paging"><?php echo $this->element('paginator'); ?></div>
    <table class="table table-bordered" id="OrganizationsAdminIndexTable">
        <thead>
            <tr>
                <th><?php echo $this->Paginator->sort('Organization.name', '名稱', array('url' => $url)); ?></th>
                <th><?php echo $this->Paginator->sort('Organization.foreign_id', '原始編號', array('url' => $url)); ?></th>
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
                        echo $this->Html->link($item['Organization']['name'], array('action' => 'index', $item['Organization']['id']));
                        ?></td>
                <td><?php
                        if (!empty($item['Organization']['foreign_uri'])) {
                            echo $this->Html->link($item['Organization']['foreign_id'], $item['Organization']['foreign_uri'], array('target' => '_blank'));
                        } else {
                            echo $item['Organization']['foreign_id'];
                        }
                        ?></td>
                <td>
                    <div class="btn-group">
                            <?php echo $this->Html->link('檢視', array('action' => 'view', $item['Organization']['id']), array('class' => 'btn btn-default')); ?>
                            <?php echo $this->Html->link('編輯', array('action' => 'edit', $item['Organization']['id']), array('class' => 'btn btn-default')); ?>
                            <?php echo $this->Html->link('刪除', array('action' => 'delete', $item['Organization']['id']), array('class' => 'btn btn-default'), '確定要刪除？'); ?>
                    </div>
                </td>
            </tr>
            <?php } // End of foreach ($items as $item) {    ?>
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