<!doctype html>

  <head>
   <html lang="zh-cn">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <style type="text/css">
    .center
    {
    	text.align:center;
    }
    .center-div
    {
    	width:90%;
    	margin: 0 auto;
    }
	</style>

    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <script src="./js/jquery-3.5.1.min.js"></script>
    <script src="./js/jquery-3.5.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="./js/bootstrap.min.js"></script>

    <title>幻域-文件暂存中心</title>
  </head>

  <body>

  	

	<h1 align="center" class="display-4">
		幻 域
		<small class="text-muted">简单的文件暂存平台</small>
	</h1>

	<nav class="navbar navbar-light bg-light">
	<a class="navbar-brand">
    <img src="./css/theme/3.jpg" width="30" height="30" class="d-inline-block align-top" alt="">
    残影『BSO』鸽子窝
	</a>
	</nav>
	<div class="shadow-lg p-3 mb-5 bg-white rounded">
		欢迎使用！这是一个简单的文件存储器，经过几波周折之后终于开发出来啦！嗯...bug可能会有点多......请多多使用吧！
	</div>

 	<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#home" role="tab" aria-controls="pills-home" aria-selected="true">主页</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#save" role="tab" aria-controls="pills-profile" aria-selected="false">存入</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#read" role="tab" aria-controls="pills-contact" aria-selected="false">读取</a>
  </li>
</ul>
	


	<div class="tab-content" id="pills-tabContent">
	<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="pills-home-tab">
		
			<div class="jumbotron jumbotron-fluid">
  			<div class="container">
    		<h1 class="display-4">公告</h1>
    		<p class="lead">1.文件一般都是单次下载机会滴...嗯，取出文件后咱服务器里面就会自动消失的嗯..
    		<br>
    		2.反馈请发送信息到我的邮箱：1946831552@qq.com
    		</p>
  			</div>
			</div>
		
	</div>
	<div class="tab-pane fade" id="save" role="tabpanel" aria-labelledby="pills-profile-tab">
  		<div class="center">
			<div class="center-div">

				<form action="index.php" method="post" enctype="multipart/form-data">
				<div class="form-group">
				<label for="exampleFormControlFile1">上传想要上传的文件吧</label>
				<input type="file" class="form-control-file" id="files" name="files">
				</div>

				<div class="form-group">
				<label for="exampleInputEmail1">备注信息</label>
				<input type="text" class="form-control" id="ps" name="ps">
				<small id="emailHelp" class="form-text text-muted">如果不是需要上传文件只是共享一些文字的话，只需要写备注就好啦</small>
				</div>
  
				<button type="submit" class="btn btn-primary">上传！</button>
				</form>

				<?php
				$seed = time(); 
				srand($seed);
				$a=rand(0,999999999);

				$file=$_FILES["files"]["name"];
				$ps=$_POST["ps"];
				$tp="tmp/".$a."/";

				if($file||$ps){
					if (mkdir($tp,0777)) {
						move_uploaded_file($_FILES["files"]["tmp_name"],$tp.$_FILES["files"]["name"]);
						file_put_contents($tp."ps.txt",$ps);
						$patha = $tp."ps.txt";
						$pathb = $tp.$file;
						$zipfile = "./upload/".$a.".zip";

						

						$zip = new ZipArchive();
						$zip->open($zipfile,ZipArchive::CREATE);
						$zip->addFile($patha,basename($patha));
						$zip->addFile($pathb,basename($pathb));
						$zip->close();

						echo "<br>嗯嗯...这个是你的存放码，请收好哦~"."<br>";
						echo $a;
						unlink($patha);
						unlink($pathb);
					}
				}
				?>

				


			</div>
		</div>
	</div>
	<div class="tab-pane fade" id="read" role="tabpanel" aria-labelledby="pills-contact-tab">
  		<div class="center">
			<div class="center-div">

				<form action="index.php" method="post">
				<div class="form-group">
				<label for="exampleInputEmail1">你的存取码</label>
				<input type="text" class="form-control" id="pws" name="pws">
				</div>
  
				<button type="submit" class="btn btn-primary">焊接！</button>
				</form>

				<?php
                $pws=$_POST["pws"];
                $pathc="./upload/".$pws.".zip";
				if ($pws) {
                    
                    
                    echo $file_size;
                    header('Content-Type:text/html;charset=utf-8');
                    header('Content-disposition:attachment;filename='.$pws.".zip");
                    $filesize=filesize($pathc);
                    readfile($pathc);
                    header('Content-length:'.$filesize);

                    $buffer=1024;
                    $file_count=0;
                    $fp=fopen($path,"r");
                    while(!feof($fp) && $file_count<$file_size){
                        $file_con=fread($fp,$buffer);
                        $file_count+=$buffer;
                        echo $file_con;
                    }
                    fclose($fp);

                    if($file_count >= $file_size){
                        unlink($pathc);
                        echo("下载完成咯！");
                    }
                    
                }
               
                ?>
				

			</div>
		</div>
	</div>
</div>















  </body>
</html>