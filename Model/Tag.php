<?php

App::uses('AppModel', 'Model');

class Tag extends AppModel {

    var $name = 'Tag';
    var $actsAs = array('Tree');
    var $hasAndBelongsToMany = array(
        'Dataset' => array(
            'joinTable' => 'links_tags',
            'foreignKey' => 'tag_id',
            'associationForeignKey' => 'foreign_id',
            'conditions' => array(
                'LinksTag.model' => 'Dataset',
            ),
            'className' => 'Dataset',
        ),
        'Organization' => array(
            'joinTable' => 'links_tags',
            'foreignKey' => 'tag_id',
            'associationForeignKey' => 'foreign_id',
            'conditions' => array(
                'LinksTag.model' => 'Organization',
            ),
            'className' => 'Organization',
        ),
    );
    var $hasMany = array(
        'LinksTag' => array(
            'foreignKey' => 'tag_id',
            'dependent' => true,
            'className' => 'LinksTag',
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
