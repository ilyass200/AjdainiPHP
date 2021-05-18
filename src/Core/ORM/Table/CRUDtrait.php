<?php

/*
 * This file is part of the AjdainiPHP Framework.
 *
 * (c) Ajdaini Ilyass <ajdainibac@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
*/
namespace AjdainiPHP\Core\ORM\Table;
use AjdainiPHP\Core\Entity\Entity;

trait CRUDtrait
{

    protected $query = '';
    public function save(Entity $entity)
    {
        $data = (array) get_object_vars($entity);
        $attributes = '';
        $values_names = '';
        $connection = $this->getConnection();
        $table_name = $this->getTableName();
        $values = [];

        foreach($data as $key => $value)
        {
            $values[$key] = $value;
            if(array_key_last($data) == $key)
            {
                $attributes = $attributes."$table_name.$key";
                $values_names = $values_names.':'.$key;
                break;
            }
            $attributes = $attributes."$table_name.$key,";
            $values_names = $values_names.':'."$key,";
            

        }
      $sql = "SELECT * FROM {$table_name}";
      $query = $connection->query($sql);
      var_dump($query->fetchAll());
      echo "ok";
        $sql = "INSERT INTO $table_name($attributes) VALUES($values_names)";
        $query = $connection->prepare($sql);
        $query->execute($values);
        $query->closeCursor();

        return $query ? true : false;
    }

    public function delete(int $id)
    {
      $connection = $this->getConnection();  
      $table = $this->getTableName();
      $db = $this->db;
      $primaryKey = $this->primary_key;

      $sql = 
      "
      DELETE FROM $table
      WHERE $table.$primaryKey = :id
      ";

      $query = $connection->prepare($sql);
      $query->bindParam(':id',$id);
      $query->execute();
      $query->closeCursor();

      return $query ? true : false;

    }

    public function find(int $id)
    {
      $connection = $this->getConnection();  
      $table = $this->getTableName();
      $primaryKey = $this->primary_key;

      $column_names_query = $this->getConnection()->prepare("SHOW COLUMNS FROM $table");
      $column_names_query->execute();
      $column_names = $column_names_query->fetchAll(\PDO::FETCH_COLUMN);
      $column_names_query->closeCursor();
      $columns = "";

      foreach($column_names as $column_name)
      {
        if(end($column_names) === $column_name)
        {
          $columns = $columns."$table.$column_name";
          break;
        }
    
        $columns = $columns."$table.$column_name,";
        
      }
      
      $query = $connection->prepare("
      SELECT $columns FROM $table 
      WHERE $primaryKey = :id");
      $query->bindParam(':id',$id);
      $query->execute();
      $query->setFetchMode(\PDO::FETCH_CLASS,$this->getEntityNamespace());

      return ($query->rowCount() > 0) ? $query->fetch() : NULL;

    }

    public function update(Entity $entity)
    {
      $connection = $this->getConnection();  
      $table = $this->getTableName();
      $db = $this->db;
      $primaryKey = $this->primary_key;
      $primaryKeyValue = $entity->$primaryKey;
 
      $find_old_entity = $this->find($primaryKeyValue);
      $data_updated = [];
      $columns = '';
      $values = [];

      $entity_to_array = (array) $entity;
      

      foreach($find_old_entity as $key => $value)
      {
        ($value != $entity->$key) ? $data_updated[] = ['key'=>$key,'value'=>$entity->$key] : '';
      }
      
      foreach($data_updated as $data)
      {
        if(end($data_updated)['key'] == $data['key'])
        {
          $columns = $columns.$data['key'].' = ?';
          $values[] = $data['value'];
          break;
        }
        $values[] = $data['value'];
        $columns = $columns.$data['key'].'= ?,';
      }

      $values[] = $entity->$primaryKey;

      if(count($values) > 1)
      {
        $query = $connection->prepare("UPDATE $table SET $columns WHERE $primaryKey = ?");
        $query->execute($values);
        $query->closeCursor();
        return true;
      }

        return false;      
      
    }


}

?>