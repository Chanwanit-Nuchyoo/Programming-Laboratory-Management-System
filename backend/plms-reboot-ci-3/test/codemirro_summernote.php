
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>PLMS test</title>	
	<meta name="viewport" content="width=device-width, initial-scale=1">	
	<link rel="stylesheet" href="http://161.246.127.189/20s2ds/assets/bootstrap-3.3.7/css/bootstrap.min.css" >
	<link href="http://161.246.127.189/20s2ds/assets/summernote/summernote.css" rel="stylesheet" >
	<link rel="stylesheet" type="text/css" href="http://161.246.127.189/20s2ds/assets/codemirror-5.22.0/lib/codemirror.css">
	<link rel="stylesheet" type="text/css" href="http://161.246.127.189/20s2ds/assets/codemirror-5.22.0/theme/monokai.css">
	
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="assets/js/jquery.min.js"><\/script>')</script> -->
	<script src="http://161.246.127.189/20s2ds/assets/jquery/jquery-3.1.1.min.js"></script>
	<!-- <script src="http://161.246.4.240/19s1ds/assets/bootstrap-3.3.7/js/bootstrap.min.js"></script> -->
    
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="http://161.246.127.189/20s2ds/assets/bootstrap-3.3.7/js/bootstrap.min.js" ></script>

	<script type="text/javascript" src="http://161.246.127.189/20s2ds/assets/jquery/jquery.tablesorter.min.js"></script>

	

	<style>
		/* Remove the navbar's default margin-bottom and rounded borders */ 
		.navbar {
			margin-bottom: 0;
			border-radius: 0;
		}
    
    /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
    .row.content {height: 450px}
    
    /* Set gray background color and 100% height */
    .sidenav {
      padding-top: 20px;
      background-color: #f1f1f1;
      height: 100%;
    }
    
    /* Set black background color, white text and some padding */
    footer {
      background-color: #555;
      color: white;
      padding: 15px;
    }
    
    /* On small screens, set height to 'auto' for sidenav and grid */
    @media screen and (max-width: 767px) {
      .sidenav {
        height: auto;
        padding: 15px;
      }
      .row.content {height:auto;} 
    }
	#page-content {
		margin-top:95px;
	}
	.kpanel_top {
		position: fix;
	}
	.kpanel_left {
		position: fix;
	}
	.kpanel_body {
		margin-left: 300px;
	}
  </style>
</head>


<body>
<!-- end tag in footer -->
<div class="navbar navbar-fixed-top navbar-default">
  	<div class="container-fulid" >
			
		<a href="http://161.246.4.240/19s1ds/index.php" class="navbar-left"><img height="80px" width="80px" src="http://161.246.4.240/19s1ds/assets/images/logo1.png" style="padding-top:5px;padding-bottom:5px;"></a>

		<div class="navbar-text" style="margin-top:0px;margin-bottom:0px;padding-top:0px;padding-bottom:5px;">
		<h3>Programming Lab Management System</h3>
		<h5>King Mongkut's Institute of Technolygy Ladkrabang</h5>
		</div>
		<div class="nav navbar-nav navbar-right" style="margin-top:15px;margin-right:15px;" >
			<li><a href="http://161.246.4.240/19s1ds/index.php/supervisor/index">Home</a></li>
			<li><a href="http://161.246.4.240/19s1ds/index.php/supervisor/exercise_show" title="Exercise Management">Exercise</a></li>		
			<li><a href="http://161.246.4.240/19s1ds/index.php/supervisor/group_management" title="Group Mangement"> Group Management </a></li>
			<li><a href="http://161.246.4.240/19s1ds/index.php/supervisor/edit_profile_form">Edit profile</a></li>
			<li><a href="#" title="Under Construction . . .">Help</a></li>
			<li><a href="#" title="Under Construction . . .">About</a></li>			
			<li><a href="http://161.246.4.240/19s1ds/index.php/auth/logout" class="btn btn-default btn-lg"> Log out. <span class="glyphicon glyphicon-log-out"></span> </a></li> 
		</div>
      
        <!--/.navbar-collapse -->
    </div>
</div>
<div class="container-fluid"  style="background-color:HoneyDew;">	
	<div class="panel panel-default">
		<div class="panel-body">A Basic Panel</div>
	</div>
</div>
<div class="clear-fix"></div> 
<!-- Page Contents -->
<div class="container-fluid"  style="background-color:HoneyDew ;margin-top:10px;">	
	<!-- row content -->
	<div class="row">

<!-- nav_sideleft -->
<div class="col-lg-2 col-md-2 col-sm-2 sidenav" style="background-color:HoneyDew;">
	<div class="affix" style="background-color:Pink; min-width: 15%; "><!-- -->
		<div class="panel panel-default" style="background-color:AliceBlue;text-align: center; " >
			<img src="http://161.246.4.240/19s1ds/supervisor_data/avatar/image_kanut_59a65158903e4.jpg" style="width:200px;height:250px;margin-left:20px;padding-top:20px">
			
			<div class="row" style="text-align: center; align-content: center;color:Blue;">
				
					<h3 >Supervisor</h3>
				
			</div>
			<div class="row" style="text-align: center;color:Blue;">
				<div>
					<h4>วิศวกรรมคอมพิวเตอร์</h4>
				</div>
			</div>

			<div class="row" style="">
				<div class="col-sm-5" style="text-align: right;">
					<p>username :</p>
				</div>
				<div class="col-sm-7" style="text-align: left;">
					<p>kanut</p>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-5" style="text-align: right;">
					<p>ID :</p>
				</div>
				<div class="col-sm-7" style="text-align: left;">
					<p>900001</p>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-5" style="text-align: right;">
					<p>เพศ</p>
				</div>
				<div class="col-sm-7" style="text-align: left;">
					<p>male</p>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-5" style="text-align: right;">
					<p>ชื่อ</p>
				</div>
				<div class="col-sm-7" style="text-align: left;">
					<p>คณัฐ<p>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-5" style="text-align: right;">
					<p>นามสกุล</p>
				</div>
				<div class="col-sm-7" style="text-align: left;">
					<p>ตังติสานนท์</p>
				</div>			
			</div>

			<div class="row"><a href="http://161.246.4.240/19s1ds/index.php/supervisor/process_show" >Process</a><br/><br/><a href="http://161.246.4.240/19s1ds/index.php/supervisor/student_activity_show/2019-08-05" >Student log</a><br/><br/><a href="http://161.246.4.240/19s1ds/index.php/supervisor/demo_sse" >Demo SSE</a><br/><br/><a href="http://161.246.4.240/19s1ds/index.php/supervisor/proc_open_test" >Proc_open_test</a><br/><br/></div>
			

		</div><!--  -->
	</div>

	
</div>
<!-- nav_sideleft -->
		
		

<!-- nav_body -->
<div class="col-lg-10 col-md-10 col-sm-10 "><div class="container-fluid">
		<div class="container-fluid">
		<div class="row">
			<div class="col-sm-4" style="text-align:center;margin-top:20px;">
				<div class="well">
					<h2 style="color:blue;">Chapter : 1 Level : 2</h2>
				</div>				
			</div>
			
			<div class="col-sm-6">
				<div class="well" style="margin-top:20px;">
					<h3 style="color:blue;"> Lab name : แสดงผลข้อความ แบบย้อนจากหลังมาหน้า</h3>
				</div>
			</div>
			<div class="col-sm-2">
				<div class="well" style="margin-top:20px;">
					<form method="post" action="http://161.246.4.240/19s1ds/index.php/supervisor/exercise_edit" >
						<input type="text" name="exercise_id" value="63" hidden >
						<button type="button submit" class="btn btn-primary"  > Edit 						</button>
					</form>

				</div>
			</div>
		</div>

		
		<div class="row" >
			<div class="container" >
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 >CONTENT : </h3>
					</div>
					<div class="panel-body"  style="backgroud:AliceBlue ;">
						<div id="summernote2" type="textarea"  rows="10" cols="60" readonly><p style="text-align: left;">จงเขียนโปรแกรม<font color="#ff0000"><u> รับข้อความ 1 บรรทัด</u></font> แล้วแสดงผล แบบย้อนกลับดังตัวอย่าง</p><ul><li style="text-align: left;">ข้อความในภาษาซี จะมี character พิเศษ เพื่อแสดงถึงจุดสิ้นสุดข้อความ '\0' หรือ NULL character</li><li style="text-align: left;">การแสดงผลต้องหาตำแหน่งแรกสุดก่อน (ไม่ต้องแสดงผล NULL character)</li><li style="text-align: left;">ตำแหน่งสุดท้าย คือ ตำแหน่ง 0</li></ul><p style="text-align: left;"><br></p><p>#include&lt;stdio.h&gt;</p><p>int main() {</p><p>&nbsp; <span style="white-space:pre">	</span>char str[300];</p><p>&nbsp; <span style="white-space:pre">	</span>int index;</p><p>&nbsp; <span style="white-space:pre">	</span>printf(" *** Reverse string display ***\n");</p><p>&nbsp; <span style="white-space:pre">	</span>printf("Enter a string : ");</p><p>&nbsp; <span style="white-space:pre">	</span>scanf("%[^\n]",str);</p><p>&nbsp; <span style="white-space:pre">	</span>printf("Output : ");</p><p>&nbsp; <span style="white-space:pre">	</span></p><p>&nbsp; &nbsp; &nbsp; printf("%s",str);</p><p>&nbsp; &nbsp; &nbsp;&nbsp;</p><p><span style="white-space:pre">	</span>return 0;</p><p>}</p></div>
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="panel panel-default">
					
					<div class="panel-footer" style="text-align:left;tab-size:4; font-family: Courier;">
												<textarea readonly class="sourcecode_content" cols="120" rows="18" id="sourcecode_content" name="sourcecode_content" >#include<stdio.h>
int main() {
  	char str[300];
  	int index;
  	printf(" *** Reverse string display ***\n");
  	printf("Enter a string : ");
  	scanf("%[^\n]",str);
  	printf("Output : ");
  	for(index = 0; str[index] !='\0';index++);
  	index--;
  	for(index--;index>=0;index--)
      printf("%c",str[index]);
      
	return 0;
}</textarea>
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 style="text-align:center;"> -- output -- </h3>						
					</div>
					<div class="panel-body">
						
						<div>
							<div style="font-family: Courier, monospace;font-style: normal;font-size: 16px;font-variant: normal;text-align: left; white-space:pre-wrap; width:770px; background-color:rgb(100,100,100); color:white; text-align:center;" ></div>
							<div  style="font-family: Courier;font-size: 16px;border:2px blue;">
										<code><textarea cols="80" rows="4" style="background:black;color:white;"> *** Reverse string display ***
Enter a string : Bangkok.
Output : .kokgnaB</textarea></code>
							</div>
						</div>
										
						<div>
							<div style="font-family: Courier, monospace;font-style: normal;font-size: 16px;font-variant: normal;text-align: left; white-space:pre-wrap; width:770px; background-color:rgb(100,100,100); color:white; text-align:center;" ></div>
							<div  style="font-family: Courier;font-size: 16px;border:2px blue;">
										<code><textarea cols="80" rows="4" style="background:black;color:white;"> *** Reverse string display ***
Enter a string : Computer Engineering.
Output : .gnireenignE retupmoC</textarea></code>
							</div>
						</div>
										
						<div>
							<div style="font-family: Courier, monospace;font-style: normal;font-size: 16px;font-variant: normal;text-align: left; white-space:pre-wrap; width:770px; background-color:rgb(100,100,100); color:white; text-align:center;" ></div>
							<div  style="font-family: Courier;font-size: 16px;border:2px blue;">
										<code><textarea cols="80" rows="4" style="background:black;color:white;"> *** Reverse string display ***
Enter a string : The quick brown fox jumps over the lazy dog.
Output : .god yzal eht revo spmuj xof nworb kciuq ehT</textarea></code>
							</div>
						</div>
										
						<div>
							<div style="font-family: Courier, monospace;font-style: normal;font-size: 16px;font-variant: normal;text-align: left; white-space:pre-wrap; width:770px; background-color:rgb(100,100,100); color:white; text-align:center;" ></div>
							<div  style="font-family: Courier;font-size: 16px;border:2px blue;">
										<code><textarea cols="80" rows="4" style="background:black;color:white;"> *** Reverse string display ***
Enter a string : You are my sunshine, my only sunshine.
Output : .enihsnus ylno ym ,enihsnus ym era uoY</textarea></code>
							</div>
						</div>
										
						<div>
							<div style="font-family: Courier, monospace;font-style: normal;font-size: 16px;font-variant: normal;text-align: left; white-space:pre-wrap; width:770px; background-color:rgb(100,100,100); color:white; text-align:center;" ></div>
							<div  style="font-family: Courier;font-size: 16px;border:2px blue;">
										<code><textarea cols="80" rows="4" style="background:black;color:white;"> *** Reverse string display ***
Enter a string : You are the wind beneath my wings.
Output : .sgniw ym htaeneb dniw eht era uoY</textarea></code>
							</div>
						</div>
										
						<div>
							<div style="font-family: Courier, monospace;font-style: normal;font-size: 16px;font-variant: normal;text-align: left; white-space:pre-wrap; width:770px; background-color:rgb(100,100,100); color:white; text-align:center;" ></div>
							<div  style="font-family: Courier;font-size: 16px;border:2px blue;">
										<code><textarea cols="80" rows="4" style="background:black;color:white;"> *** Reverse string display ***
Enter a string : I can tell by your eyes that you have probably been crying forever.
Output : .reverof gniyrc neeb ylbaborp evah uoy taht seye ruoy yb llet nac I</textarea></code>
							</div>
						</div>
															</div>					
				</div>
			</div>
		</div>

		<div class="row">
								</div>
		
	<!-- ย้ายไป header
	<script src="http://161.246.4.240/19s1ds/assets/jquery/jquery-3.1.1.min.js"></script>
	<script src="http://161.246.4.240/19s1ds/assets/bootstrap-3.3.7/js/bootstrap.min.js"></script>	
	-->
	<script src="http://161.246.4.240/19s1ds/assets/summernote/summernote.js"></script>	
	<script type="text/javascript" src="http://161.246.4.240/19s1ds/assets/codemirror-5.22.0/lib/codemirror.js"></script>
	<script type="text/javascript" src="http://161.246.4.240/19s1ds/assets/codemirror-5.22.0/mode/clike/clike.js"></script>
	<!-- <script type="text/javascript" src="http://161.246.4.240/19s1ds/assets/codemirror-5.22.0/mode/xml/xml.js"></script> -->
	<!-- <script type="text/javascript" src="http://161.246.4.240/19s1ds/assets/codemirror-5.22.0/formatting.js"></script> -->
	<script>
		$(document).ready(function() {
			$('#summernote').summernote({
						
					toolbar: [
								// [groupName, [list of button]]
								['fontname', ['fontname']],
								['fontsize', ['fontsize']],
								['style', ['bold', 'italic', 'underline', 'clear']],
								['font', ['strikethrough', 'superscript', 'subscript']],
								
								['color', ['color']],
								['para', ['ul', 'ol', 'paragraph']],
								['height', ['height']]
							  ],
					height: 300,                 // set editor height
					width: 768,
					minHeight: null,             // set minimum height of editor
					maxHeight: null,             // set maximum height of editor
					focus: true,                  // set focus to editable area after initializing summernote

					//placeholder: '123',
					airmode: true
				});
			//$(document).getElementById('summernote').innerHTML=lab_content;
			
		});
	</script>

	<script>
		$(document).ready(function() {
		  $('.summernote').summernote();
		});
		var postForm = function() {
				var content = $('textarea[name="lab_content"]').html($('#summernote').code());
		}
	</script>

	<script type="text/javascript">
		function checkSourceCode(){
			var sourceCodeName = document.getElementById("userfile").value;
			if(sourceCodeName==""){
				alert("ไม่มี New Source Code");
				return true;
			}
			var extension = sourceCodeName.split(".");
			var fileName = extension[0].split('\\');
			if(/^[a-zA-Z0-9]+/.test(fileName[2]) == true)
			{

			}
			else{
				alert("ชื่อไฟล์สามารถประกอบด้วย a-z,A-Z,0-9 เท่านั้น");
				return false;
			}
			if(extension[1]!=document.getElementById("id_extension").value){
				alert("อนุญาตให้ส่งไฟล์สกุล ."+document.getElementById("id_extension").value+"เท่านั้น");
				return false;
			}
		}
	</script>
	<script>
		var editor = CodeMirror.fromTextArea(document.getElementById("sourcecode_content"), {
					lineNumbers: true,
					matchBrackets: true,
					indentUnit: 4,
					readonly: true,
					mode: "text/x-csrc"
			});
	</script>
	

</div>

			</div>
			<!-- row content -->

		</div>
		<!-- Page content -->
		
		<div class="clearfix"></div>

		<!-- footer start -->
		<footer class="container-fluid" style="background-color:LightSteelBlue;border:2px blue;  margin-right:2px;margin-left:300px; ">
			<div style="display:inline";>
			
			<p style="text-align:center;">
				<marquee behavior=alternate direction=left scrollAmount=3 width="4%"> <font face=Webdings> 3</font> </marquee> <marquee scrollAmount=1 direction=left width="2%"> | | |</marquee> Department of Computer Engineering, KMITL 2017 <marquee scrollAmount=1 direction=right width="2%"> | | |</marquee><marquee behavior=alternate direction=right scrollAmount=3 width="4%"> <font face=Webdings> 4</font> </marquee>
			</p>
			<p style="color:darkblue;">
				Page rendered in <strong>0.0093</strong> seconds. 
				CodeIgniter Version <strong>3.1.2</strong><br/>Monday 5th of August 2019 08:41:05 AM			</p>
			
			</div>
		  <!-- <pre>
			Array
(
    [__ci_last_regenerate] => 1564969236
    [username] => kanut
    [id] => 900001
    [role] => supervisor
    [added] => 2017-01-12 08:20:38
    [last_login] => 2019-08-05 08:40:38
    [last_seen] => 2019-08-05 08:40:38
    [status] => online
    [active] => yes
    [added_by] => 
    [ci_session] => 1564969236
    [session_id] => f6de605cc3afa3ba458cd719f70f72a15084430b
    [logged_in] => 1
    [supervisor_id] => 900001
    [supervisor_department] => วิศวกรรมคอมพิวเตอร์
    [supervisor_gender] => male
    [supervisor_firstname] => คณัฐ
    [supervisor_lastname] => ตังติสานนท์
    [supervisor_nickname] => ยู้
    [supervisor_email] => kanut.ta@kmitl.ac.th
    [supervisor_avatar] => image_kanut_59a65158903e4.jpg
)
1		  </pre> -->
		</footer>
		<!-- footer end -->

	
	
	


	</body>
	<!-- <article style="margin-left:350px;text-align:left;">
		<h3> : _SESSSION :</h3><pre>Array
(
    [__ci_last_regenerate] => 1564969236
    [username] => kanut
    [id] => 900001
    [role] => supervisor
    [added] => 2017-01-12 08:20:38
    [last_login] => 2019-08-05 08:40:38
    [last_seen] => 2019-08-05 08:40:38
    [status] => online
    [active] => yes
    [added_by] => 
    [ci_session] => 1564969236
    [session_id] => f6de605cc3afa3ba458cd719f70f72a15084430b
    [logged_in] => 1
    [supervisor_id] => 900001
    [supervisor_department] => วิศวกรรมคอมพิวเตอร์
    [supervisor_gender] => male
    [supervisor_firstname] => คณัฐ
    [supervisor_lastname] => ตังติสานนท์
    [supervisor_nickname] => ยู้
    [supervisor_email] => kanut.ta@kmitl.ac.th
    [supervisor_avatar] => image_kanut_59a65158903e4.jpg
)
</pre>	</article> -->
</html>
