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

}
