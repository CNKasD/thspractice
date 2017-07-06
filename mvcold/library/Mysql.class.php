<?php
require 'Mycurd.class.php';

class Mysql extends MyCurd
{
    protected $_dbHandle;
    protected $_filter='';
    private $_table;
    
    function __construct($table)
    {
        $this->_table = $table;
    }
    
    public function connect($params)
    {
        extract($params);
        try {
            $dsn = sprintf("mysql:host=%s;dbname=%s;charset=utf8", $host, $dbname);
            $option = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC);
            $this->_dbHandle = new \PDO($dsn, $username, $password, $option);
        } catch (PDOException $e) {
            exit('错误: ' . $e->getMessage());
        }
    }
    
    //根据ID查找数据
    public function find($id)
    {
        $sql = sprintf("select * from `%s` where `id` = '%s'", $this->_table, $id);
        $sth = $this->_dbHandle->prepare($sql);
        $sth->execute();
        return $sth->fetch();
    }
    
    //根据ID删除数据
    public function destroy($id)
    {
        $sql = sprintf("delete from `%s` where `id` = '%s'", $this->_table, $id);
        $sth = $this->_dbHandle->prepare($sql);
        $sth->execute();
        return $sth->rowCount();
    }
    
    //获取数据表中所有数据
    public function all()
    {
        $sql = sprintf("select * from `%s` ", $this->_table);
        $sth = $this->_dbHandle->prepare($sql);
        $sth->execute();
        return $sth->fetchAll();
    }
    
    //根据id更新数据
    public function update($arr,$id)
    {
        $sql = sprintf("update `%s` set %s where `id` = '%s'", $this->_table, $this->formatUpdate($arr), $id);
        $sth = $this->_dbHandle->prepare($sql);
        $sth->execute();
        return $sth->rowCount();
    }
    
    // 将数组转换成更新格式的sql语句
    private function formatUpdate($data)
    {
        $fields = array();
        foreach ($data as $key => $value) {
            $fields[] = sprintf("`%s` = '%s'", $key, $value);
        }
        
        return implode(',', $fields);
    }
    
    //插入数据
    public function add($arr)
    {
        $sql = sprintf("insert into `%s` %s", $this->_table, $this->formatInsert($arr));
        $sth = $this->_dbHandle->prepare($sql);
        $sth->execute();
        return $sth->rowCount();
    }
    
    // 将数组转换成插入格式的sql语句
    private function formatInsert($data)
    {
        $fields = array();
        $values = array();
        foreach ($data as $key => $value) {
            $fields[] = sprintf("`%s`", $key);
            $values[] = sprintf("'%s'", $value);
        }
        
        $field = implode(',', $fields);
        $value = implode(',', $values);
        
        return sprintf("(%s) values (%s)", $field, $value);
    }
    
    //where查询，只能一个条件
    public function where($fileld, $value, $symbol)
    {   
        if (gettype($value) == 'integer' || gettype($value) == 'double') {
            $sql = "select * from {$this->_table} where {$fileld} {$symbol} {$value}" ;
        } else {
            $sql = "select * from {$this->_table} where {$fileld} {$symbol} '{$value}'" ;
        }
        
        $sth = $this->_dbHandle->prepare($sql);
        $sth->execute();
        return $sth->fetchAll();
    }
    
    //自定义查询语句
    public function query($query)
    {
        $sth = $this->_dbHandle->prepare($query);
        $sth->execute();
        return $sth->fetchAll();
    }

}