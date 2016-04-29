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

    function admin_index($foreignModel = null, $foreignId = null, $op = null) {
        $foreignKeys = array();

        $foreignKeys = array(
            'Organization' => 'Organization_id',
        );


        $habtmKeys = array(
            'Tag' => 'Tag_id',
        );
        $foreignKeys = array_merge($habtmKeys, $foreignKeys);

        $scope = array();
        if (array_key_exists($foreignModel, $foreignKeys) && $foreignId > 0) {
            $scope['Dataset.' . $foreignKeys[$foreignModel]] = $foreignId;

            $joins = array(
                'Tag' => array(
                    0 => array(
                        'table' => 'datasets_tags',
                        'alias' => 'DatasetsTag',
                        'type' => 'inner',
                        'conditions' => array('DatasetsTag.Dataset_id = Dataset.id'),
                    ),
                    1 => array(
                        'table' => 'tags',
                        'alias' => 'Tag',
                        'type' => 'inner',
                        'conditions' => array('DatasetsTag.Tag_id = Tag.id'),
                    ),
                ),
            );
            if (array_key_exists($foreignModel, $habtmKeys)) {
                unset($scope['Dataset.' . $foreignKeys[$foreignModel]]);
                if ($op != 'set') {
                    $scope[$joins[$foreignModel][0]['alias'] . '.' . $foreignKeys[$foreignModel]] = $foreignId;
                    $this->paginate['Dataset']['joins'] = $joins[$foreignModel];
                }
            }
        } else {
            $foreignModel = '';
        }
        $this->set('scope', $scope);
        $this->paginate['Dataset']['limit'] = 20;
        $items = $this->paginate($this->Dataset, $scope);

        if ($op == 'set' && !empty($joins[$foreignModel]) && !empty($foreignModel) && !empty($foreignId) && !empty($items)) {
            foreach ($items AS $key => $item) {
                $items[$key]['option'] = $this->Dataset->find('count', array(
                    'joins' => $joins[$foreignModel],
                    'conditions' => array(
                        'Dataset.id' => $item['Dataset']['id'],
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
        if (!$id || !$this->data = $this->Dataset->read(null, $id)) {
            $this->Session->setFlash('請依照網址指示操作');
            $this->redirect(array('action' => 'index'));
        }
    }

    function admin_add($parentId = null) {
        if (!empty($this->data)) {
            $dataToSave = $this->data;
            if (!empty($parentId)) {
                $dataToSave['Dataset']['parent_id'] = $parentId;
            }
            $this->Dataset->create();
            if ($this->Dataset->save($dataToSave)) {
                $this->Session->setFlash('資料已經儲存');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('資料儲存失敗，請重試');
            }
        }
    }

    function admin_edit($id = null) {
        if (!empty($id)) {
            $item = $this->Dataset->read(null, $id);
        }
        if (empty($item)) {
            $this->Session->setFlash('請依照網址指示操作');
            $this->redirect($this->referer());
        }
        if (!empty($this->data)) {
            $dataToSave = $this->data;
            $this->Dataset->id = $dataToSave['Dataset']['id'] = $id;
            if (!empty($dataToSave['Dataset']['parent_id'])) {
                $dataToSave['Dataset']['parent_id'] = $dataToSave['Dataset']['parent_id'];
            }
            if ($this->Dataset->save($dataToSave)) {
                $this->Session->setFlash('資料已經儲存');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('資料儲存失敗，請重試');
            }
        } else {
            $this->data = $item;
        }
        $this->set('id', $id);
    }

    function admin_delete($id = null) {
        if (!$id) {
            $this->Session->setFlash('請依照網址指示操作');
        } else if ($this->Dataset->delete($id)) {
            $this->Session->setFlash('資料已經刪除');
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
                $this->set('habtmMessage', '操作重複');
            } else if ($switch == 'on') {
                $habtmModel->create();
                if ($habtmModel->save(array($habtmKeys[$foreignModel]['alias'] => $conditions))) {
                    $this->set('habtmMessage', '已更新');
                } else {
                    $this->set('habtmMessage', '更新失敗');
                }
            } else {
                if ($habtmModel->deleteAll($conditions)) {
                    $this->set('habtmMessage', '已更新');
                } else {
                    $this->set('habtmMessage', '更新失敗');
                }
            }
        }
    }

}
