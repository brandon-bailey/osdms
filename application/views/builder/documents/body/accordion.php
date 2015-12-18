<ul class="nav nav-sidebar">
<li>
<a data-toggle="collapse" data-target="#elmBody" aria-expanded="false" aria-controls="elmBody">
<i class="fa fa-plus"></i> Body
<i data-toggle="popover"
 title="Help" data-content="Drag &amp; Drop the body modules to build a document." class="pull-right fa fa-question-circle"></i>
 </a>
</li>
<ul class="list-group">
<li class="collapse" id="elmBody">
  <?php foreach($bodyModules as $body):?> 
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
			<?php if ($body->owner === $this->session->id):?>
		  		 <a href="#delete" id="delete" class="delete label label-danger">			
			<i class="fa fa-trash"></i>
				Delete
			</a>	
			<?php endif; ?>				
		  			<a class="overview pull-left" data-toggle="popover"  title="<?php echo $body->description; ?>" 
 data-content='<img class="img-responsive" src="<?php echo $body->thumbnail ?>" >'>
			<i class="fa fa-eye "></i>
		 </a>
		 <div id="preview" class="preview" >
		 <input class="form-control" value="<?php echo $body->description; ?>"type="text" title="<?php echo $body->description; ?>">	
              </div>			 
			  <div class="view">
			  <input type="hidden" name="id" value="<?php echo $body->id;?>">
			  <?php echo file_get_contents($body->fileLink);?>
			  </div>
			  </div>   
  <?php endforeach;?>
</li>
</ul>
</ul>