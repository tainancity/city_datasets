<div id="OrganizationsAdminAdd">
    <h3>新增地方縣市</h3>
    <div class="btn-group">
        <?php echo $this->Html->link('新增', array('action' => 'add', $parentId), array('class' => 'btn btn-primary')); ?>
        <?php echo $this->Html->link('列表', array('action' => 'index'), array('class' => 'btn btn-default')); ?>
        <?php echo $this->Html->link('待標籤', array('action' => 'tags'), array('class' => 'btn btn-default')); ?>
    </div>
    <?php echo $this->Form->create('Organization', array('type' => 'file')); ?>
    <div class="Organizations form">
        <div class="page_content">
        <?php
        echo $this->Form->input('Organization.name', array(
            'label' => '名稱',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('Organization.foreign_id', array(
            'type' => 'text',
            'label' => '原始編號',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('Organization.foreign_uri', array(
            'label' => '原始網址',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        ?>
            
    
    <?php
    $options = array('label' => '儲存', 'class' => 'btn btn-primary');
    echo $this->Form->end($options);
    ?>
        </div>
        </div>
</div>