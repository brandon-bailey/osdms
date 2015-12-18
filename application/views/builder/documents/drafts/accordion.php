<ul class="nav nav-sidebar">
<li>
<a data-toggle="collapse" data-target="#elmDrafts" aria-expanded="false" aria-controls="elmDrafts">
<i class="fa fa-plus"></i> Drafts
<i data-toggle="popover"
 title="Help" data-content="In order to use these modules you need to publish them." class="pull-right fa fa-question-circle"></i>
 </a>
</li>
<ul class="list-group">
<li class="collapse" id="elmDrafts">
  <?php foreach($draftModules as $draft):?> 
  <div class="lyrow">	
          <a href="#close" class="remove label label-danger">
          <i class="fa fa-trash">
		  </i> Remove</a>		  
		    <span class="drag label label-primary">			
          <i class="fa fa-arrows"></i>
		  Drag
		  </span>
		  		 <a href="#editor" id="editor" class="editor label label-success">			
			<i class="fa fa-pencil-square-o"></i>
				Edit
			</a>			
			<?php if ($draft->owner === $this->session->id):?>
		  		 <a href="#delete" id="delete" class="delete label label-danger">			
			<i class="fa fa-trash"></i>
				Delete
			</a>	
			<?php endif; ?>				
		  			<a class="overview pull-left" data-toggle="popover"  title="<?php echo $draft->description; ?>" 
 data-content='<img class="img-responsive" src="<?php echo $draft->thumbnail ?>" >'>
			<i class="fa fa-eye "></i>
		 </a>
		 <div id="preview" class="preview" >
		 <input class="form-control" value="<?php echo $draft->description; ?>"type="text" title="<?php echo $draft->description; ?>">	
              </div>			 
			  <div class="view">	
			  <input type="hidden" name="id" value="<?php echo $draft->id;?>">
			  <?php echo file_get_contents($draft->fileLink);?>
			  </div>
			  </div>  
  <?php endforeach;?>
</li>
</ul>
</ul>