<?php

CakePlugin::loadAll();
require App::pluginPath('Permissible') . 'Config/init.php';

function tag_to_str($tag_type_name)
{
    switch ($tag_type_name)
    {
        case "Organization":
            return "組織";
            break;
        case "Dataset":
            return "資料集";
            break;
        
    }
}