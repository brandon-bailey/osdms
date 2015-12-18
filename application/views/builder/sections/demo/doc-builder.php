<?php
session_start();

include_once('odm-load.php');

if (!isset($_SESSION['uid']))
{
    redirect_visitor();
}
$user_obj = new User($_SESSION['uid'], $pdo);
?>
<!doctype html>
<html>
<head>
<?php include 'modules/custom/head.php'; ?>
</head>
<body style="min-height: 660px; cursor: auto;" class="edit">
<?php include 'modules/doc-nav-bar.php'?>

<div class="container-fluid">
  <div class="row-fluid">
    <div class="">
      <?php include 'modules/custom/builder-sidebar-nav.php'?>
    </div>
    <!--/span-->

<?php include 'modules/demo/builder-body.php'?>

    <!--/span-->
	
    <div id="download-layout">
      <div class="container-fluid"></div>
    </div>  

 
  </div>
  <!--/row--> 
</div>

<!--/.fluid-container--> 
<?php include 'modules/editor-modal.php'?>
<?php include 'modules/addFileModal.php'?>
<!--<?php include 'modules/document-preview.php'?>-->

<!--<script type="text/javascript" src="js/thumbnail/html2canvas.js"></script>-->
</body>
 <script type="text/javascript">
 $(document).ready(function(argument) {
 $('#save').click(function(){
 // Get edit field value
 $edit = $('#editor').html();
 $.ajax({
 url: 'upload.php',
 type: 'post',
 data: {data: $edit},
 datatype: 'html', 
 success: function(rsp){
window.location = 'save.php';
console.log(rsp);
 } 
	});
		});
			});
 </script>
</html>