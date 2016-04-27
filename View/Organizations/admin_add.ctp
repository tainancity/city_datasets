<div id="OrganizationsAdminAdd">
    <?php echo $this->Form->create('Organization', array('type' => 'file')); ?>
    <div class="Organizations form">
        <fieldset>
            <legend><?php
                echo __('Add 組織', true);
                ?></legend>
            <?php
            echo $this->Form->input('Organization.parent_id', array(
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
                'label' => '原始編號',
                'div' => 'form-group',
                'class' => 'form-control',
            ));
            echo $this->Form->input('Organization.foreign_uri', array(
                'label' => '原始網址',
                'div' => 'form-group',
                'class' => 'form-control',
            ));
            echo $this->Form->input('Organization.lft', array(
                'label' => '左',
                'div' => 'form-group',
                'class' => 'form-control',
            ));
            echo $this->Form->input('Organization.rght', array(
                'label' => '右',
                'div' => 'form-group',
                'class' => 'form-control',
            ));
            ?>
        </fieldset>
    </div>
    <?php
    echo $this->Form->end(__('Submit', true));
    ?>
</div>