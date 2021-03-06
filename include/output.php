<?php

/**
 * Functions to handle sending output to a browser
 *
 * @author     Brian Moon <brian@moonspot.net>
 * @copyright  1997-Present Brian Moon
 * @package    Wordcraft
 * @license    http://wordcraft.googlecode.com/files/license.txt
 * @link       http://wordcraft.googlecode.com/
 *
 */

// Check that this file is not loaded directly.
if ( basename( __FILE__ ) == basename( $_SERVER["PHP_SELF"] ) ) exit();

// if init has not loaded, quit the file
if(!defined("WC")) return;

include_once dirname(__FILE__)."/url.php";

/**
 * Controls the output of the public facing site
 *
 * @param   string      $page       The page we are currently rendering
 * @param   array       $WCDATA     The data that the page needs to render
 * @return  none
 *
 */
function wc_output($page, $WCDATA="") {

    wc_build_common_data($WCDATA);

    // we don't want to pull $WC in here as a global
    $template = basename($GLOBALS["WC"]["template"]);

    $page = basename($page);

    // send the appropriate content type and character set
    header("Content-Type: text/html; charset=UTF-8");

    if(file_exists("./templates/$template/$page.php")){

        include_once "./templates/$template/header.php";

        include_once "./templates/$template/$page.php";

        include_once "./templates/$template/footer.php";

    } else {

        // check special pages
        switch($page) {
            case "message":
                include_once "./templates/$template/header.php";
                echo $WCDATA["message"];
                include_once "./templates/$template/footer.php";
                break;
            case "notfound":
                header('HTTP/1.1 404 Not Found');
                header('Status: 404 Not Found');
                include_once "./templates/$template/header.php";
                echo "The page you requested was not found.";
                include_once "./templates/$template/footer.php";
                break;
            case "error":
                header('HTTP/1.1 500 Internal Server Error');
                header('Status: 500 Internal Server Error');
                include_once "./templates/$template/header.php";
                echo $WCDATA["error"];
                include_once "./templates/$template/footer.php";
                break;
            default:
                trigger_error("Invalid page name $page.", E_TRIGGER_ERROR);
                break;
        }

    }

}


/**
 * Builds common data that most/all template pages need
 *
 * @param   array   $WCDATA    A reference to the data array that will be
 *                             used later to render the page.
 * @return  none
 *
 */
function wc_build_common_data(&$WCDATA) {

    global $WC;

    $WCDATA["base_url"] = htmlspecialchars($WC["base_url"], ENT_COMPAT, "UTF-8");
    $WCDATA["home_url"] = wc_get_url("main");
    $WCDATA["search_url"] = wc_get_url("search");

    if(empty($WCDATA["feed_url"])){
        $WCDATA["feed_url"] = wc_get_url("feed");
    }

    $WCDATA["nav_pages"] = wc_db_get_nav_pages();
    foreach($WCDATA["nav_pages"] as $key=>$page){
        $WCDATA["nav_pages"][$key]["nav_label"] = htmlspecialchars($page["nav_label"], ENT_COMPAT, "UTF-8");
        $WCDATA["nav_pages"][$key]["url"] = wc_get_url("page", array($page["page_id"], $page["uri"]));
    }

    $WCDATA["tags"] = wc_db_get_tags();
    foreach($WCDATA["tags"] as $key=>$tag){
        $WCDATA["tags"][$key]["tag"] = htmlspecialchars($tag["tag"], ENT_COMPAT, "UTF-8");
        $WCDATA["tags"][$key]["url"] = wc_get_url("tag", array($tag["tag"]));
    }

    $WCDATA["default_title"] = $WC["default_title"];
    if(empty($WCDATA["title"])){
        $WCDATA["title"] = $WC["default_title"];
    }

    $WCDATA["default_description"] = $WC["default_description"];
    if(empty($WCDATA["description"])){
        $WCDATA["description"] = $WC["default_description"];
    }

    if(!empty($WC["user"]["user_id"])){

        $WCDATA["user"] = $WC["user"];

        $WCDATA["admin"]["base_url"] = $WCDATA["base_url"]."/admin/";
        $WCDATA["admin"]["logout_url"] = $WCDATA["base_url"]."/admin/logout.php";
        $WCDATA["admin"]["new_post_url"] = $WCDATA["base_url"]."/admin/post.php";
        $WCDATA["admin"]["new_page_url"] = $WCDATA["base_url"]."/admin/page.php";
        if(isset($WCDATA["post"]["post_id"])) {
            $WCDATA["admin"]["edit_post_url"] = $WCDATA["base_url"]."/admin/post.php?post_id=".$WCDATA["post"]["post_id"];
        }
        if(isset($WCDATA["page"]["page_id"])) {
            $WCDATA["admin"]["edit_page_url"] = $WCDATA["base_url"]."/admin/page.php?page_id=".$WCDATA["page"]["page_id"];
        }
    }

}

?>
