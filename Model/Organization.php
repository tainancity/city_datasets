<?php

App::uses('AppModel', 'Model');

class Organization extends AppModel {

    var $name = 'Organization';
    var $actsAs = array('Tree');
    var $hasAndBelongsToMany = array(
        'Tag' => array(
            'joinTable' => 'links_tags',
            'foreignKey' => 'foreign_id',
            'associationForeignKey' => 'tag_id',
            'conditions' => array(
                'LinksTag.model' => 'Organization',
            ),
            'className' => 'Tag',
        ),
    );
    var $hasMany = array(
        'Dataset' => array(
            'foreignKey' => 'Organization_id',
            'dependent' => false,
            'className' => 'Dataset',
        ),
    );

    public function beforeSave($options = array()) {
        if (false === $this->id && empty($this->data[$this->name]['id'])) {
            $this->id = $this->data[$this->name]['id'] = hex2bin($this->getUUID());
        }
        return parent::beforeSave($options);
    }

    public function afterFind($results, $primary = false) {
        foreach ($results AS $k => $v) {
            $results[$k][$this->name]['id'] = bin2hex($results[$k][$this->name]['id']);
            if (!empty($results[$k][$this->name]['parent_id'])) {
                $results[$k][$this->name]['parent_id'] = bin2hex($results[$k][$this->name]['parent_id']);
            }
        }
        return parent::afterFind($results, $primary);
    }

}
