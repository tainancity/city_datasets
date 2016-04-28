<div id="DatasetsAdminAdd">
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
        <fieldset>
            <legend><?php
                echo __('Add 資料集', true);
                ?></legend>
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
        </fieldset>
    </div>
    <?php
    echo $this->Form->end(__('Submit', true));
    ?>
</div>