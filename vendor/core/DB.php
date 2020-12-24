<?php

namespace vendor\core;

use Exception;
use PDO;
use PDOException;

class DB
{
    public $isConnect; // Проверяет на соединение с БД
    
    protected $db;

    public function __construct( $dbname, $user = "gont2", $password = "O@j#gAOqMrx*",
     $host = "localhost", $type = "mysql", $charset = "utf8", $options = [] ) // Этот метод срабатывает автоматически, для подключения к БД
    {
        $this -> isConnect = true;
        try {
            $this -> db = new PDO( "{$type}:host={$host};dbname={$dbname};charset={$charset};", $user, $password, $options );
            $this -> db -> setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
            $this -> db -> setAttribute( PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC );
        } catch( PDOException $e ) {
            throw new Exception( $e -> getMessage() ); 
        }
    }

    public function Disconnect() // Этот метод разрывает соединение с БД
    {
        $this -> db = NULL;
        $this -> isConnect = false;
    }
    
    public function insertRow( $query, $params = [] ) // Данный метод вставляет новую запись в таблицу БД
    {
        try {
            $insert = $this -> db -> prepare( $query );
            $insert -> execute( $params );
            return true;
        } catch( PDOException $e )
        {
            throw new Exception( $e -> getMessage() );
        }
    }
    
    public function getRow( $query, $params = [] ) // Данный метод получает одну строку из таблицы
    {
        try {
            $get = $this -> db -> prepare( $query );
            $get -> execute( $params );
            return $get -> fetch();
        } catch( PDOException $e )
        {
            throw new Exception( $e -> getMessage() );
        }
    }
    
    public function getRows( $query, $params = [] ) // Данный метод получает более одной строки
    {
        try {
            $get = $this -> db -> prepare( $query );
            $get -> execute( $params );
            return $get -> fetchAll();
        } catch( PDOException $e )
        {
            throw new Exception( $e -> getMessage() );
        }
    }
    
    public function updateRow( $query, $params = [] ) // Данный метод обновляет информацию в таблице
    {
        $this -> insertRow( $query, $params );
    }
    
    public function deleteRow($query,$params=[]) // Данный метод удаляет строку из таблицы
    {
        $this -> insertRow( $query, $params );
    }

    public function lastInsertId()
    {
        return $this->db->lastInsertId();
    }
}