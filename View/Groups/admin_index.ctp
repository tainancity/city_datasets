<div id="GroupsAdminIndex">
    <h2><?php echo __('Groups', true); ?></h2>
    <div class="btn-group">
        <?php if ($parentId > 0): ?>
            <?php echo $this->Html->link(__('Upper level', true), array('action' => 'index', $upperLevelId), array('class' => 'btn')); ?>
        <?php endif; ?>
        <?php echo $this->Html->link(__('新增群組', true), array('action' => 'add', $parentId), array('class' => 'btn btn-default')); ?>
        <?php echo $this->Html->link(__('帳號資料', true), array('controller' => 'members'), array('class' => 'btn btn-default')); ?>
        <?php echo $this->Html->link(__('群組權限', true), array('controller' => 'group_permissions'), array('class' => 'btn btn-default')); ?>
    </div>
    <p>
        <?php
        echo $this->Paginator->counter(array(
            'format' => '第 {:page} 頁 / 共 {:pages} 頁，總數： {:count}  筆'
        ));
        ?>
    </p>
    <div class="paging"><?php echo $this->element('paginator'); ?></div>
    <table class="table table-bordered" id="GroupsAdminIndexTable">
        <tr>
            <th><?php echo $this->Paginator->sort(__('Id', true), '序號'); ?></th>
            <th><?php echo $this->Paginator->sort(__('Name', true), '帳號名稱'); ?></th>
            <th class="actions"><?php __('Actions'); ?></th>
        </tr>
        <?php
        $i = 0;
        foreach ($groups as $group):
            $class = null;
            if ($i++ % 2 == 0) {
                $class = ' class="altrow"';
            }
            ?>
            <tr<?php echo $class; ?>>
                <td>
                    <?php echo $group['Group']['id']; ?>
                </td>
                <td>
                    <?php echo $group['Group']['name']; ?>
                </td>
                <td>
                    <div class="btn-group">
                        <?php echo $this->Html->link('編輯', array('action' => 'edit', $group['Group']['id']), array('class' => 'btn btn-default')); ?>
                        <?php echo $this->Html->link('刪除', array('action' => 'delete', $group['Group']['id']), array('class' => 'btn btn-default'), '確定要刪除？'); ?>
                        <?php echo $this->Html->link(__('子群組', true), array('action' => 'index', $group['Group']['id']), array('class' => 'btn btn-default')); ?>
                        <?php
                        if ($group['Group']['id'] != 1) {
                            echo $this->Html->link(__('Permission', true), array('controller' => 'group_permissions', 'action' => 'group', $group['Group']['id']), array('class' => 'btn btn-default'));
                        }
                        ?>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <div class="paging"><?php echo $this->element('paginator'); ?></div>
    <div id="GroupsAdminIndexPanel"></div>
</div>