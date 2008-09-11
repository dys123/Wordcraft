<?php

include_once "./include/common.php";
include_once "./include/database.php";

$uri = (isset($_GET["uri"])) ? $_GET["uri"] : "";

if(empty($uri)){
    wc_output("notfound");
    return;
}

$uri_data = wc_db_lookup_uri($uri);

if(empty($uri_data)){
    wc_output("notfound");
    return;
}

if(isset($uri_data["current_uri"])){
    $new_url = wc_get_url($uri_data["type"], $uri_data["object_id"], $uri_data["current_uri"]);
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: $new_url");
    exit();
}

if($uri_data["type"]=="page"){
    include_once "./page.php";
} elseif($uri_data["type"]=="post"){
    include_once "./post.php";
} else {
    // not sure how I would get here
    wc_output("notfound");
    return;
}

?>