<?php
    header("Content-type:text/html; Charset=utf-8");    
    // 记录开始时间
    // $starttime = getMicrotime();

    $keywords = $_GET['keywords'];
    //     $keywords = '指数';
    $xml = new XmlTest('stocks.xml',$keywords);
    $data = $xml->getData();
    
//     var_dump($res);
    $res = array(
        'error' => 0,
        'data'  => $data
        );
    echo json_encode($res);
    return ;
        
    
    // 记录结束时间
    // $endtime = getMicrotime();
    // echo '运行时间:'.(float)(($endtime-$starttime)*1000).'ms<br>';
    // var_dump($res);
    
    /**
     * 获取microtime
     * @return float
     */
    function getMicrotime(){
        list($usec, $sec) = explode(' ', microtime());
        return (float)$usec + (float)$sec;
    }
    
    /**
     * 使用simpleXml方式解析xml文档
     * @param unknown $fileName
     */
    
    class XmlTest{
        private $fielName ;
        private $xml2array ;
        private $searchResult;
        private $keywords;
        
        function __construct($filename,$keywords){
            $this->fielName = $filename;
            $this->keywords = $keywords;
        }
        
        /**
         * 获取解析好的xml对象，格式为数组
         */
        public function getData(){
            $this->simpleXml();
            $this->_searchKeywords();
            // $this->xmlReader();
            // $this->Document();
            return $this->searchResult;
        }
        
        private function _searchKeywords(){
            $res = array();
            foreach($this->xml2array as $v ){
                foreach ($v['value'] as $value){
                    if (strstr( $value ,  $this->keywords)){
                        $value .= "|" . $v['name'];
                        array_push($res, $value);
                    }
                }
            }
            $this->searchResult = $res;
        }
        
        /**
         * 使用simple方式解析XML文档
         */
        public function simpleXml(){
            $xml  = simplexml_load_file($this->fielName);
            $data = array();
            foreach ($xml as $key => $value){
                $attr   = $value->Record->attributes();
                $data[] = array(
                    'name'   => (string)$attr['Name'],
                    'market' => (string)$attr['Market'],
                    'value'   => (array)$value->Record->PY
                );
            }
            $this->xml2array =  $data;
        }
        
        /**
         * xmlReader 解析xml
         *
         */
        public function xmlReader(){
           $xml = new XMLReader();
           $xml->open($this->fielName);
           
           $oldarray = $this->_xmlReader2assoc($xml);
           $data     = array();
           foreach ($oldarray[0]['value'] as $value){
//                var_dump($value['value'][0]);  //Record
                
               $pyId = array();
               foreach($value['value'][0]['value'] as $v){
                   $pyId[] =  $v['value'];
               }
               $data[] = array(
                   'name'   => $value['value'][0]['attributes']['Name'],
                   'market' => $value['value'][0]['attributes']['Market'],
                   'value'  => $pyId
               );
           }
           $this->xml2array = $data;
           
           $xml->close();
                         
        }
        
        /**
         * xmlreader递归函数
         * @param xml $xml
         * @return mix $tree
         */
        private function _xmlReader2assoc($xml){
            $tree = null;
            while($xml->read()){
                switch ($xml->nodeType) {
                    case XMLReader::END_ELEMENT: return $tree;
                    case XMLReader::ELEMENT:
                        $node = array('tag' => $xml->name, 'value' => $xml->isEmptyElement ? '' : $this->_xmlReader2assoc($xml));   //递归
                        if($xml->hasAttributes){
                            while($xml->moveToNextAttribute()){
                                $node['attributes'][$xml->name] = $xml->value;
                            }
                        }
                        $tree[] = $node;
                        break;
                        case XMLReader::TEXT:      //执行下一个case
                        case XMLReader::CDATA:
                            $tree .= $xml->value;
                }
            }
            return $tree;
        }
        
        
        public function Document(){
            $xml = new DOMDocument();
            $xml->load($this->fielName);
            // 获取所有的Record标签
            $records = $xml->getElementsByTagName("Record");
            $data = array();
            foreach($records as $record){
                $pys = $record->getElementsByTagName("PY");
                $pyValue = array();
                foreach ($pys as $py){
                    $pyValue[] = $py->nodeValue;
                }
                $data[] = array(
                    'market' => $record->attributes->item(0)->nodeValue ,
                    'name'   => $record->attributes->item(1)->nodeValue,
                    'value'  => $pyValue
            
                );
            }
            $this->xml2array = $data;
        }
        
    }
    

?>