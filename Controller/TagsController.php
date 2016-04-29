<?php

App::uses('AppController', 'Controller');

class TagsController extends AppController {

    public $name = 'Tags';
    public $paginate = array();
    public $helpers = array();

    public function beforeFilter() {
        parent::beforeFilter();
        if (isset($this->Auth)) {
            $this->Auth->allow(array('q', 'index'));
        }
    }

    public function q($model = '', $keyword = '') {
        $this->autoRender = false;
        $this->response->type('json');
        $keyword = trim($keyword);
        $result = array(
            'keyword' => $keyword,
            'result' => array(),
        );
        if (!empty($keyword)) {
            $items = $this->Tag->find('all', array(
                'conditions' => array(
                    'Tag.model' => $model,
                    'Tag.name LIKE' => "%{$keyword}%",
                ),
            ));
            foreach ($items AS $item) {
                $item['Tag']['label'] = $item['Tag']['value'] = $item['Tag']['name'];
                $result['result'][] = $item['Tag'];
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

    function view($id = null) {
        
    }

    function admin_index($foreignModel = null, $foreignId = null, $op = null) {
        $foreignKeys = array();
        $habtmKeys = array(
            'Dataset' => 'foreign_id',
            'Organization' => 'foreign_id',
        );
        $foreignKeys = array_merge($habtmKeys, $foreignKeys);

        $scope = array();
        if (array_key_exists($foreignModel, $foreignKeys) && !empty($foreignId)) {
            $joins = array(
                'Dataset' => array(
                    0 => array(
                        'table' => 'links_tags',
                        'alias' => 'LinksTag',
                        'type' => 'inner',
                        'conditions' => array(
                            'LinksTag.tag_id = Tag.id',
                            'LinksTag.model' => 'Dataset',
                        ),
                    ),
                    1 => array(
                        'table' => 'datasets',
                        'alias' => 'Dataset',
                        'type' => 'inner',
                        'conditions' => array('LinksTag.foreign_id = Dataset.id'),
                    ),
                ),
                'Organization' => array(
                    0 => array(
                        'table' => 'links_tags',
                        'alias' => 'LinksTag',
                        'type' => 'inner',
                        'conditions' => array(
                            'LinksTag.tag_id = Tag.id',
                            'LinksTag.model' => 'Organization',
                        ),
                    ),
                    1 => array(
                        'table' => 'organizations',
                        'alias' => 'Organization',
                        'type' => 'inner',
                        'conditions' => array('LinksTag.foreign_id = Organization.id'),
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
        }
        if (!empty($foreignModel)) {
            $scope['Tag.model'] = $foreignModel;
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
        if (!empty($id)) {
            $this->data = $this->Tag->find('first', array(
                'conditions' => array(
                    'Tag.id' => $id,
                ),
            ));
            $tagModel = $this->data['Tag']['model'];
            $items = $this->Tag->{$tagModel}->find('all', array(
                'conditions' => array(
                    'LinksTag.tag_id' => $id,
                ),
                'joins' => array(
                    array(
                        'table' => 'links_tags',
                        'alias' => 'LinksTag',
                        'type' => 'inner',
                        'conditions' => array(
                            'LinksTag.model' => $tagModel,
                            "LinksTag.foreign_id = {$tagModel}.id",
                        ),
                    ),
                ),
            ));
            foreach ($items AS $k => $item) {
                $path = $this->Tag->{$tagModel}->getPath($items[$k][$tagModel]['id'], array('id', 'name'));
                $items[$k][$tagModel]['name'] = implode(' > ', Set::extract("{n}.{$tagModel}.name", $path));
            }
            $this->set('items', $items);
            $this->view = 'admin_view' . $tagModel;
        }
        if (empty($this->data)) {
            $this->Session->setFlash('請依照網址指示操作');
            $this->redirect(array('action' => 'index'));
        }
    }

    function admin_add($parentId = null) {
        if (!empty($this->data)) {
            $dataToSave = $this->data;
            if (!empty($parentId)) {
                $dataToSave['Tag']['parent_id'] = $parentId;
            }
            $this->Tag->create();
            if ($this->Tag->save($dataToSave)) {
                if (!$this->request->isAjax()) {
                    $this->Session->setFlash('資料已經儲存');
                    $this->redirect(array('action' => 'index'));
                } else {
                    echo json_encode(array(
                        'result' => 'ok',
                        'id' => $this->Tag->getInsertID(),
                    ));
                    exit();
                }
            } else {
                if (!$this->request->isAjax()) {
                    $this->Session->setFlash('資料儲存失敗，請重試');
                } else {
                    echo json_encode(array(
                        'result' => 'error',
                    ));
                    exit();
                }
            }
        }
    }

    function admin_edit($id = null) {
        if (!empty($id)) {
            $item = $this->Tag->read(null, $id);
        }
        if (empty($item)) {
            $this->Session->setFlash('請依照網址指示操作');
            $this->redirect('/');
        }
        if (!empty($this->data)) {
            $dataToSave = $this->data;
            $this->Tag->id = $dataToSave['Tag']['id'] = $id;
            if (!empty($dataToSave['Tag']['parent_id'])) {
                $dataToSave['Tag']['parent_id'] = $dataToSave['Tag']['parent_id'];
            }
            if ($this->Tag->save($dataToSave)) {
                if (!$this->request->isAjax()) {
                    $this->Session->setFlash('資料已經儲存');
                    $this->redirect(array('action' => 'index'));
                } else {
                    echo json_encode(array(
                        'result' => 'ok',
                        'id' => $id,
                    ));
                    exit();
                }
            } else {
                if (!$this->request->isAjax()) {
                    $this->Session->setFlash('資料儲存失敗，請重試');
                } else {
                    echo json_encode(array(
                        'result' => 'error',
                    ));
                    exit();
                }
            }
        } else {
            $this->data = $item;
        }
        $this->set('id', $id);
    }

    function admin_delete($id = null) {
        if (!$id) {
            $this->Session->setFlash('請依照網址指示操作');
        } else if ($this->Tag->delete($id)) {
            $this->Session->setFlash('資料已經刪除');
        }
        $this->redirect(array('action' => 'index'));
    }

    function admin_habtmSet($foreignModel = null, $foreignId = null, $id = null, $switch = null) {
        $habtmKeys = array(
            'Dataset' => array(
                'associationForeignKey' => 'foreign_id',
                'foreignKey' => 'tag_id',
                'alias' => 'LinksTag',
                'conditions' => array(
                    'LinksTag.model' => 'Dataset',
                ),
            ),
            'Organization' => array(
                'associationForeignKey' => 'foreign_id',
                'foreignKey' => 'tag_id',
                'alias' => 'LinksTag',
                'conditions' => array(
                    'LinksTag.model' => 'Organization',
                ),
            ),
        );
        $foreignModel = array_key_exists($foreignModel, $habtmKeys) ? $foreignModel : null;
        $switch = in_array($switch, array('on', 'off')) ? $switch : null;
        if (empty($foreignModel) || empty($foreignId) || empty($id) || empty($switch)) {
            $this->set('habtmMessage', __('Wrong Parameters'));
        } else {
            $conditions = array(
                'tag_id' => $id,
                'foreign_id' => $foreignId,
                'model' => $foreignModel,
            );
            $links = $this->Tag->LinksTag->find('list', array(
                'fields' => array('LinksTag.id', 'LinksTag.id'),
                'conditions' => $conditions,
            ));
            $status = !empty($links) ? 'on' : 'off';
            if ($status == $switch) {
                $this->set('habtmMessage', '操作重複');
            } else if ($switch == 'on') {
                $this->Tag->LinksTag->create();
                if ($this->Tag->LinksTag->save(array('LinksTag' => $conditions))) {
                    $this->set('habtmMessage', '已更新');
                } else {
                    $this->set('habtmMessage', '更新失敗');
                }
            } else {
                $result = true;
                foreach ($links AS $link) {
                    if ($result) {
                        $result = $this->Tag->LinksTag->delete($link);
                    }
                }
                if ($result) {
                    $this->set('habtmMessage', '已更新');
                } else {
                    $this->set('habtmMessage', '更新失敗');
                }
            }
        }
    }

    public function admin_datasets() {
        $scope = array('Tag.model' => 'Dataset');
        $this->paginate['Tag']['limit'] = 9;
        $items = $this->paginate($this->Tag, $scope);
        $organizations = array();
        foreach ($items AS $k => $item) {
            $items[$k]['Dataset'] = $this->Tag->Dataset->find('all', array(
                'fields' => array('Dataset.id', 'Dataset.name', 'Organization.parent_id'),
                'contain' => array('Organization'),
                'conditions' => array(
                    'LinksTag.tag_id' => $item['Tag']['id'],
                ),
                'joins' => array(
                    array(
                        'table' => 'links_tags',
                        'alias' => 'LinksTag',
                        'type' => 'inner',
                        'conditions' => array(
                            'LinksTag.foreign_id = Dataset.id',
                            'LinksTag.model' => 'Dataset',
                        ),
                    ),
                ),
            ));
            foreach ($items[$k]['Dataset'] AS $dk => $dv) {
                if (!isset($organizations[$items[$k]['Dataset'][$dk]['Organization']['parent_id']])) {
                    $this->Tag->Organization->id = $items[$k]['Dataset'][$dk]['Organization']['parent_id'];
                    $organizations[$items[$k]['Dataset'][$dk]['Organization']['parent_id']] = $this->Tag->Organization->field('name');
                }
                $items[$k]['Dataset'][$dk]['Organization']['name'] = $organizations[$items[$k]['Dataset'][$dk]['Organization']['parent_id']];
            }
        }
        $this->set('items', $items);
    }

    public function admin_organizations() {
        $scope = array('Tag.model' => 'Organization');
        $this->paginate['Tag']['limit'] = 9;
        $items = $this->paginate($this->Tag, $scope);
        foreach ($items AS $k => $item) {
            $items[$k]['Organization'] = $this->Tag->Organization->find('all', array(
                'fields' => array('Organization.id', 'Organization.name', 'Parent.name'),
                'contain' => array('Parent'),
                'conditions' => array(
                    'Organization.parent_id IS NOT NULL',
                    'LinksTag.tag_id' => $item['Tag']['id'],
                ),
                'joins' => array(
                    array(
                        'table' => 'links_tags',
                        'alias' => 'LinksTag',
                        'type' => 'inner',
                        'conditions' => array(
                            'LinksTag.foreign_id = Organization.id',
                            'LinksTag.model' => 'Organization',
                        ),
                    ),
                ),
            ));
        }
        $this->set('items', $items);
    }

}
