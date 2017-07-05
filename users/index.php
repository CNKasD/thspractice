<?php 
session_start();
if (empty($_SESSION['account'])) {
	$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    $_SESSION['url'] = $url;
    header('Location:login.html');
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<title>用户权限</title>

</style>
</head>
<body>	
<div class="container">
	<div class="row clearfix">
		<div class="col-md-12 column">
			<nav class="navbar navbar-default" role="navigation">
				<div class="navbar-header">
					 <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button> 	<button class="btn btn-primary" onclick="javascript:$('#myModal').modal('toggle');">添加用户</button><button class="btn btn-success" onclick="logout()">退出</button>
				</div>
				
				
			<div class="row clearfix">
				<div class="col-md-12 column">
					<table class="table" id="test">
						<thead>
							<tr>
								<th>
									名称
								</th>
								<th>
									级别
								</th>
								<th>
									用户名
								</th>
								<th>
									操作
								</th>
							</tr>
						</thead>
						<tbody>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
	

		<!-- 添加用户的模态框 -->
		<div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h4 class="modal-title" id="myModalLabel">添加下一级用户</h4>
					</div>
					<div class="modal-body">
						<form class="form-inline">
						    <div class="form-group">
						    	<label for="stuid">账号</label>
						    	<input type="text" class="form-control" id="account" placeholder="登录账号">
						  	</div>
						  	<div class="form-group">
						    	<label for="name">密码</label>
						    	<input type="text" class="form-control" id="pwd" placeholder="登录密码">
						  	</div>
  						  	<div class="form-group">
						    	<label for="subject">用户名</label>
						    	<input type="text" class="form-control" id="username" placeholder="用户名称">
						  	</div>
						  <button type="button" class="btn btn-default" id="insertsubmit" onclick="insert()">提交</button>
						</form>
					</div>
					<div class="modal-footer">
						 <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button> 
					</div>
				</div>
			</div>
		</div>

<!-- 		<div id="content"> -->
<!-- 			<table class="table table-striped table-bordered" id="table"></table> -->

<!-- 		</div> -->
	</div>
</div>

<script type="text/javascript">
	$('document').ready(function(){
		$.ajax({
			type:'POST',
			url:'getlowusers.php',
			dataType:'json',
			success:function(data)
			{	
				if (data.error==0) 
				{	
					window.info =data.data;
// 					console.log(data);
					$('#test tbody').empty();
// 					$('#test').append('<thead><tr><th>名称</th><th>级别</th><th>用户名</th></tr></thead>');
					for (var i = 0; i < info.length; i++) {
						console.log(info[i]);
						switch(i%2){
						case 0:
							status = 'success';
							break;
						case 1:
							status = 'info';
						}
						$("#test").append('<tr class="'+status+'"><td>'+info[i].username+'</td><td>'+info[i].level+'</td><td>'+info[i].account+'</td><td><button type="button" class="btn btn-danger btn-xs" onclick="del(' +i+ ')">删除</button></td></tr>');
					}
// 					alert('添加成功')
// 					$('#myModal').modal('hide');

				}
				
			},
			error:function(XMLHttpRequest, textStatus, errorThrown)
			{
					// alert(XMLHttpRequest.status);
  //               alert(XMLHttpRequest.readyState);
  //               alert(textStatus);
			}
		});

		});



	function insert(){
		$.ajax({
			type:'POST',
			url:'insert.php',
			data:{
				'account':$('#account').val(),
				'pwd':$('#pwd').val(),
				'username':$('#username').val()
			},
			dataType:'json',
			success:function(data)
			{	
				if (data.error==0) 
				{	
// 					console.log(data);
					alert('添加成功')
					$('#myModal').modal('hide');
					location.reload();

				}else {

					alert(data.msg);
				}
				
			},
			error:function(XMLHttpRequest, textStatus, errorThrown)
			{
					// alert(XMLHttpRequest.status);
  //               alert(XMLHttpRequest.readyState);
  //               alert(textStatus);
			}
		});
	}

	function logout()
	{
		$.ajax({
			type:'GET',
			url:'logout.php',
			dataType:'json',
		});
		window.location.reload(true);
	}

	function del(id)
	{
		id = info[id].id;
		$.ajax({
			type:'POST',
			url:'del.php',
			data:{
				'id':id,
			},
			dataType:'json',
			success:function(data)
			{	
				if (data.error==0) 
				{	
// 					console.log(data);
					alert('删除成功');
					location.reload();

				}else {

					alert(data.msg);
				}
				
			},
			error:function(XMLHttpRequest, textStatus, errorThrown)
			{
					// alert(XMLHttpRequest.status);
  //               alert(XMLHttpRequest.readyState);
  //               alert(textStatus);
			}
		});
	}



</script>
</body>
</html>