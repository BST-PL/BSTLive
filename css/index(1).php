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

  	

	
  	<div class="pos-f-t shadow">
  	<div class="collapse" id="timeStatistics">
    <div class="bg-dark p-4">

    <h4 class="text-white">统计数据</h4>
    <span class="text-muted">
    	<?php
    	$time1=file_get_contents("./log/time.log");
    	$time2=file_get_contents("./log/work.log");
    	echo "浏览次数：".$time1."<br>"."已提取次数：".$time2;
    	?>
    </span>
    </div>
  	</div>
	<nav class="navbar navbar-dark bg-dark">
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#timeStatistics" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    
    </button>
	
    <a class="navbar-brand">
    BST World
  	</a>
  	
	</nav>
	</div>



	<br>
 	<ul class="nav nav-pills mb-3 justify-content-center" role="tablist">
	<li class="nav-item">
    <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#home" role="tab" aria-controls="pills-home" aria-selected="true">主页</a>
  	</li>
	<li class="nav-item">
    <a class="nav-link" id="pills-home-tab" data-toggle="pill" href="#save" role="tab" aria-controls="pills-home" aria-selected="true">存入</a>
  	</li>
  	<li class="nav-item">
    <a class="nav-link" id="pills-home-tab" data-toggle="pill" href="#read" role="tab" aria-controls="pills-home" aria-selected="true">读取</a>
 	</li>
	</ul>
	


	<div class="tab-content">
	<div class="tab-pane active" id="home">
		
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




	<div class="tab-pane" id="save">
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
				

				$file=$_FILES["files"]["name"];
				$ps=$_POST["ps"];
				$seed = time(); 
				srand($seed);
				$a=rand(0,999999999);
				$tp="tmp/".$a."/";
				$alen=strval($a);
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
						if ($file) {
							$zip->addFile($pathb,basename($pathb));
						}
						
						$zip->close();

						
						
						unlink($patha);
						if ($file) {
							unlink($pathb);
						}
						
						rmdir($tp);
						echo "<br>";
						echo "<div class='alert alert-primary' role='alert'>";
						echo "这是你的存放码哦，请收好啦！".$a;
						echo "</div>";
						echo '<script type="text/javascript">'."\n";
						echo "alert('".$alen."\n嗯嗯...这个是您的存取码，欢迎下次使用，如果在使用的时候有什么问题或者建议，欢迎反馈到1946831552@qq.com');"."\n";
						
						echo '</script>'."\n";

					}
						
					}
				?>
			





			</div>
		</div>
	</div>
	<div class="tab-pane" id="read">
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
                $pathc="/upload/".$pws.".zip";
				if ($pws) {
                    
                    
                    echo $file_size;
                    Header("Location: ".$pathc);
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
                    	
                    	$work=file_get_contents("./log/work.log");
						$worktime=(int)$work+1;
						file_put_contents("./log/work.log",$worktime);
						unlink($pathc);
						//计算使用人数，并写入log
                    	
                    }
                    
                }
               
                ?>
				

			</div>
		</div>
	</div>
</div>
<?php
//浏览次数记录
$time=file_get_contents("./log/time.log");
$times=(int)$time+1;

file_put_contents("./log/time.log",$times);
//打开log文件夹下面的time.log就可以看到访问多少次啦(不过只是简单的记录了一下界面加载过几次而已emm真实性感人嗯...)
?>




  </body>
</html>