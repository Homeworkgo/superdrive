<?php 
define('DS', DIRECTORY_SEPARATOR);
// Узнаём путь к файлам сайта
$site_path = realpath(dirname(__FILE__) . DS) . DS;
define('SITE_PATH', $site_path);

$config     = file_get_contents(SITE_PATH . DS. 'config.xml');

$configXML  = new SimpleXMLElement($config);

$host       = (string)$configXML->db->host;
$dbname     = (string)$configXML->db->dbname;  
$username   = (string)$configXML->db->username;
$password   = (string)$configXML->db->password;

try {
    $db = new PDO('mysql:host='.$host.'; dbname='.$dbname, $username, $password);
} catch (PDOException $e) {
    echo "Error!: " . $e->getMessage();
}

spl_autoload_register('loadClass');


function loadClass($className)
{
    $path       =   explode('_', $className);
    
    $className  =   end($path);
    $countPath  =   count($path);
    
    if($countPath == 1) {
        $file = SITE_PATH . 'System' . DS . $className. '.php';
    }
    elseif($countPath == 2) {
        if($path[0] == 'Db') {
            $file = SITE_PATH . 'System' . DS . 'Db'. DS. $className. '.php';
        }
        elseif($path[0] == 'Model') {
            $file = SITE_PATH . 'Model' . DS . $className. '.php';
        }
    }
    elseif($countPath == 4) {
        $file = SITE_PATH . 'Model' . DS . 'Db' . DS . 'Table' . DS . $className. '.php';
    }

    if (file_exists($file) == false) {
        return false;
    }
    
    include $file;
}

try {
    Registry::set('db', $db);
}
catch(Exception $e) {
    echo $e->getMessage();
}

$router = new Router();

try {
    $router->setPath($site_path . 'Controller');
    $router->start();
}
catch(Exception $e) {
    echo $e->getMessage();
}