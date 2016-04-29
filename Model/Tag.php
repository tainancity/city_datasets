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

}
