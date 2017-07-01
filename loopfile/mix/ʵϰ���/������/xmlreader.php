<?php
            $xml = new XMLReader();
            $url = 'stocks.xml';
            $xml->open($url);
        //     $xml->XML($xmlData);
            $assoc = xml2assoc($xml);
            $xml->close();
            var_dump($assoc);
            
            function xml2assoc($xml) {
                $tree = null;
                while($xml->read())
                        switch ($xml->nodeType) {
                            case XMLReader::END_ELEMENT: return $tree;
                            case XMLReader::ELEMENT:
                                $node = array('tag' => $xml->name, 'value' => $xml->isEmptyElement ? '' : xml2assoc($xml));   //递归
                                if($xml->hasAttributes)
                                        while($xml->moveToNextAttribute())
                                                $node['attributes'][$xml->name] = $xml->value;
                                        $tree[] = $node;
                                        break;
                                    case XMLReader::TEXT:      //执行下一个case
                                    case XMLReader::CDATA:
                                        $tree .= $xml->value;
                        }   
                            return $tree;
            }

?>