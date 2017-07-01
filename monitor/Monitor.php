<?php
    namespace second\GetData;
    
    class Monitor{
	   private $top;
	   private $df;
	   private $mysql;
	   
	   function __construct(){
	       $this->setTop();
	       $this->setDf();
	       $this->setMysql();
	   }
	   
	   
	   /**
	    * 将变量$top赋值
	    */
	   public function setTop()
	   {
		   exec('/usr/bin/top -bn 1 2>&1', $res, $code);
	       //处理top命令第一行数据
	       $data = array();
	       $tmp  = explode(",", $res[0]);
	       $top['users']  = trim(trim($tmp[2],'users')) ;   //用户连接数量
	       $top['loadaverag'] = trim(trim($tmp[3],' load average:'));   //系统负载平均值
	       $data['top'] = $top;
	       
	       for ($i=1; $i<5; $i++){
	           $lineName = explode(":", $res[$i]);        //提取这一行的名称
	           $lineData  = explode(",", $lineName[1]);     //将这一行数据以逗号拆分成数组
	       
	           $linetmp  = array();
	           foreach ($lineData as $value){
	           				//为了第三行分割字符串，将%转为空格
	           				$changeValue = trim(str_replace('%', ' ', $value))  ;
	           				$changeValue =str_replace('39;49m','',$changeValue);  //编码原因，39；49m会影响数据
	           				$detail = explode(' ',$changeValue);   //以空格拆分字符串，获得具体数据的名称和值
	           				$linetmp[$detail[1]] = $detail[0];
	           }
	           $lineName[0] = str_replace('(', '', $lineName[0]);
	           $lineName[0] = str_replace(')', '', $lineName[0]);
	           $data[$lineName[0]] = $linetmp;
	       }
	       $this->top = $data;
	   }
	   
	   /**
	    * 获取变量$top的值
	    */
	   public function getTop()
	   {
		   return $this->top;
	   }
	   
	   /**
	    * 将变量$top赋值
	    */
	   public function setDf()
	   {
	      exec('df 2>&1', $res, $code);
	      $line = array();
	      foreach($res as $value)
	      {
	          $lineTmp = explode(' ',$value);
	          $line[] = array_merge(array_filter($lineTmp));
	      }
	      unset($line[0]);
	      $this->df = array_merge($line) ;
	   }
	   

	   /**
	    * 将kb转为gb
	    * @param  int $data kb容量
	    * @return int $gb    gb容量  
	    */
	   private function _k2g($data){
	   		$mb = floor(($data/1024) * 100)/100 ; 
	   		$gb = floor(($mb/1024) * 100)/100 ;
	   		return $gb;
	   }

	   /**
	    * 处理硬盘数据的函数，将所有KG转为GB
	    * @param  array $data   处理前数据
	    * @return array $data   处理后的数据
	    */
	   private function _dealDf($data){
	   		foreach ($data as $key => &$value) {
	   			$value[1] = $this->_k2g($value[1]) ;
	   			$value[2] = $this->_k2g($value[2]) ;
	   			$value[3] = $this->_k2g($value[3]) ;
	   		}
	   		return $data;
	   }

	   /**
	    * 获取变量$df的值
	    */
	  public function getDf()
	  {
	      return $this->_dealDf($this->df) ;
	  }
	  
	  /**
	   * 将变量$top赋值
	   */
	  public function setMysql()
	  {
	      exec(' mysql -u root -e status 2>&1', $res, $code);
	      preg_match('/Threads:\s(\d)*/',$res[20],$match);
	      $this->mysql = $match[1];
	  }
	  
	  /**
	   * 获取变量$mysql的值
	   */
	  public function getMysql()
	  {
	      return $this->mysql;
	  }
	  
    }
  
?>
