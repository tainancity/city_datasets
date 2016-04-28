<?php

App::uses('AppController', 'Controller');

class OrganizationsController extends AppController {

    public $name = 'Organizations';
    public $paginate = array();
    public $helpers = array();

    function index($foreignModel = null, $foreignId = 0) {
        $foreignId = intval($foreignId);
        $foreignKeys = array();


        $habtmKeys = array(
            'Tag' => 'Tag_id',
        );
        $foreignKeys = array_merge($habtmKeys, $foreignKeys);

        $scope = array();
        if (array_key_exists($foreignModel, $foreignKeys) && $foreignId > 0) {
            $scope['Organization.' . $foreignKeys[$foreignModel]] = $foreignId;

            $joins = array(
                'Tag' => array(
                    0 => array(
                        'table' => 'organizations_tags',
                        'alias' => 'OrganizationsTag',
                        'type' => 'inner',
                        'conditions' => array('OrganizationsTag.Organization_id = Organization.id'),
                    ),
                    1 => array(
                        'table' => 'tags',
                        'alias' => 'Tag',
                        'type' => 'inner',
                        'conditions' => array('OrganizationsTag.Tag_id = Tag.id'),
                    ),
                ),
            );
            if (array_key_exists($foreignModel, $habtmKeys)) {
                unset($scope['Organization.' . $foreignKeys[$foreignModel]]);
                $scope[$joins[$foreignModel][0]['alias'] . '.' . $foreignKeys[$foreignModel]] = $foreignId;
                $this->paginate['Organization']['joins'] = $joins[$foreignModel];
            }
        } else {
            $foreignModel = '';
        }
        $this->set('scope', $scope);
        $this->paginate['Organization']['limit'] = 20;
        $items = $this->paginate($this->Organization, $scope);
        $this->set('items', $items);
        $this->set('foreignId', $foreignId);
        $this->set('foreignModel', $foreignModel);
    }

    function view($id = null) {
        if (!$id || !$this->data = $this->Organization->read(null, $id)) {
            $this->Session->setFlash(__('Please do following links in the page', true));
            $this->redirect(array('action' => 'index'));
        }
    }

    function admin_index($foreignModel = null, $foreignId = 0, $op = null) {
        $foreignId = intval($foreignId);
        $foreignKeys = array();


        $habtmKeys = array(
            'Tag' => 'Tag_id',
        );
        $foreignKeys = array_merge($habtmKeys, $foreignKeys);

        $scope = array();
        if (array_key_exists($foreignModel, $foreignKeys) && $foreignId > 0) {
            $scope['Organization.' . $foreignKeys[$foreignModel]] = $foreignId;

            $joins = array(
                'Tag' => array(
                    0 => array(
                        'table' => 'organizations_tags',
                        'alias' => 'OrganizationsTag',
                        'type' => 'inner',
                        'conditions' => array('OrganizationsTag.Organization_id = Organization.id'),
                    ),
                    1 => array(
                        'table' => 'tags',
                        'alias' => 'Tag',
                        'type' => 'inner',
                        'conditions' => array('OrganizationsTag.Tag_id = Tag.id'),
                    ),
                ),
            );
            if (array_key_exists($foreignModel, $habtmKeys)) {
                unset($scope['Organization.' . $foreignKeys[$foreignModel]]);
                if ($op != 'set') {
                    $scope[$joins[$foreignModel][0]['alias'] . '.' . $foreignKeys[$foreignModel]] = $foreignId;
                    $this->paginate['Organization']['joins'] = $joins[$foreignModel];
                }
            }
        } else {
            $foreignModel = '';
        }
        $this->set('scope', $scope);
        $this->paginate['Organization']['limit'] = 20;
        $items = $this->paginate($this->Organization, $scope);

        if ($op == 'set' && !empty($joins[$foreignModel]) && !empty($foreignModel) && !empty($foreignId) && !empty($items)) {
            foreach ($items AS $key => $item) {
                $items[$key]['option'] = $this->Organization->find('count', array(
                    'joins' => $joins[$foreignModel],
                    'conditions' => array(
                        'Organization.id' => $item['Organization']['id'],
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
        if (!$id || !$this->data = $this->Organization->read(null, hex2bin($id))) {
            $this->Session->setFlash(__('Please do following links in the page', true));
            $this->redirect(array('action' => 'index'));
        }
    }

    function admin_add($parentId = null) {
        if (!empty($this->data)) {
            $dataToSave = $this->data;
            if (!empty($parentId)) {
                $dataToSave['Organization']['parent_id'] = hex2bin($parentId);
            }
            $this->Organization->create();
            if ($this->Organization->save($dataToSave)) {
                $this->Session->setFlash(__('The data has been saved', true));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('Something was wrong during saving, please try again', true));
            }
        }
    }

    function admin_edit($id = null) {
        if (!empty($id)) {
            $item = $this->Organization->read(null, hex2bin($id));
        }
        if (empty($item)) {
            $this->Session->setFlash(__('Please do following links in the page', true));
            $this->redirect('/');
        }
        if (!empty($this->data)) {
            $dataToSave = $this->data;
            $this->Organization->id = $dataToSave['Organization']['id'] = hex2bin($id);
            if (!empty($dataToSave['Organization']['parent_id'])) {
                $dataToSave['Organization']['parent_id'] = hex2bin($dataToSave['Organization']['parent_id']);
            }
            if ($this->Organization->save($dataToSave)) {
                $this->Session->setFlash(__('The data has been saved', true));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('Something was wrong during saving, please try again', true));
            }
        } else {
            $this->data = $item;
        }
        $this->set('id', $id);
    }

    function admin_delete($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Please do following links in the page', true));
        } else if ($this->Organization->delete(hex2bin($id))) {
            $this->Session->setFlash(__('The data has been deleted', true));
        }
        $this->redirect(array('action' => 'index'));
    }

    function admin_habtmSet($foreignModel = null, $foreignId = 0, $id = 0, $switch = null) {
        $habtmKeys = array(
            'Tag' => array(
                'associationForeignKey' => 'Tag_id',
                'foreignKey' => 'Organization_id',
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
            $habtmModel = &$this->Organization->$habtmKeys[$foreignModel]['alias'];
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
