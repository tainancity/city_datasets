<div class="groups form">
    <div class="page_content">
    <?php echo $this->Form->create('Group'); ?>
    <fieldset>
        <legend><?php echo __('編輯群組', true); ?></legend>
        <?php
        echo $this->Form->input('id');
        echo $this->Form->input('name', array('label' => __('群組名稱', true)));
        ?>
    </fieldset>
    <?php 
    $options = array('label' => '儲存', 'class' => 'btn btn-primary');
    echo $this->Form->end($options);
    ?>
    </div>
</div>
<div class="actions">
    <ul>
        <li><?php echo $this->Html->link('刪除', array('action' => 'delete', $this->Form->value('Group.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Group.id'))); ?></li>
        <li><?php echo $this->Html->link(__('List', true), array('action' => 'index', $this->Form->value('Group.parent_id'))); ?></li>
    </ul>
</div>
