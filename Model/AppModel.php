<?php

class AppModel extends Model {

    public $actsAs = array('Containable');
    public $recursive = -1;

    public function checkUnique($data) {
        foreach ($data AS $key => $value) {
            if (empty($value)) {
                return false;
            }
            if ($this->id) {
                return !$this->hasAny(array(
                            'id !=' => $this->id, $key => $value,
                ));
            } else {
                return !$this->hasAny(array($key => $value));
            }
        }
    }

    public function getUUID() {
        if (function_exists('uuid_create')) {
            $uuid = uuid_create();
        } else {
            App::uses('String', 'Utility');
            $uuid = String::uuid();
        }
        return str_replace('-', '', $uuid);
    }

}
