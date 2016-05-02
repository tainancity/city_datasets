<div id="TagsAdminView">
    <h3><?php echo implode(' > ', array(
        $this->Html->link('標籤', '/admin/tags/index'),
        $this->data['Tag']['name'] . ' / ' . $this->data['Tag']['model'],
    )); ?></h3><hr />
    <table class="table table-bordered" id="TagsAdminIndexTable">
        <thead>
            <tr>
                <th>名稱</th>
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
                        echo $item['Organization']['name'];
                        ?></td>
                    <td>
                        <div class="btn-group">
                            <?php echo $this->Html->link('檢視', array('controller' => 'organizations', 'action' => 'view', $item['Organization']['id']), array('class' => 'btn btn-default')); ?>
                        </div>
                    </td>
                </tr>
            <?php } // End of foreach ($items as $item) {  ?>
        </tbody>
    </table>
</div>