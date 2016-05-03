<div id="OrganizationsAdminEdit">
    <h3>編輯地方地方組織</h3>
    <?php echo $this->Form->create('Organization', array('type' => 'file')); ?>
    <div class="Organizations form">
        <?php
        echo $this->Form->input('Organization.parent_id', array(
            'type' => 'text',
            'label' => '父項目',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
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
    </div>
    <?php
    echo $this->Form->end('儲存');
    ?>
</div>