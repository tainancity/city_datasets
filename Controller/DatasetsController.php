<?php

App::uses('AppController', 'Controller');

class DatasetsController extends AppController {

    public $name = 'Datasets';
    public $paginate = array();
    public $helpers = array();

    public function beforeFilter() {
        parent::beforeFilter();
        if (isset($this->Auth)) {
            $this->Auth->allow(array('q', 'index'));
        }
    }

    public function q($keyword = '') {
        $this->autoRender = false;
        $this->response->type('json');
        $keyword = trim($keyword);
        $result = array(
            'keyword' => $keyword,
            'result' => array(),
        );
        if (!empty($keyword)) {
            $items = $this->Dataset->find('all', array(
                'conditions' => array(
                    'Dataset.parent_id IS NULL',
                    'Dataset.name LIKE' => "%{$keyword}%",
                ),
            ));
            foreach ($items AS $item) {
                $item['Dataset']['label'] = $item['Dataset']['value'] = $item['Dataset']['name'];
                $result['result'][] = $item['Dataset'];
            }
        }
        if (!isset($_GET['pretty'])) {
            $this->response->body(json_encode($result));
        } else {
            $this->response->body(json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        }
    }

    function index() {
        
    }

    function view() {
        
    }

    function admin_view($id = null) {
        if (!$id || !$this->data = $this->Dataset->read(null, hex2bin($id))) {
            $this->Session->setFlash(__('Please do following links in the page', true));
            $this->redirect(array('action' => 'index'));
        }
    }

    function admin_add($parentId = null) {
        if (!empty($this->data)) {
            $dataToSave = $this->data;
            if (!empty($parentId)) {
                $dataToSave['Dataset']['parent_id'] = hex2bin($parentId);
            }
            $this->Dataset->create();
            if ($this->Dataset->save($dataToSave)) {
                $this->Session->setFlash(__('The data has been saved', true));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('Something was wrong during saving, please try again', true));
            }
        }
    }

    function admin_edit($id = null) {
        if (!empty($id)) {
            $item = $this->Dataset->read(null, hex2bin($id));
        }
        if (empty($item)) {
            $this->Session->setFlash(__('Please do following links in the page', true));
            $this->redirect($this->referer());
        }
        if (!empty($this->data)) {
            $dataToSave = $this->data;
            $this->Dataset->id = $dataToSave['Dataset']['id'] = hex2bin($id);
            if (!empty($dataToSave['Dataset']['parent_id'])) {
                $dataToSave['Dataset']['parent_id'] = hex2bin($dataToSave['Dataset']['parent_id']);
            }
            if ($this->Dataset->save($dataToSave)) {
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
        } else if ($this->Dataset->delete(hex2bin($id))) {
            $this->Session->setFlash(__('The data has been deleted', true));
        }
        $this->redirect(array('action' => 'index'));
    }

    function admin_habtmSet($foreignModel = null, $foreignId = null, $id = null, $switch = null) {
        $habtmKeys = array(
            'Tag' => array(
                'associationForeignKey' => 'tag_id',
                'foreignKey' => 'foreign_id',
                'alias' => 'LinksTag',
                'conditions' => array(
                    'LinksTag.model' => 'Dataset',
                ),
            ),
        );
        $foreignModel = array_key_exists($foreignModel, $habtmKeys) ? $foreignModel : null;
        $switch = in_array($switch, array('on', 'off')) ? $switch : null;
        if (empty($foreignModel) || $foreignId <= 0 || $id <= 0 || empty($switch)) {
            $this->set('habtmMessage', __('Wrong Parameters'));
        } else {
            $habtmModel = &$this->Dataset->$habtmKeys[$foreignModel]['alias'];
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
