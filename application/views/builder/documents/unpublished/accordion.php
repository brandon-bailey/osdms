<ul class="nav nav-sidebar">
<li>
<a data-toggle="collapse" data-target="#elmPublished" aria-expanded="false" aria-controls="elmPublished">
<i class="fa fa-plus"></i> Unpublished
<i data-toggle="popover"
 title="Help" data-content="This section will be empty unless you have archived modules." class="pull-right fa fa-question-circle"></i>
 </a>
</li>
<ul class="list-group">
<li class="collapse" id="elmPublished">
  <?php foreach($unpublishedModules as $unpublished):?> 
   <div class="lyrow">	
		<a href="#editor" id="editor" class="unpublished label label-success">			
			<i class="fa fa-pencil-square-o"></i>
				Edit
			</a>
		  			<a class="pull-left" data-toggle="popover"  title="<?php echo $unpublished->description; ?>" 
 data-content='<img src="<?php echo $unpublished->thumbnail; ?>" style="max-width:400px;">'>
			<i class="fa fa-eye "></i>
		 </a>
		 <div id="preview" class="preview" >
		 <input class="form-control" value="<?php echo $unpublished->description; ?>"type="text" title="<?php echo $unpublished->description; ?>">	
              </div>			 
			  <div class="view">
			  <input type="hidden" name="id" value="<?php echo $unpublished->id;?>">
			  <?php echo file_get_contents($unpublished->fileLink); ?>
			  </div>
			  </div>
  
  <?php endforeach;?>
</li>
</ul>
</ul>