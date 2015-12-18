<ul class="nav nav-sidebar">
<li>
<a data-toggle="collapse" data-target="#elmBase" aria-expanded="false" aria-controls="elmBase">
<i class="fa fa-plus"></i> Header
<i data-toggle="popover"
 title="Help" data-content="Drag &amp; Drop the header modules to build a document." class="pull-right fa fa-question-circle"></i>
 </a>
</li>
<ul class="list-group">
<li class="collapse" id="elmBase">
  <?php foreach($headerModules as $header):?> 
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
			<?php if ($header->owner === $this->session->id):?>
		  		 <a href="#delete" id="delete" class="delete label label-danger">			
			<i class="fa fa-trash"></i>
				Delete
			</a>	
			<?php endif; ?>				
		  			<a class="overview pull-left" data-toggle="popover"  title="<?php echo $header->description; ?>" 
 data-content='<img class="img-responsive" src="<?php echo $header->thumbnail ?>" >'>
			<i class="fa fa-eye "></i>
		 </a>
		 <div id="preview" class="preview" >
		 <input class="form-control" value="<?php echo $header->description; ?>" type="text" title="<?php echo $header->description; ?>">	
              </div>			 
			  <div class="view">		
			  <input type="hidden" name="id" value="<?php echo $header->id;?>">
			  <?php echo file_get_contents($header->fileLink);?>
			  </div>
			  </div> 
  <?php endforeach;?>
</li>
</ul>
</ul>

            
            
            
            
            
            
            
            
            
            
            
            
            
			  
				  
      