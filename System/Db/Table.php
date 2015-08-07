<?php
abstract class Db_Table
{
    public $_name;
    
    /**
     * 
     * @var PDO $_connection 
     */
    protected $_connection;
    
    public function __construct()
    {
        $this->_connection = Registry::get('db');
    }
    
    public function getById($id)
    {
        $sql    = 'select * from ' . $this->_name . ' where id = ?';
        
        $sth    = $this->_connection->prepare($sql);
        
        $sth->execute(array($id));
        $result = $sth->fetchAll(PDO::FETCH_OBJ);
        
        return $result;
    }
}

