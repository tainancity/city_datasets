<div id="TagsAdminAdd">
    <?php echo $this->Form->create('Tag', array('type' => 'file')); ?>
    <div class="Tags form">
        <fieldset>
            <legend><?php
                echo __('Add 標籤', true);
                ?></legend>
            <?php
            echo $this->Form->input('Tag.name', array(
                'label' => '名稱',
                'div' => 'form-group',
                'class' => 'form-control',
            ));
            echo $this->Form->input('Tag.model', array(
                'type' => 'select',
                'options' => array(
                    'Organization' => 'Organization',
                    'Dataset' => 'Dataset',
                ),
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