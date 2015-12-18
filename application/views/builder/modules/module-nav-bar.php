<div class="navbar navbar-inverse navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container">
         <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse" >
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
		  <a class="brand" href="<?php echo $base_url;?>out"><img src="<?php echo $base_url;?>images/login-logo.png"></a>
      <div class="nav-collapse collapse">       
      	<ul class="nav" id="menu-layoutit"> 

		<li><a href="<?php echo $base_url;?>out" id="home">Home</a> </li>
		
        <li class="dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">View <i class="fa fa-caret-down"></i></a>
        <ul class="dropdown-menu" role="menu">
          <li><a href="#" id="devpreview"><i class="fa fa-eye-slash"></i> Developer</a></li>
           <li class="divider"></li>
          <li><a href="#" id="sourcepreview"><i class="fa fa-eye"></i> Preview</a></li>
		  <li class="divider"></li>
		  <li><a href="#" id="edit" ><i class="fa fa-edit"></i> Edit</a></li>
         </ul>
      </li>
	  
		<li>
			<a href="#" data-target="#downloadModal" rel="/build/downloadModal" role="button" data-toggle="modal"><i class="fa fa-floppy-o"></i> Save Module</a>
		</li>

		<li>
			<a href="#clear" id="clear"><i class="fa fa-trash"></i> Clear</a>
		</li>
		
		<li>
			<a onclick="javascript:localStorage.removeItem('layoutdata')" href="doc-builder">Create Document</a>
		</li>
         
        </ul>
                 
      </div>
      <!--/.nav-collapse --> 
    </div>
  </div>
</div>