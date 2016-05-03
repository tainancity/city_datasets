<?php

class TagShell extends AppShell {

    public $uses = array('Tag');

    public function main() {
        $this->datasetImport();
    }

    public function datasetImport() {
        $dataPath = __DIR__ . '/data';
        if (!file_exists($dataPath)) {
            mkdir($dataPath, 0777, true);
        }
        $orgRef = array();
        $orgFile = $dataPath . '/organizations.csv';
        $fh = fopen($orgFile, 'r');
        while ($line = fgetcsv($fh, 1024)) {
            $orgRef[$line[1]] = $line[0];
        }
        fclose($fh);
        $datasetRef = array();
        $datasetFile = $dataPath . '/datasets.csv';
        $fh = fopen($datasetFile, 'r');
        while ($line = fgetcsv($fh, 1024)) {
            $datasetRef[$line[1]] = $line[0];
        }
        fclose($fh);
        $config = array(
            'tainan' => array(
                'name' => '臺南市',
                'url' => 'http://data.tainan.gov.tw/',
                'dataset' => 'http://data.tainan.gov.tw/dataset/',
                'resource' => 'http://data.tainan.gov.tw/dataset/{DATASET_ID}/resource/{RESOURCE_ID}',
                'org' => 'http://data.tainan.gov.tw/organization/',
            ),
            'taoyuan' => array(
                'name' => '桃園市',
                'url' => 'http://data.tycg.gov.tw/',
                'dataset' => 'http://ckan.tycg.gov.tw/dataset/',
                'resource' => 'http://ckan.tycg.gov.tw/dataset/{DATASET_ID}/resource/{RESOURCE_ID}',
                'org' => 'http://ckan.tycg.gov.tw/organization/',
            ),
            'nantou' => array(
                'name' => '南投縣',
                'url' => 'http://data.nantou.gov.tw/',
                'dataset' => 'http://data.nantou.gov.tw/dataset/',
                'resource' => 'http://data.nantou.gov.tw/dataset/{DATASET_ID}/resource/{RESOURCE_ID}',
                'org' => 'http://data.tycg.gov.tw/organization/',
            ),
            'hccg' => array(
                'name' => '新竹市',
                'url' => 'http://opendata.hccg.gov.tw/',
                'dataset' => 'http://opendata.hccg.gov.tw/dataset/',
                'resource' => 'http://opendata.hccg.gov.tw/dataset/{DATASET_ID}/resource/{RESOURCE_ID}',
                'org' => 'http://opendata.hccg.gov.tw/organization/',
            ),
            'taipei' => array(
                'name' => '臺北市',
                'url' => 'http://data.taipei/',
                'dataset' => 'http://data.taipei/opendata/datalist/datasetMeta?oid=',
                'resource' => 'http://data.taipei/opendata/datalist/datasetMeta/preview?id={DATASET_ID}&rid={RESOURCE_ID}',
                'org' => 'http://data.taipei/opendata/datalist/datasetByOrg?oid=',
            ),
        );
        $orgRoots = $this->Tag->Organization->find('list', array(
            'conditions' => array(
                'parent_id IS NULL'
            ),
            'fields' => array('Organization.name', 'Organization.id'),
        ));
        foreach (glob('/home/kiang/public_html/city_datasets_crawlers/datasets/*.json') AS $jsonFile) {
            $json = json_decode(file_get_contents($jsonFile), true);
            $info = pathinfo($jsonFile);
            $baseConfig = $config[$info['filename']];
            if (!isset($orgRoots[$info['filename']])) {
                if (isset($orgRef[$info['filename']])) {
                    $orgRoots[$info['filename']] = $orgRef[$info['filename']];
                } else {
                    $this->Tag->Organization->create();
                    $this->Tag->Organization->save(array('Organization' => array(
                            'name' => $baseConfig['name'],
                            'foreign_id' => $info['filename'],
                            'foreign_uri' => $baseConfig['url'],
                    )));
                    $orgRoots[$info['filename']] = $this->Tag->Organization->getInsertID();
                }
            }

            foreach ($json AS $org => $data) {
                $org = trim($org);
                if (!isset($data['datasets'])) {
                    continue;
                }
                if (empty($org)) {
                    $org = $orgRoots[$info['filename']];
                }
                $organizationId = false;
                foreach ($data['datasets'] AS $datasetId => $dataset) {
                    if (false === $organizationId) {
                        $orgKey = "{$info['filename']}/{$dataset['organization_id']}";
                        if (isset($orgRef[$orgKey])) {
                            $organizationId = $orgRef[$orgKey];
                        } else {
                            $this->Tag->Organization->create();
                            $this->Tag->Organization->save(array('Organization' => array(
                                    'parent_id' => $orgRoots[$info['filename']],
                                    'name' => $org,
                                    'foreign_id' => $dataset['organization_id'],
                                    'foreign_uri' => $baseConfig['org'] . $dataset['organization_id'],
                            )));
                            $organizationId = $this->Tag->Organization->getInsertID();
                        }
                    }
                    $datasetKey = "{$info['filename']}/{$datasetId}";
                    if (isset($datasetRef[$datasetKey])) {
                        $datasetDB = $datasetRef[$datasetKey];
                    } else {
                        $this->Tag->Dataset->create();
                        $this->Tag->Dataset->save(array('Dataset' => array(
                                'organization_id' => $organizationId,
                                'name' => $dataset['title'],
                                'foreign_id' => $datasetId,
                                'foreign_uri' => $baseConfig['dataset'] . $datasetId,
                                'created' => date('Y-m-d H:i:s', $dataset['timeBegin']),
                        )));
                        $datasetDB = $this->Tag->Dataset->getInsertID();
                    }

                    foreach ($dataset['resources'] AS $resourceId => $resource) {
                        $resourceKey = "{$info['filename']}/{$resourceId}";
                        if (!isset($datasetRef[$resourceKey])) {
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

        $items = $this->Tag->Organization->find('all', array(
            'fields' => array(
                'Organization.id', 'Organization.parent_id', 'Organization.foreign_id',
                'Organization.name',
            ),
            'order' => array(
                'Organization.lft' => 'ASC'
            ),
        ));
        $rootNodes = $nodes = array();
        $fh = fopen($orgFile, 'w');
        foreach ($items AS $item) {
            if (empty($item['Organization']['foreign_id'])) {
                $item['Organization']['foreign_id'] = $item['Organization']['name'];
            }
            if (empty($item['Organization']['parent_id'])) {
                $rootNodes[$item['Organization']['id']] = $item['Organization']['foreign_id'];
                fputcsv($fh, array($item['Organization']['id'], $item['Organization']['foreign_id']));
            } else {
                $nodes[$item['Organization']['id']] = $rootNodes[$item['Organization']['parent_id']];
                fputcsv($fh, array($item['Organization']['id'], "{$rootNodes[$item['Organization']['parent_id']]}/{$item['Organization']['foreign_id']}"));
            }
        }
        fclose($fh);

        $items = $this->Tag->Dataset->find('all', array(
            'fields' => array('Dataset.id', 'Dataset.organization_id', 'Dataset.foreign_id'),
            'order' => array(
                'Dataset.lft' => 'ASC'
            ),
        ));
        $fh = fopen($datasetFile, 'w');
        foreach ($items AS $item) {
            if (!isset($nodes[$item['Dataset']['organization_id']])) {
                continue;
            }
            fputcsv($fh, array($item['Dataset']['id'], "{$nodes[$item['Dataset']['organization_id']]}/{$item['Dataset']['foreign_id']}"));
        }
        fclose($fh);
    }

}
