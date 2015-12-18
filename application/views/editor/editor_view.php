<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Document Editor</title>
<link rel="icon" href="<?php echo base_url() . $this->config->item('site_logo'); ?>">
<link href="<?php echo base_url() ?>assets/css/bootstrap.css" rel="stylesheet" type="text/css" media="all">
<style>
		body{
			background-color:#ccc;
			}
   .inline-container{
   background-color:#fff;
   width:1200px;
   margin-left:auto;
   margin-right:auto;
	padding-top:20px;
   padding-left:15px;
    overflow: auto;
    position: absolute;
    top: 80px;
    left: 0;
    right: 0;
	border:2px;
	box-shadow: 3px 3px 3px 3px #888888;
	 }

.cke_hidden
   {
display:none;
   }
.cke_editable.cke_editable_inline
{
	cursor: pointer;
}
.cke_editable.cke_editable_inline.cke_focus
{
	cursor: text;
}
</style>
	</head>
	<body>
    <header class="navbar navbar-inverse navbar-fixed-top" ><!--Begin Navbar-->
	    <div class="container">
		<div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" rel="home" href="<?php echo site_url() ?>/home" style="margin-top: -7px;" title="Document Management System"><img alt="Document Management System" src="<?php echo base_url(); ?>assets/images/logo-32.png"></a>
		</div>
          <div id="navbar" class="navbar-collapse collapse" aria-expanded="false" role="navigation">
            <ul class="nav navbar-nav" id="navigation">
              <li><a href="<?php echo site_url() ?>home">Home</a></li>
                <li><a href="#" id="saveEdits"><i class="fa fa-floppy-o"></i> Save</a></li>
			<li><a href="#" onclick="javascript:window.close();opener.window.focus();">Close</a></li>
     </ul>
<ul class="nav navbar-nav navbar-right">
<li><a href="<?php echo site_url() ?>profile">
Logged in as <?php echo $this->userObj->getUserName(); ?></a></li>
      </ul>
           </div><!--/.nav-collapse -->
          </div>
    </header><!--End Navbar-->

<div class="inline-container">
<?php
if (isset($modules)):
	foreach ($modules as $module):
		echo '<div class="editor"><input type="hidden" name="id" value="' . $module['id'] . '" >';
		$this->load->file($module['location']);
		echo '</div>';
	endforeach;
else:
	$this->load->file($file);
endif;
?>
</div>

<div id="moduleContent" style="display:none;">

</div>

</body>
<script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/jquery.htmlClean.js"></script>
<script src="<?php echo base_url() ?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo base_url() ?>assets/ckeditor/ckeditor.js"></script>
<script>

$('body div.editor').attr('contenteditable','true');

$("#saveEdits").on("click", function () {
for (var i in CKEDITOR.instances) {
    (function(i){
		var data = CKEDITOR.instances[i].getData();
		$('div#moduleContent').html(data);
		html = $.parseHTML(data);
		var val;
		$.each(html, function(i, e) {
		if(e.nodeName == "P")
		{
			val = $(e.innerHTML).val();
		}
		});
		var t = $("div#moduleContent").children();
		t.find('input[name="id"]').parent().andSelf().remove();
		formatSrc = $.htmlClean($("div#moduleContent").html(), {
		format: true,
		allowedAttributes: [
			["id"],
			["class"],
			["data-toggle"],
			["data-target"],
			["data-parent"],
			["role"],
			["data-dismiss"],
			["aria-labelledby"],
			["aria-hidden"],
			["data-slide-to"],
			["data-slide"]
		]
	});
		$.ajax({
		url: 'saveChanges',
		type: 'post',
		dataType:'json',
        data: {html: formatSrc,module:val,docId:<?php echo $id ?>},
		 success: function(data){
			$('div#moduleContent').html('');
				if(data.status == "error")
				{
					alertify.error(data.msg,null);
				}
				else{
					alertify.success(data.msg,null);
				}
		}
			})
		})(i);
	}
});
</script>
