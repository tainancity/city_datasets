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


function city_to_str($city_name)
{
    switch ($city_name)
    {
        case "hccg":
            return "新竹市";
            break;
        case "nantou":
            return "南投縣";
            break;
        case "tainan":
            return "臺南市";
            break;
        case "taipei":
            return "臺北市";
            break;
        case "taoyuan":
            return "桃園市";
            break;
        
    }
}
