<div id="TagsAdminIndex">
    <h2>標籤</h2>
    <div class="pull-right col-md-6">
        <div class="col-md-9"><?php
            echo $this->Form->input('Tag.keyword', array(
                'label' => false,
                'value' => $keyword,
                'div' => false,
                'class' => 'form-control',
            ));
            ?></div>
        <div class="col-md-3"><?php
            echo $this->Html->link('搜尋', $url, array('class' => 'btn btn-default', 'id' => 'btnTagKeyword'));
            ?></div>
    </div>
    <div class="btn-group">
        <?php echo $this->Html->link('列表', array('action' => 'index'), array('class' => 'btn btn-primary')); ?>
        <?php echo $this->Html->link('地方縣市', array('action' => 'organizations'), array('class' => 'btn btn-default')); ?>
        <?php echo $this->Html->link('資料集', array('action' => 'datasets'), array('class' => 'btn btn-default')); ?>
    </div>
    <div><?php
        echo $this->Paginator->counter(array(
            'format' => '第 {:page} 頁 / 共 {:pages} 頁，總數： {:count}  筆'
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
                        echo tag_to_str($item['Tag']['model']); //defined in Config/bootstrap.php
                        ?></td>
                    <td>
                        <div class="btn-group">
                            <?php
                            if ($item['Tag']['model'] === 'Organization') {
                                echo $this->Html->link('檢視', array('action' => 'view_organization', $item['Tag']['id']), array('class' => 'btn btn-default'));
                            } else {
                                echo $this->Html->link('檢視', array('action' => 'view_dataset', $item['Tag']['id']), array('class' => 'btn btn-default'));
                            }
                            ?>
                            <?php echo $this->Html->link('編輯', array('action' => 'edit', $item['Tag']['id']), array('class' => 'btn btn-default')); ?>
                            <?php echo $this->Html->link('刪除', array('action' => 'delete', $item['Tag']['id']), array('class' => 'btn btn-default'), '確定要刪除？'); ?>
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
            $('a#btnTagKeyword').click(function () {
                var keyword = $('input#TagKeyword').val();
                if (keyword !== '') {
                    location.href = '<?php echo $this->Html->url('/admin/tags/index'); ?>/keyword:' + $('input#TagKeyword').val();
                }
                return false;
            });
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