<?php

abstract class MyCurd
{
    abstract public function connect($arr);                     //连接数据库
    abstract public function add($arr);                         //添加数据
    abstract public function update($arr,$id);                  //更新数据
    abstract public function all();                             //获取所有数据
    abstract public function find($id);                         //根据id查找
    abstract public function destroy($id);                      //根据id删除
    abstract public function where($fileld,$value,$symbol);     //select * from 表 where $fileld $symbol $value
    abstract public function query($query);                     //自定义查询语句
}