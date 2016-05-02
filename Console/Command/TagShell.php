<?php

class TagShell extends AppShell {

    public $uses = array('Tag');

    public function main() {
        $this->datasetImport();
    }

    public function datasetImport() {
        $config = array(
            'tainan' => array(
                'url' => 'http://data.tainan.gov.tw/',
                'dataset' => 'http://data.tainan.gov.tw/dataset/',
                'resource' => 'http://data.tainan.gov.tw/dataset/{DATASET_ID}/resource/{RESOURCE_ID}',
            ),
            'taoyuan' => array(
                'url' => 'http://data.tycg.gov.tw/',
                'dataset' => 'http://data.tycg.gov.tw/opendata/datalist/datasetMeta?oid=',
                'resource' => 'http://data.tycg.gov.tw/opendata/datalist/datasetMeta/preview?id={DATASET_ID}&rid={RESOURCE_ID}',
            ),
            'nantou' => array(
                'url' => 'http://data.nantou.gov.tw/',
                'dataset' => 'http://data.nantou.gov.tw/dataset/',
                'resource' => 'http://data.nantou.gov.tw/dataset/{DATASET_ID}/resource/{RESOURCE_ID}',
            ),
            'hccg' => array(
                'url' => 'http://opendata.hccg.gov.tw/',
                'dataset' => 'http://opendata.hccg.gov.tw/dataset/',
                'resource' => 'http://opendata.hccg.gov.tw/dataset/{DATASET_ID}/resource/{RESOURCE_ID}',
            ),
            'taipei' => array(
                'url' => 'http://data.taipei/',
                'dataset' => 'http://data.taipei/opendata/datalist/datasetMeta?oid=',
                'resource' => 'http://data.taipei/opendata/datalist/datasetMeta/preview?id={DATASET_ID}&rid={RESOURCE_ID}',
            ),
        );
        $orgRoots = $this->Tag->Organization->find('list', array(
            'conditions' => array(
                'parent_id IS NULL'
            ),
            'fields' => array('Organization.name', 'Organization.id'),
        ));
        foreach (glob('/home/kiang/public_html/ckan/datasets/*.json') AS $jsonFile) {
            $json = json_decode(file_get_contents($jsonFile), true);
            $info = pathinfo($jsonFile);
            $baseConfig = $config[$info['filename']];
            if (!isset($orgRoots[$info['filename']])) {
                $this->Tag->Organization->create();
                $this->Tag->Organization->save(array('Organization' => array(
                        'name' => $info['filename'],
                        'foreign_id' => $info['filename'],
                        'foreign_uri' => $baseConfig['url'],
                )));
                $orgRoots[$info['filename']] = $this->Tag->Organization->getInsertID();
            }

            foreach ($json AS $org => $data) {
                $org = trim($org);
                if (!isset($data['datasets']) || empty($org)) {
                    continue;
                }
                $this->Tag->Organization->create();
                $this->Tag->Organization->save(array('Organization' => array(
                        'parent_id' => $orgRoots[$info['filename']],
                        'name' => $org,
                )));
                $organizationId = $this->Tag->Organization->getInsertID();
                foreach ($data['datasets'] AS $datasetId => $dataset) {
                    $this->Tag->Dataset->create();
                    $this->Tag->Dataset->save(array('Dataset' => array(
                            'organization_id' => $organizationId,
                            'name' => $dataset['title'],
                            'foreign_id' => $datasetId,
                            'foreign_uri' => $baseConfig['dataset'] . $datasetId,
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
                                'foreign_uri' => str_replace(array(
                                    '{DATASET_ID}', '{RESOURCE_ID}'
                                        ), array(
                                    $datasetId, $resourceId
                                        ), $baseConfig['resource']),
                                'created' => date('Y-m-d H:i:s', strtotime($resource['created'])),
                        )));
                    }
                }
            }
        }
    }

}
