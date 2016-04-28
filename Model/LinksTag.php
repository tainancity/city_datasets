<?php

App::uses('AppModel', 'Model');

class LinksTag extends AppModel {

    var $name = 'LinksTag';
    var $belongsTo = array(
        'Dataset' => array(
            'foreignKey' => 'foreign_id',
            'conditions' => array('LinksTag.model' => 'Dataset'),
            'className' => 'Dataset',
        ),
        'Organization' => array(
            'foreignKey' => 'foreign_id',
            'conditions' => array('LinksTag.model' => 'Organization'),
            'className' => 'Organization',
        ),
    );

    public function beforeSave($options = array()) {
        if (false === $this->id && empty($this->data[$this->name]['id'])) {
            $this->id = $this->data[$this->name]['id'] = hex2bin($this->getUUID());
        }
        $binaryKeys = array('tag_id', 'foreign_id');
        foreach ($binaryKeys AS $binaryKey) {
            if (isset($this->data[$this->name][$binaryKey])) {
                $this->data[$this->name][$binaryKey] = hex2bin($this->data[$this->name][$binaryKey]);
            }
        }
        return parent::beforeSave($options);
    }

    public function afterFind($results, $primary = false) {
        $binaryKeys = array('id', 'tag_id', 'foreign_id');
        foreach ($results AS $k => $v) {
            foreach ($binaryKeys AS $binaryKey) {
                if (isset($results[$k][$this->name][$binaryKey])) {
                    $results[$k][$this->name][$binaryKey] = bin2hex($results[$k][$this->name][$binaryKey]);
                }
            }
        }
        return parent::afterFind($results, $primary);
    }

}
