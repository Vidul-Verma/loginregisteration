<?php


class DB{

    protected $dbhost = "localhost";
    protected $dbuser = "afivvcic_vidul";
    protected $dbpass = "passwordvidul";
    protected $dbname = "afivvcic_login_system";

    private $pdo;
    public function __construct(){

        $pdo_str = 'mysql:host='.$this->dbhost.';dbname='.$this->dbname;

        $pdo = new PDO($pdo_str,$this->dbuser,$this->dbpass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $this->pdo = $pdo;
    }

    public function query($query,$params = array()){
        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute($params);

        //IF SELECT STATEMENT RETURNS DATA
        if(explode(' ',$query)[0] == 'SELECT'){
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }

        //ELSE RETURN BOOL
        return $result;
    }
}
