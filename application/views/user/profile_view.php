<script src="<?php echo base_url()?>assets/js/fileinput.js"></script>
<script src="<?php echo base_url()?>assets/js/ajaxfileupload.js"></script>
<div class="container">
<div class="row">  
<div class="col-md-12">

	<div class="col-md-3" itemscope itemtype="http://schema.org/Person">
	
		<img id="userAvatar" class="img-responsive img-rounded" 
		src="data:image/jpeg;base64,<?php echo base64_encode($userDetails->image)?>" 
		alt="<?php echo $userDetails->fullName ?>" 
		data-toggle="tooltip" data-placement="auto" title="<?php echo $userDetails->fullName  ?>" >
		
		<h1 class="vcard-names">
			<span class="vcard-fullname" itemprop="name"><?php echo $userDetails->fullName  ?></span>
			<span class="vcard-username" itemprop="additionalName"><?php echo $userDetails->username  ?></span>
		</h1>	
		<ul class="vcard-details">
		  <li class="vcard-detail" itemprop="homeLocation" title="Colorado Springs, CO"><span class="octicon octicon-location"></span>Colorado Springs, CO</li>  
		  <li class="vcard-detail">
		  <span class="octicon octicon-clock"></span>
		  <span class="join-label">Joined on </span>
		  <time class="join-date" datetime="<?php echo $userDetails->since ?>" 
		  day="numeric" is="local-time" month="short" year="numeric"
		  title="<?php echo $userDetails->since ?>"><?php echo $userDetails->since?></time>
		  </li>
		</ul>		

		</div>
				<?php echo form_open('','id="profileForm"') ?>
	<input type="hidden" name="id" value="<?php echo $this->uid ?>">
		  <a role="button" class="btn btn-primary" id="modifyUser" href="user/modifyuser" title="Update Profile Information"><i class="fa fa-edit"></i> Edit Profile</a>
		  <?php echo form_close();?>

		  	</div>
	</div>
</div>
<script>
$(document).ready(function(){
	$('a#modifyUser').on('click', function(e){
			e.preventDefault();
				$.ajax({
				type:'post',
				url: "user/modifyuser",				
				data:$('form#profileForm').serialize(),				
				success:function(data){
					$('body').append(data);
					$('#modifyUserModal').modal('show');
				}
			})		
		return;
	});
});
</script>