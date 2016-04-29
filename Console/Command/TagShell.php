<?php

class TagShell extends AppShell {

    public $uses = array('Tag');

    public function main() {
        $this->datasetImport();
    }

    public function datasetImport() {
        $orgRoots = $this->Tag->Organization->find('list', array(
            'conditions' => array(
                'parent_id IS NULL'
            ),
            'fields' => array('Organization.name', 'Organization.id'),
        ));
        foreach (glob('/home/kiang/public_html/ckan/datasets/*.json') AS $jsonFile) {
            $json = json_decode(file_get_contents($jsonFile), true);
            $info = pathinfo($jsonFile);
            if (!isset($orgRoots[$info['filename']])) {
                $this->Tag->Organization->create();
                $this->Tag->Organization->save(array('Organization' => array(
                        'name' => $info['filename'],
                )));
                $orgRoots[$info['filename']] = $this->Tag->Organization->getInsertID();
            }
            foreach ($json AS $org => $data) {
                $this->Tag->Organization->create();
                $this->Tag->Organization->save(array('Organization' => array(
                        'parent_id' => $orgRoots[$info['filename']],
                        'name' => $org,
                )));
                $organizationId = bin2hex($this->Tag->Organization->getInsertID());
                if (!isset($data['datasets'])) {
                    continue;
                }
                foreach ($data['datasets'] AS $datasetId => $dataset) {
                    $this->Tag->Dataset->create();
                    $this->Tag->Dataset->save(array('Dataset' => array(
                            'organization_id' => $organizationId,
                            'name' => $dataset['title'],
                            'foreign_id' => $datasetId,
                            'created' => date('Y-m-d H:i:s', $dataset['timeBegin']),
                    )));
                    $datasetDB = $this->Tag->Dataset->getInsertID();
                    foreach ($dataset['resources'] AS $resourceId => $resource) {
                        $this->Tag->Dataset->create();
                        $this->Tag->Dataset->save(array('Dataset' => array(
                                'parent_id' => $datasetDB,
                                'organization_id' => $organizationId,
                                'name' => $resource['name'],
                                'foreign_id' => $resourceId,
                                'created' => date('Y-m-d H:i:s', strtotime($resource['created'])),
                        )));
                    }
                }
            }
        }
    }

}
