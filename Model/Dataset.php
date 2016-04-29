<?php

App::uses('AppModel', 'Model');

class Dataset extends AppModel {

    var $name = 'Dataset';
    var $actsAs = array('Tree');
    var $hasAndBelongsToMany = array(
        'Tag' => array(
            'joinTable' => 'links_tags',
            'foreignKey' => 'foreign_id',
            'associationForeignKey' => 'tag_id',
            'conditions' => array(
                'LinksTag.model' => 'Dataset',
            ),
            'className' => 'Tag',
        ),
    );
    var $belongsTo = array(
        'Organization' => array(
            'foreignKey' => 'organization_id',
            'className' => 'Organization',
        ),
    );

    public function beforeSave($options = array()) {
        if (false === $this->id && empty($this->data[$this->name]['id'])) {
            $this->id = $this->data[$this->name]['id'] = hex2bin($this->getUUID());
        }
        if (isset($this->data[$this->name]['organization_id'])) {
            $this->data[$this->name]['organization_id'] = hex2bin($this->data[$this->name]['organization_id']);
        }
        return parent::beforeSave($options);
    }

    public function afterFind($results, $primary = false) {
        foreach ($results AS $k => $v) {
            if (isset($results[$k][$this->name]['id'])) {
                $results[$k][$this->name]['id'] = bin2hex($results[$k][$this->name]['id']);
            }
            if (!empty($results[$k][$this->name]['parent_id'])) {
                $results[$k][$this->name]['parent_id'] = bin2hex($results[$k][$this->name]['parent_id']);
            }
        }
        return parent::afterFind($results, $primary);
    }

}
