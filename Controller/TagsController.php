<?php

App::uses('AppController', 'Controller');

class TagsController extends AppController {

    public $name = 'Tags';
    public $paginate = array();
    public $helpers = array();

    function index($foreignModel = null, $foreignId = 0) {
        $foreignId = intval($foreignId);
        $foreignKeys = array();


        $habtmKeys = array(
            'Dataset' => 'Dataset_id',
            'Organization' => 'Organization_id',
        );
        $foreignKeys = array_merge($habtmKeys, $foreignKeys);

        $scope = array();
        if (array_key_exists($foreignModel, $foreignKeys) && $foreignId > 0) {
            $scope['Tag.' . $foreignKeys[$foreignModel]] = $foreignId;

            $joins = array(
                'Dataset' => array(
                    0 => array(
                        'table' => 'datasets_tags',
                        'alias' => 'DatasetsTag',
                        'type' => 'inner',
                        'conditions' => array('DatasetsTag.Tag_id = Tag.id'),
                    ),
                    1 => array(
                        'table' => 'datasets',
                        'alias' => 'Dataset',
                        'type' => 'inner',
                        'conditions' => array('DatasetsTag.Dataset_id = Dataset.id'),
                    ),
                ),
                'Organization' => array(
                    0 => array(
                        'table' => 'organizations_tags',
                        'alias' => 'OrganizationsTag',
                        'type' => 'inner',
                        'conditions' => array('OrganizationsTag.Tag_id = Tag.id'),
                    ),
                    1 => array(
                        'table' => 'organizations',
                        'alias' => 'Organization',
                        'type' => 'inner',
                        'conditions' => array('OrganizationsTag.Organization_id = Organization.id'),
                    ),
                ),
            );
            if (array_key_exists($foreignModel, $habtmKeys)) {
                unset($scope['Tag.' . $foreignKeys[$foreignModel]]);
                $scope[$joins[$foreignModel][0]['alias'] . '.' . $foreignKeys[$foreignModel]] = $foreignId;
                $this->paginate['Tag']['joins'] = $joins[$foreignModel];
            }
        } else {
            $foreignModel = '';
        }
        $this->set('scope', $scope);
        $this->paginate['Tag']['limit'] = 20;
        $items = $this->paginate($this->Tag, $scope);
        $this->set('items', $items);
        $this->set('foreignId', $foreignId);
        $this->set('foreignModel', $foreignModel);
    }

    function view($id = null) {
        if (!$id || !$this->data = $this->Tag->read(null, $id)) {
            $this->Session->setFlash(__('Please do following links in the page', true));
            $this->redirect(array('action' => 'index'));
        }
    }

    function admin_index($foreignModel = null, $foreignId = 0, $op = null) {
        $foreignId = intval($foreignId);
        $foreignKeys = array();


        $habtmKeys = array(
            'Dataset' => 'Dataset_id',
            'Organization' => 'Organization_id',
        );
        $foreignKeys = array_merge($habtmKeys, $foreignKeys);

        $scope = array();
        if (array_key_exists($foreignModel, $foreignKeys) && $foreignId > 0) {
            $scope['Tag.' . $foreignKeys[$foreignModel]] = $foreignId;

            $joins = array(
                'Dataset' => array(
                    0 => array(
                        'table' => 'datasets_tags',
                        'alias' => 'DatasetsTag',
                        'type' => 'inner',
                        'conditions' => array('DatasetsTag.Tag_id = Tag.id'),
                    ),
                    1 => array(
                        'table' => 'datasets',
                        'alias' => 'Dataset',
                        'type' => 'inner',
                        'conditions' => array('DatasetsTag.Dataset_id = Dataset.id'),
                    ),
                ),
                'Organization' => array(
                    0 => array(
                        'table' => 'organizations_tags',
                        'alias' => 'OrganizationsTag',
                        'type' => 'inner',
                        'conditions' => array('OrganizationsTag.Tag_id = Tag.id'),
                    ),
                    1 => array(
                        'table' => 'organizations',
                        'alias' => 'Organization',
                        'type' => 'inner',
                        'conditions' => array('OrganizationsTag.Organization_id = Organization.id'),
                    ),
                ),
            );
            if (array_key_exists($foreignModel, $habtmKeys)) {
                unset($scope['Tag.' . $foreignKeys[$foreignModel]]);
                if ($op != 'set') {
                    $scope[$joins[$foreignModel][0]['alias'] . '.' . $foreignKeys[$foreignModel]] = $foreignId;
                    $this->paginate['Tag']['joins'] = $joins[$foreignModel];
                }
            }
        } else {
            $foreignModel = '';
        }
        $this->set('scope', $scope);
        $this->paginate['Tag']['limit'] = 20;
        $items = $this->paginate($this->Tag, $scope);

        if ($op == 'set' && !empty($joins[$foreignModel]) && !empty($foreignModel) && !empty($foreignId) && !empty($items)) {
            foreach ($items AS $key => $item) {
                $items[$key]['option'] = $this->Tag->find('count', array(
                    'joins' => $joins[$foreignModel],
                    'conditions' => array(
                        'Tag.id' => $item['Tag']['id'],
                        $foreignModel . '.id' => $foreignId,
                    ),
                ));
                if ($items[$key]['option'] > 0) {
                    $items[$key]['option'] = 1;
                }
            }
            $this->set('op', $op);
        }

        $this->set('items', $items);
        $this->set('foreignId', $foreignId);
        $this->set('foreignModel', $foreignModel);
    }

    function admin_view($id = null) {
        if (!$id || !$this->data = $this->Tag->read(null, $id)) {
            $this->Session->setFlash(__('Please do following links in the page', true));
            $this->redirect(array('action' => 'index'));
        }
    }

    function admin_add() {
        if (!empty($this->data)) {
            $this->Tag->create();
            if ($this->Tag->save($this->data)) {
                $this->Session->setFlash(__('The data has been saved', true));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('Something was wrong during saving, please try again', true));
            }
        }
    }

    function admin_edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Please do following links in the page', true));
            $this->redirect($this->referer());
        }
        if (!empty($this->data)) {
            if ($this->Tag->save($this->data)) {
                $this->Session->setFlash(__('The data has been saved', true));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('Something was wrong during saving, please try again', true));
            }
        }
        $this->set('id', $id);
        $this->data = $this->Tag->read(null, $id);
    }

    function admin_delete($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Please do following links in the page', true));
        } else if ($this->Tag->delete($id)) {
            $this->Session->setFlash(__('The data has been deleted', true));
        }
        $this->redirect(array('action' => 'index'));
    }

    function admin_habtmSet($foreignModel = null, $foreignId = 0, $id = 0, $switch = null) {
        $habtmKeys = array(
            'Dataset' => array(
                'associationForeignKey' => 'Dataset_id',
                'foreignKey' => 'Tag_id',
                'alias' => 'DatasetsTag',
            ),
            'Organization' => array(
                'associationForeignKey' => 'Organization_id',
                'foreignKey' => 'Tag_id',
                'alias' => 'OrganizationsTag',
            ),
        );
        $foreignModel = array_key_exists($foreignModel, $habtmKeys) ? $foreignModel : null;
        $foreignId = intval($foreignId);
        $id = intval($id);
        $switch = in_array($switch, array('on', 'off')) ? $switch : null;
        if (empty($foreignModel) || $foreignId <= 0 || $id <= 0 || empty($switch)) {
            $this->set('habtmMessage', __('Wrong Parameters'));
        } else {
            $habtmModel = &$this->Tag->$habtmKeys[$foreignModel]['alias'];
            $conditions = array(
                $habtmKeys[$foreignModel]['associationForeignKey'] => $foreignId,
                $habtmKeys[$foreignModel]['foreignKey'] => $id,
            );
            $status = ($habtmModel->find('count', array(
                        'conditions' => $conditions,
                    ))) ? 'on' : 'off';
            if ($status == $switch) {
                $this->set('habtmMessage', __('Duplicated operactions', true));
            } else if ($switch == 'on') {
                $habtmModel->create();
                if ($habtmModel->save(array($habtmKeys[$foreignModel]['alias'] => $conditions))) {
                    $this->set('habtmMessage', __('Updated', true));
                } else {
                    $this->set('habtmMessage', __('Update failed', true));
                }
            } else {
                if ($habtmModel->deleteAll($conditions)) {
                    $this->set('habtmMessage', __('Updated', true));
                } else {
                    $this->set('habtmMessage', __('Update failed', true));
                }
            }
        }
    }

}
