<?php if(isset($reviewCount) && $reviewCount > 0):?>
		<div class="container">	
			<div class="alert alert-warning" role="alert">			
				<i class="fa fa-exclamation-triangle fa-2x"></i> <strong>
					<a href="<?php echo base_url() ?>index.php/tobepublished">
					Documents waiting to be reviewed</a>: <?php echo $reviewCount ?>
					</strong>					
						<button type="button" class="clearfix close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true"><i class="fa fa-times"></i></span>
						</button></div>	
		</div>
<?php elseif(isset($rejectedFiles) && sizeof($rejectedFiles) !== 0):?>
	<div class="container">		
			<div class="alert alert-warning" role="alert">
				<i class="fa fa-exclamation-triangle fa-2x"></i> 
					<strong>
					<a href="<?php echo base_url() ?>index.php/file/showrejects">
					Documents Rejected </a>: <?php echo sizeof($rejectedFiles) ?>
					</strong>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true"><i class="fa fa-times"></i></span>
						</button>
			</div>	
	</div>
<?php elseif(isset($expiredFiles) && $expiredFiles > 0):?>
<div class="container">
	<div class="alert alert-danger" role="alert">
	<i class="fa fa-exclamation-triangle fa-2x"></i>
	<a href="#">
	Documents Expired:<?php echo $expiredFiles ?></a>
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true"><i class="fa fa-times"></i></span>
			</button></div>
			</div>
	
<?php
endif;
if($fileList !== 0):
?>	 
<!--variables found in functions.php list_files fucntion-->
<link href="<?php echo base_url(); ?>assets/css/browser.css" rel="stylesheet" type="text/css" media="all">
<div class="container">
	<button class="btn btn-primary show_hide" type="button" title="Search Tools" 
	>Search Tools</button>	
		<div class="slidingDiv ">
			<div class="row-fluid">			
				<form id="live-search" class="form-inline"  method="post">				
					<div class="form-group"><!--filename search-->				
						<input type="text" class="text-input form-control" id="filter" value="" placeholder="Search by File Names"/>
					</div>
					<div class="form-group"><!--dropdown search-->	
							<select class="filter form-control" name="user" id="user">
									<option value="">Sort By User</option>		
							        <?php foreach ($allUsers as $user):	?>					
								<option value="<?php echo $user->last_name ?>, <?php echo $user->first_name ?>">
								<?php echo $user->last_name ?>, <?php echo $user->first_name ?></option>
									<?php endforeach;?>
							</select>
					</div>	
			</form>
			</div>
		</div>
</div>
<?php
if(isset($fileList[0]->showCheckbox)):
if($fileList[0]->showCheckbox === TRUE):
$form = 1;
?>
<div class="container">
<div class="row">
<div class="col-md-6 text-center" >
<div id="trashDiv"><i id="trashCan"  class="droppable fa fa-trash-o text-danger fa-4x" 
data-toggle="tooltip" data-placement="right" title="<?php echo $trashCanTitle; ?>"></i></div>    
</div>

<div class="col-md-6 text-center">
<div id="authorizeDiv"><i id="authorize" class="droppable fa fa-thumbs-o-up text-success fa-4x" 
data-toggle="tooltip" data-placement="right" title="<?php echo $authorizeButtonTitle; ?>"></i></div>
</div>
</div>
</div>
<?php 
endif;
endif; ?>
<div class="container-fluid">
<div class="row-fluid">
<div class="filemanager">

		<ul  class="data animated ">
  <?php if(is_array($fileList)): ?>
  <?php echo form_open('','class="form" method="post" id="mainForm"') ?>
<?php
  foreach($fileList as $item):
if(is_file($this->config->item('dataDir') . 'thumbnails/' .$item->uniqueName . '.jpg')):
$thumbnail = base_url() . $this->config->item('dataDir') . 'thumbnails/' .$item->uniqueName . '.jpg';
else:
$thumbnail = base_url() . 'assets/images/no-image-available.jpg';
endif;
?>
<li class="files trashable" id="fileItem_<?php echo $item->id ?>" 
	data-toggle="popover" title="<?php echo $item->fileName;?>" 
		data-content="<img src='<?php echo $thumbnail ;?>'>">
	<a href="<?php echo $item->detailsLink?>">	
		<span class="icon file f-<?php echo $item->ext;?>"><?php echo $item->ext;?></span>              
			<span class="name"><?php echo $item->fileName;?></span>
				<span class="details">Size : <?php echo $item->fileSize;?></span>
						<input type="hidden" name="fileId" value="<?php echo $item->id ?>">
				<span class="description"><?php echo $item->description;?></span>
					<span class="date">Created Date: <?php echo $item->createdDate;?></span>        
           
 
						<span class="owner">Author: <?php echo $item->ownerName;?></span>

						<span class="lock">
                <?php if($item->lock==false):?>
                   <i class="fa fa-unlock fa-2x"></i>
				<?php  else:?>
                    <i class="fa fa-lock fa-2x"></i>
			<?php endif; ?>
            </span>
			     </a>
	</li>

		<?php 
		endforeach;	
else:?>
			<div class="container">
				<div class="alert alert-danger" role="alert">
					<i class="fa fa-exclamation-triangle fa-2x"></i>
						<strong> No Files Found </strong>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true"><i class="fa fa-times"></i></span>
						</button>
				</div>
		</div>
	<?php
	endif;
	
else:
?>
		<div class="container">
				<div class="alert alert-danger" role="alert">
					<i class="fa fa-exclamation-triangle fa-2x"></i>
						<strong> No Files Found </strong>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true"><i class="fa fa-times"></i></span>
						</button>
				</div>
		</div>
<?php
endif;
		?>

</ul>
	
    <?php if (isset($form)!=1):?>
</form>
			<?php endif; ?>

</div>
</div>

<?php
if(isset($links)):
?>
	<div class="row">
<nav  style="text-align:center;">
<ul class="pagination" >
<?php
 echo $links
?>
	</ul>
</nav>
	</div>	
<?php
endif;
 ?>
<?php if(isset($limitReached)):?>
    <div class="text-warning">Maximum number of results have been returned.</div>
<?php endif;?>
</div>

<script>
$(document).ready(function(){
    $("#filter").keyup(function(){ 
        // Retrieve the input field text and reset the count to zero
        var filter = $(this).val(),count=0; 
        // Loop through the comment list
        $(".data li.files span.name").each(function(){ 
            // If the list item does not contain the text phrase fade it out
            if ($(this).text().search(new RegExp(filter, "i")) < 0) {			
                $(this).parent().parent().fadeOut(); 
            // Show the list item if the phrase matches and increase the count by 1
            } else {
                $(this).parent().parent().show();
				count++;
            }
        });

    });

    $(document).on("change", "select.filter" ,function() {			
			var filter = $(this).val(),count=0;							
				$(".owner").each(function(){
					if ($(this).text().search(new RegExp(filter, "i")) < 0) {			
						$(this).parent().parent().fadeOut();
				} else {
					$(this).parent().parent().show();
					count++;
					}
				});		
    });	

	  $('[data-toggle="popover"]').popover({
			trigger:'hover',
		  html:true,
		template: '<div class="popover imageHover" role="tooltip">'+
		'<div class="arrow"></div><h3 class="popover-title"></h3>'+
		'<div class="popover-content"></div></div>'
		  
		  }); 
	
        $(".slidingDiv").hide();
        $(".show_hide").show();
 
    $('.show_hide').click(function(){
    $(".slidingDiv").slideToggle();
    }); 
});

</script>
