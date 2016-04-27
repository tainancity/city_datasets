<?php

App::uses('AppModel', 'Model');

class Organization extends AppModel {

    var $name = 'Organization';
    var $actsAs = array(
    );
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

    function afterSave($created, $options = array()) {
        
    }

}
