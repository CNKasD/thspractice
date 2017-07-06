<?php
// require 'CurdFactory.class.php';
class Model
{
    protected $_model;
    protected $_table;
    public static $dbConfig = [];
    
    public function __construct()
    {
        //查看表名
        if (!$this->_table) {
            // 获取模型类名称
            $modelName= get_class($this);
            // 删除类名最后的 Model 字符
            $modelName= substr($modelName, 0, -5);
            // 数据表名比表名多个s
            $this->_table = strtolower($modelName) . 's';
        }
        // 连接数据库
        $this->_model =  CurdFactory::createCurd(self::$dbConfig['dbtype'], $this->_table);
        $this->_model->connect(self::$dbConfig);
    }
    
    //根据id查询
    public function find($id)
    {
        return $this->_model->find($id);
    }
    
    //根据ID删除数据
    public function destroy($id)
    {
        return $this->_model->destroy($id);
    }
    
    //获取数据表中所有数据
    public function all()
    {
        return $this->_model->all();
    }
    
    //根据id更新数据
    public function update($arr, $id)
    {
        return $this->_model->update($arr, $id);
    }
    
    //插入数据
    public function add($arr)
    {
        return $this->_model->add($arr);
    }
    
    //where查询，只能一个条件
    public function where($fileld, $value, $symbol='=')
    {
        return $this->_model->where($fileld, $value, $symbol);
    }
    
    //自定义查询语句
    public function query($query)
    {
        return $this->_model->query($query);
    }
    
}