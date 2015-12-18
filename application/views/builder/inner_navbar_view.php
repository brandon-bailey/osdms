<div class="container-fluid">	  
	  <div class="row-fluid">	  
	     <div class="btn-group" style="margin-left:250px;">		 
				<button type="button" class="btn btn-danger dropdown-toggle"  
				data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				View <i class="fa fa-caret-down"></i></button>
				
				<ul class="dropdown-menu">
						<li><a href="#" id="devpreview"><i class="fa fa-eye-slash"></i> Developer</a></li>
							<li class="divider"></li>
						<li><a href="#" id="sourcepreview"><i class="fa fa-eye"></i> Preview</a></li>
							<li class="divider"></li>
						<li><a href="#" id="edit" ><i class="fa fa-edit"></i> Edit</a></li>
				</ul>
      </div>		
			<button type="button" class="btn btn-danger" style="text-transform:capitalize;" data-target="#downloadModal" rel="/build/downloadModal" data-toggle="modal">
			<i class="fa fa-floppy-o"></i> Save <?php echo $builder;?></button>

			<a class="btn btn-danger" href="#clear" id="clear"><i class="fa fa-trash"></i> Clear</a>

			<a role="button" class="btn btn-danger" style="text-transform:capitalize;" onclick="javascript:localStorage.removeItem('layoutdata')" 
			href="<?php if($builder =='module'): echo 'document'; $type = 'document'; else: echo 'module'; $type = 'module'; endif;?>">Create <?php echo $type; ?></a>

		</div>
</div>