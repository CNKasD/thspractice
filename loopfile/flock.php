<?php
$file = "mix/del/requester.js";
$fp = fopen($file , 'a');    
if(flock($fp , LOCK_EX)){    
     fwrite($fp , "abcn");    
     sleep(10);    
     fwrite($fp , "123n");    
    flock($fp , LOCK_UN);    
}    
fclose($fp);

?>
