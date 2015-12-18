<ul class="nav nav-sidebar">
<li>
<a data-toggle="collapse" data-target="#elmComponents" aria-expanded="false" aria-controls="elmComponents">
<i class="fa fa-plus"></i> Footer
<i data-toggle="popover"
 title="Help" data-content="Drag &amp; Drop the footer modules to build a document." class="pull-right fa fa-question-circle"></i>
 </a>
</li>
<ul class="list-group">
<li class="collapse" id="elmComponents">
  <?php foreach($footerModules as $footer):?> 
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
			<?php if ($footer->owner === $this->session->id):?>
		  		 <a href="#delete" id="delete" class="delete label label-danger">			
			<i class="fa fa-trash"></i>
				Delete
			</a>	
			<?php endif; ?>				
		  			<a class="overview pull-left" data-toggle="popover"  title="<?php echo $footer->description; ?>" 
 data-content='<img class="img-responsive" src="<?php echo $footer->thumbnail ?>" >'>
			<i class="fa fa-eye "></i>
		 </a>
		 <div id="preview" class="preview" >
		 <input class="form-control" value="<?php echo $footer->description; ?>"type="text" title="<?php echo $footer->description; ?>">	
              </div>			 
			  <div class="view">	
			  <input type="hidden" name="id" value="<?php echo $footer->id;?>">
			  <?php echo file_get_contents($footer->fileLink);?>
			  </div>
			  </div>  
  <?php endforeach;?>

</li>
</ul>
</ul>