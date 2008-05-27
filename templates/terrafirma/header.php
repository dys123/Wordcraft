<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--
    Template Author Info:
    terrafirma1.0 by nodethirtythree design
    http://www.nodethirtythree.com
-->
<html>
<head>
<title><?php echo $WCDATA["title"]; ?></title>
<meta name="description" content="<?php echo $WCDATA["description"]; ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo $WCDATA["base_url"]; ?>/templates/terrafirma/default.css" />
<link rel="alternate" type="application/rss+xml" title="<?php echo $WCDATA["default_title"]; ?>" href="<?php echo $WCDATA["feed_url"]; ?>" />
</head>
<body>

<div id="outer">

    <div id="upbg"></div>

    <div id="inner">

        <div id="header">
            <div class="title">Wordcraft<sup>0.1</sup></div>
            <div class="subtitle">a simple blogging software</div>
        </div>

        <div id="splash"></div>

        <div id="menu">
            <ul>
                <li class="first"><a href="<?php echo $WCDATA["home_url"]; ?>">Home</a></li>
                <?php if(isset($WCDATA["nav_pages"])) foreach($WCDATA["nav_pages"] as $nav_page) { ?>
                    <li><a href="<?php echo $nav_page["url"]; ?>"><?php echo htmlspecialchars($nav_page["nav_label"]); ?></a></li>
                <?php } ?>
            </ul>

        </div>


        <div id="primarycontent">

            <!-- primary content start -->
