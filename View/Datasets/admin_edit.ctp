<div id="DatasetsAdminEdit">
    <h3>編輯資料集</h3>
    <?php echo $this->Form->create('Dataset', array('type' => 'file')); ?>
    <div class="Datasets form">
        <?php
        echo $this->Form->input('Dataset.parent_id', array(
            'type' => 'text',
            'label' => '父項目',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('Dataset.name', array(
            'label' => '名稱',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('Dataset.foreign_id', array(
            'type' => 'text',
            'label' => '原始編號',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('Dataset.foreign_uri', array(
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