<br>
<div class="groups form">
    <div class="page_content">
    <?php echo $this->Form->create('Group', array('url' => array($parentId))); ?>
        <fieldset>
            <legend><?php echo __('新增群組', true); ?></legend>
        <?php
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
        <li><?php echo $this->Html->link(__('List', true), array('action' => 'index')); ?></li>
    </ul>
</div>
