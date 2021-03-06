<?php

/**
 * This is the main page where new blog posts are shown
 *
 * @author     Brian Moon <brian@moonspot.net>
 * @copyright  1997-Present Brian Moon
 * @package    Wordcraft
 * @license    http://wordcraft.googlecode.com/files/license.txt
 * @link       http://wordcraft.googlecode.com/
 *
 */


include_once "./include/common.php";
include_once "./include/database.php";
include_once "./include/output.php";
include_once "./include/format.php";

$display = 10;

if(isset($_GET["s"])){
    $start = (int)$_GET["s"];
} else {
    $start = 0;
}

$WCDATA["posts"] = array();
$total_posts = 0;

if($WCCACHE){
    $cache_key = "index - $start - $display";
    $page_data = $WCCACHE->get($cache_key);
    if($page_data !== false){
        list($WCDATA["posts"], $total_posts) = $page_data;
    }
}

if(empty($WCDATA["posts"])){

    list($WCDATA["posts"], $total_posts) = wc_db_get_post_list($start, $display, true);

    if($total_posts > 0){

        wc_format_post($WCDATA["posts"], true);
    }

    if($WCCACHE){
        $WCCACHE->set($cache_key, array($WCDATA["posts"], $total_posts));
    }

}


$WCDATA["title"] = $WC["default_title"];

$WCDATA["description"] = $WC["default_description"];

if($total_posts > $start + $display) {
    $WCDATA["older_url"] = wc_get_url("main");
    $s = $start + $display;
    if($s>0){
        $WCDATA["older_url"].="?s=$s";
    }
}

if(($start > 0)){
    $WCDATA["newer_url"] = wc_get_url("main");
    $s = $start - $display;
    if($s>0){
        $WCDATA["newer_url"].="?s=$s";
    }
}

wc_output("post_list", $WCDATA);

?>
