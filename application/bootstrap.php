<?php
/**
 * My new Zend Framework project
 * 
 * @author  
 * @version 
 */

define('APPLICATION_DIRECTORY', realpath(dirname(__FILE__)));

set_include_path(APPLICATION_DIRECTORY . '/../library' . PATH_SEPARATOR . APPLICATION_DIRECTORY . '/../application/default/models/' . PATH_SEPARATOR . get_include_path() . PATH_SEPARATOR . '.');

require_once 'Zend/Loader.php'; // one require_once is still necessary
Zend_Loader::registerAutoload();

require_once 'Initializer.php';

$classFileIncCache = APPLICATION_DIRECTORY .  '/../data/pluginLoaderCache.php';
if (file_exists($classFileIncCache)) {
    include_once $classFileIncCache;
}
Zend_Loader_PluginLoader::setIncludeFileCache($classFileIncCache);

// Prepare the front controller. 
$frontController = Zend_Controller_Front::getInstance(); 

// Change to 'production' parameter under production environemtn
$frontController->registerPlugin(new Initializer('development'));    

// Dispatch the request using the front controller. 
$frontController->dispatch();
 
?>

