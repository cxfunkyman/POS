<?php
//Use for visualizing and testing only
//echo password_hash('admin', PASSWORD_DEFAULT);
//exit;

require_once 'config/Config.php';
require_once 'config/Helpers.php';

$route = (!empty($_GET['url'])) ? $_GET['url'] : 'home/index';

$array = explode('/', $route);
$controller = ucfirst($array[0]);
$method = 'index';
$parameter = '';

if(!empty($array[1]))
{
    if($array[1] != '')
    {
        $method = $array[1];
    }
}
if(!empty($array[2]))
{
    if($array[2] != '')
    {
    for ($i=2; $i < count($array); $i++) { 
            $parameter .= $array[$i] . ',';
        }
        $parameter = trim($parameter, ',');        
    }
}
require_once 'config/app/Autoload.php';
$dirController = 'controllers/' . $controller . '.php';

if(file_exists($dirController))
{
    require_once $dirController;
    $controller = new $controller();

    if(method_exists($controller, $method))
    {
        $controller -> $method($parameter);
    }
    else 
    {
        echo 'Method does not exist';
    }
}
else 
{
    echo 'Controller does not exist';
}
?>