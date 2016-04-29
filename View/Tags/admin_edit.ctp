<div id="TagsAdminEdit">
    <h3>編輯標籤</h3>
    <?php echo $this->Form->create('Tag', array('type' => 'file')); ?>
    <div class="Tags form">
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
    </div>
    <?php
    echo $this->Form->end('儲存');
    ?>
</div>