<div id="DatasetsAdminAdd">
    <h3>新增資料集</h3>
    <div class="btn-group">
        <?php echo $this->Html->link('新增', array('action' => 'add'), array('class' => 'btn btn-primary')); ?>
        <?php echo $this->Html->link('列表', array('action' => 'index'), array('class' => 'btn btn-default')); ?>
        <?php echo $this->Html->link('待標籤', array('action' => 'tags'), array('class' => 'btn btn-default')); ?>
    </div>
    <?php
    $url = array();
    if (!empty($foreignId) && !empty($foreignModel)) {
        $url = array('action' => 'add', $foreignModel, $foreignId);
    } else {
        $url = array('action' => 'add');
        $foreignModel = '';
    }
    echo $this->Form->create('Dataset', array('type' => 'file', 'url' => $url));
    ?>
    <div class="Datasets form">
        <div class="page_content">
        <?php
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

    <?php
    $options = array('label' => '儲存', 'class' => 'btn btn-primary');
    echo $this->Form->end($options);
    ?>
        </div>
    </div>
</div>