<?php

/**
 * Shows posts by tag
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

$tag = (isset($_GET["tag"])) ? trim((string)$_GET["tag"]) : "";

if(empty($tag)){
    wc_output("notfound");
    return;
}

list($WCDATA["posts"], $total_posts) = wc_db_get_post_list($start, $display, true, "", $tag);

if($total_posts<1){
    wc_output("notfound");
    return;
}

foreach($WCDATA["posts"] as &$post){
    wc_format_post($post);
}
unset($post);

$WCDATA["title"] = "Posts tagged with `".htmlspecialchars($tag, ENT_COMPAT, "UTF-8")."` - ".$WC["default_title"];
$WCDATA["description"] = "Posts tagged with `".htmlspecialchars($tag, ENT_COMPAT, "UTF-8")."`. ".$WC["default_description"];

$WCDATA["feed_url"] = wc_get_url("feed", array("rss", $tag, ""));

if($total_posts > $start + $display) {
    $s = $start + $display;
    $WCDATA["older_url"] = wc_get_url("tag", array($tag))."&amp;s=$s";
}

if(($start > 0)){
    $WCDATA["newer_url"] = wc_get_url("tag", array($tag));
    $s = $start - $display;
    if($s>0){
        $WCDATA["newer_url"].="&amp;s=$s";
    }
}


wc_output("post_list", $WCDATA);

?>
