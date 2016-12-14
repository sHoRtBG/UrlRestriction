<?php

class urlRestriction {

    static private $allowed = array();
    static private $ips = array();

    private function __construct() {
        
    }

    public static function set($url) {
        if (is_array($url)) {
            foreach ($url as $value) {
                self::$allowed[] = $value;
                self::$ips[] = getHostByName($value);
            }
        } else {
            self::$allowed[] = $url;
            self::$ips[] = getHostByName($url);
        }
    }

    public static function check($url) {
        $parse = parse_url($url);
        if (array_key_exists("host", $parse)) {
            if (substr($parse["host"], 0, 4) == "www.") {
                $parse["host"] = substr($parse["host"], 4);
            }
            if (in_array($parse["host"], self::$allowed)) {
                #echo $url." :: It is allowed!<br />\n";
                return true;
            }
        }
        #echo $url." :: It is not allowed!<br />\n";
        return false;
    }

    public static function check_byIP($url) {
        $parse = parse_url($url);
        if (array_key_exists("host", $parse)) {
            if (substr($parse["host"], 0, 4) == "www.") {
                $parse["host"] = substr($parse["host"], 4);
            }
            if (in_array(getHostByName($parse["host"]), self::$ips)) {
                #echo $url." :: It is allowed!<br />\n";
                return true;
            }
        }
        #echo $url." :: It is not allowed!<br />\n";
        return false;
    }

}

urlRestriction::set("facebook.com");
urlRestriction::set(array("google.com", "youtube.com"));

urlRestriction::check("https://www.facebook.com/9gag/?fref=nf");
urlRestriction::check("https://www.youtube.com/watch?v=mU2oHXdAFIw");
urlRestriction::check("http://stackoverflow.com/questions");


urlRestriction::check_byIP("https://www.facebook.com/9gag/?fref=nf");
urlRestriction::check_byIP("https://www.youtube.com/watch?v=mU2oHXdAFIw");
urlRestriction::check_byIP("http://stackoverflow.com/questions");
