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

}
