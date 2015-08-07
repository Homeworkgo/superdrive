<?php
class Controller_Authorize extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function indexAction()
    {
        
    }
    
    public function registerAction()
    {
        $params     = $this->getAllParams();
        
        $userModel  = new Model_User();
        try {
            $userId     = $userModel->register($params);
            $this->setSessParam('currentUser', $userId); 
            if($this->getParamByKey('save') == 'true') {
                $this->setSessParam('is_save', 1);   
            }
            $userData = array(
                'id'    =>  $userId,
                'email' =>  trim($params['email'])
            );
            
            echo json_encode($userData);
            die();
        }
        catch(Exception $e) {
            echo json_encode(array('error' => $e->getMessage()));
            die();
        }
    }
    
    public function loginAction()
    {
        $params     = $this->getAllParams();
        $userModel  = new Model_User();
        try {
            $userId = $userModel->login($params);
            $this->setSessParam('currentUser', $userId);
            if($this->getParamByKey('save') == 'true') {
                $this->setSessParam('is_save', 1);   
            }
            $userData = array(
                'id'    =>  $userId,
                'email' =>  trim($params['email'])
            );
            
            echo json_encode($userData);
            die();
        }
        catch(Exception $e) {
            echo json_encode(array('error' => $e->getMessage()));
            die();
        }
    }
    
    public function exitAction()
    {
        $_SESSION = array();
        unset($_COOKIE[session_name()]);
        session_destroy();
        setcookie(session_name(), '', time(), '/');
        die();
    }        
}