<?php
	header("Content-type:text/html;charset=utf-8");
	
	$name = $_POST['name'];

	// $name = 'mongo';

	$data = array(
		'data'  => searchProcess($name),
		'error' => 0
	);

	echo json_encode($data);
	return ;

	/**
	 * 根据进程名称搜索相关信息
	 * @param  string $name 进程名称
	 * @return array  $data 返回的相关信息
	 */
	function searchProcess($name)
	{
		$shell = "ps -ef | grep ". $name ." | grep -v 'grep' |wc -l| awk '{print $1}'";  //ps -ef e显示所有进程f显示UID,PPIP,C与STIME栏位,通过管道成为grep $name的输入，进行筛选，grep -v 用来排除 grep进程，wc -l 用来统计行数，awk用于控制显示的列数，$1显示第一列$1"\t"$2 可以显示多列
		$number = exec($shell);

		$shell = "ps -ef | grep ". $name ." | grep -v 'grep' ";  //|awk '{print $1\"\#\"$2\"\#\"$8\"\#\"$9\"\#\"$10\"\#\"$11}'
		exec($shell,$res,$code);

		$detail = array();
		for($i=0 ; $i<count($res) ; $i++){
			$tmp = explode(' ', $res[$i]);
			foreach ($tmp as $key => &$value) {
				if ($value==null) {
					unset($tmp[$key]);
				}
			}		
			$detail[] = array_merge($tmp);   //重新排序				
			array_splice($detail[$i], 2,5);  //array_splice不需要重新排序
			$cmd = '';
			//将可能会有空格的CMD连接起来
			for($j = 2; $j<count($detail[$i]) ; $j++){      
				$cmd .= " " . $detail[$i][$j];
			}
			array_splice($detail[$i], 2);
			$detail[$i][2] = $cmd;
		}
		$data = array(
			'number' => $number,
			'detail'   => $detail
		);

		return $data;	
   }
?>
