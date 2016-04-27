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
            foreach ($belongsToModels AS $key => $model) {
                echo $this->Form->input('Dataset.' . $model['foreignKey'], array(
                    'type' => 'select',
                    'label' => $model['label'],
                    'options' => $$key,
                    'div' => 'form-group',
                    'class' => 'form-control',
                ));
            }
            echo $this->Form->input('Dataset.parent_id', array(
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
                'label' => '原始編號',
                'div' => 'form-group',
                'class' => 'form-control',
            ));
            echo $this->Form->input('Dataset.foreign_uri', array(
                'label' => '原始網址',
                'div' => 'form-group',
                'class' => 'form-control',
            ));
            echo $this->Form->input('Dataset.lft', array(
                'label' => '左',
                'div' => 'form-group',
                'class' => 'form-control',
            ));
            echo $this->Form->input('Dataset.rght', array(
                'label' => '右',
                'div' => 'form-group',
                'class' => 'form-control',
            ));
            echo $this->Form->input('Dataset.created', array(
                'label' => '建立時間',
                'div' => 'form-group',
                'class' => 'form-control',
            ));
            echo $this->Form->input('Dataset.modified', array(
                'label' => '更新時間',
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