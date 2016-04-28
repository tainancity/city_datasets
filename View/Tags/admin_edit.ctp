<div id="TagsAdminEdit">
    <?php echo $this->Form->create('Tag', array('type' => 'file')); ?>
    <div class="Tags form">
        <fieldset>
            <legend><?php
                echo __('Edit 標籤', true);
                ?></legend>
            <?php
            echo $this->Form->input('Tag.id');
            echo $this->Form->input('Tag.parent_id', array(
                'type' => 'text',
                'label' => '父項目',
                'div' => 'form-group',
                'class' => 'form-control',
            ));
            echo $this->Form->input('Tag.name', array(
                'label' => '名稱',
                'div' => 'form-group',
                'class' => 'form-control',
            ));
            echo $this->Form->input('Tag.model', array(
                'label' => 'Model',
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