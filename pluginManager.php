<?php

# get correct id for plugin
$thisfile = basename(__FILE__, ".php");



# register plugin
register_plugin(
    $thisfile, //Plugin id
    'pluginManager 🔌',     //Plugin name
    '1.0',         //Plugin version
    'Multicolor',  //Plugin author
    'https://ko-fi.com/multicolorplugins', //author website
    'Plugin for download from ce repo/unistall plugins from system', //Plugin description
    'plugins', //page type - on which admin tab to display
    'pluginManager'  //main function (administration)
);


add_action('plugins-sidebar', 'createSideMenu', array($thisfile, 'Download Plugins 🔌', 'downloadplugins'));
add_action('plugins-sidebar', 'createSideMenu', array($thisfile, 'Unistall Plugins 🗑️', 'removeplugins'));


function pluginManager()
{

    if (isset($_GET['downloadplugins'])) {
        include(GSPLUGINPATH . 'pluginManager/downloader.php');
    } else {
        include(GSPLUGINPATH . 'pluginManager/unistaller.php');
    }
}
