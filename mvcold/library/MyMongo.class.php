<?php
require 'Mycurd.class.php';

class MyMongo extends MyCurd
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
            $mongo = new \MongoClient($host);
            $db = $mongo->$dbname;   //选择数据库
            $table = $this->_table;
            $this->_dbHandle= $db->$table;
        } catch (PDOException $e) {
            exit('错误: ' . $e->getMessage());
        }
    }
    
    //根据ID查找数据
    public function find($id)
    {
        $query = array(
            "_id" => $this->changeId2Obj($id)    //将id转为mongo对象
        );
        $cursor= $this->_dbHandle->find($query);
        
        //将结果转成数组
        $res = $this->object2Arr($cursor);
        return $res[0];
        
    }
    
    //将mongo对象转为数组，并将_id对象提取为字符串
    private function object2Arr($cursor)
    {
        $result = array();
        foreach ($cursor as $value) {
            $tmp = array();
            foreach ($value as $key=>$v) {
                if ($key =='_id') {
                    $tmp['id'] = $v->{'$id'};
                    continue;
                }
                $tmp["$key"] = $v;
            }
            $result[] = $tmp;
            
        }
        return $result;
    }
    
    //将字符串的id转为mongo对象
    private function changeId2Obj($id)
    {
        return new \MongoId("$id");
    }
    
    //根据ID删除数据
    public function destroy($id)
    {
        try {
            $query = array(
                "_id" => $this->changeId2Obj($id)    //将id转为mongo对象
            );
            $cursor= $this->_dbHandle->remove($query);
            //返回受影响行数
            return $cursor['n'];
        } catch (Exception $e) {
            $ret = array(
                'n' => 0,
                'msg' => $e->getMessage()
            );
            return $ret;
        }

    }
    
    //获取数据表中所有数据
    public function all()
    {   
        $cursor= $this->_dbHandle->find();
        $res = $this->object2Arr($cursor);
        return $res;
    }
    
    //根据id更新数据
    public function update($arr,$id)
    {
        try {
            $where = array('_id' => $this->changeId2Obj($id));
            $res = $this->_dbHandle->update($where,array('$set' => $arr));
            return $res['n'];
        }catch (Exception $e) {
            $ret = array(
                'n' => 0,
                'msg' => $e->getMessage()
            );
            return $ret;
        }
    }
      
    //插入数据
    public function add($arr)
    {
        try {
            $res = $this->_dbHandle->insert($arr);
            return $res;   //if $res['ok']  则说明插入成功
        } catch (Exception $e) {
            return $e->getMessage();
        }
        
    }
     
    //where查询，只能一个条件
    public function where($fileld, $value, $symbol)
    {
        if ($symbol != '=') {
            $query = array(
                $fileld => array($symbol => $value)
            );
        } else {
            $query = array(
                $fileld => $value
            );
        }
        
        $cursor= $this->_dbHandle->find($query);
        $res = $this->object2Arr($cursor);
        return $res;
        
    }
    
    //自定义查询语句
    public function query($query)
    {
        $cursor= $this->_dbHandle->find($query);
        $res = $this->object2Arr($cursor);
        return $res;
    }
    
}