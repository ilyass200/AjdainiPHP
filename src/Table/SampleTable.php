<?php

namespace AjdainiPHP\Table;
use AjdainiPHP\Entity\SampleEntity;
use AjdainiPHP\Core\ORM\Table\Table;
use AjdainiPHP\Core\Database\Database;

class SampleTable extends Table
{
    function __construct()
    {
        parent::__construct();
        $this->setPrimaryKey('id_spl');  
    }

    public function getAllSamples()
    {
        $db =  new Database();
        $query = $db->request('SELECT * FROM sample',NULL,SampleEntity::class);
        return $query->fetchAll();
    }
}

?>