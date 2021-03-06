<?php
namespace frontend\helpers;

class LocationHelper {

    /** Преобразует строку урла в соответствии с выбранной локацией
     * @param $url
     */
    public static function getDomainForUrl($url, $use_cookie = true, $city = null){
        $domain = '';
        if($use_cookie) {
            if (isset($_COOKIE['city']) AND $_COOKIE['city']) {
                $domain = $_COOKIE['city'] . "/";
            } else {
                if (isset($_COOKIE['region']) AND $_COOKIE['region']) $domain = $_COOKIE['region']. "/";
            }
        }
        if($url != "/"){
            return "/".$domain . $url;
        }else{

            return "/".$city;
        }

    }

    /**
     * @return string
     */
    public static function getCurrentDomain(){
        $domain = '';
        if(isset($_COOKIE['city']) AND $_COOKIE['city']){
            $domain = $_COOKIE['city'];
        }else{
            if(isset($_COOKIE['region']) AND $_COOKIE['region']) $domain = $_COOKIE['region'];
        }
        return $domain;
    }
}
