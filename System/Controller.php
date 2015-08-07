<?php
abstract class Controller
{
    /**
     *
     * @var View $view 
     */
    public $view;

    public $_args;
    
    protected $_userId;
    
    protected function _getArguments()
    {
        $count = count($this->_args);
        $arguments = array();
        for($i = 0; $i < $count - 1; $i += 2) {
            $arguments[$this->_args[$i]] = $this->_args[$i + 1];
        }
        return $arguments;
    }

    public function __construct()
    {
        session_start();
        $this->view = new View();
        $this->_userId = $this->getSessParam('currentUser');
    }

    abstract function indexAction();
    
    public function getAllParams()
    {
        return $_REQUEST;
    }
    
    public function getParamByKey($key)
    {
        return !empty($_REQUEST[$key]) ? $_REQUEST[$key] : NULL;
    }


    protected function setSessParam($key, $value)
    {
        $_SESSION[$key] = $value;
    }
    
    protected function getSessParam($key)
    {   
        if(!empty($_SESSION)) {
            return array_key_exists($key, $_SESSION) ? $_SESSION[$key] : NULL;
        }
        return NULL;
    }
    
    public function getUserId()
    {
        return $this->_userId;
    }
}


