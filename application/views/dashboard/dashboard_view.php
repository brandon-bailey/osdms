<script src="<?php echo base_url() ?>assets/js/charts/Chart.js"></script>
<script src="<?php echo base_url() ?>assets/js/charts/legend.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/dashboard.css" media="all">
 	<div class="container-fluid">
   <div class="row">


		<div class="col-md-4">
            <div id="chart2" class="panel panel-primary">
                 <div class="panel-heading">
				<center>
                    <h2 class="panel-title">Uploads by Date</h2>
					</center>
                </div>
			<div class="panel-body">
			<a id="fullscreen" class="btn btn-primary fullscreen" role="button"href="#"><i class="fa fa-expand"></i></a>
                <div class="canvas-container">
                    <canvas id="file-uploads"></canvas>
                </div>
            </div>
			</div>
		</div>

		<div class="col-md-4">
            <div id="chart3" class="panel panel-primary">
                <div class="panel-heading">
				<center>
                    <h2 class="panel-title">Files per Category</h2>
					</center>

                </div>
				<div class="panel-body">
									<a id="fullscreen" class="btn btn-primary fullscreen" role="button" href="#"><i class="fa fa-expand"></i></a>
                <div class="canvas-container">
                    <canvas id="files-per-category"></canvas>
                </div>

                <div id="file-per-category-legend"></div>
				</div>
            </div>
		</div>
    </div>

    <div class="row">
	<div class="col-md-4">
            <div id="chart4" class="panel panel-primary">
                <div class="panel-heading">
                  <center><h2 class="panel-title">Files per User</h2></center>
                </div>
				<div class="panel-body">
				<a id="fullscreen" class="btn btn-primary fullscreen" role="button" href="#"><i class="fa fa-expand"></i></a>
                <div class="canvas-container">
                    <canvas id="files-per-user"></canvas>
                </div>
                <div id="files-per-user-legend"></div>
				</div>
            </div>
	</div>
	<div class="col-md-4">
            <div id="chart5" class="panel panel-primary">
                <div class="panel-heading">
                    <center> <h2 class="panel-title">Files per Department</h2></center>
                </div>
				<div class="panel-body">
				<a id="fullscreen" class="btn btn-primary fullscreen" role="button"href="#"><i class="fa fa-expand"></i></a>
                <div class="canvas-container">
                    <canvas id="files-per-dept"></canvas>
                </div>

                <div id="files-per-dept-legend"></div>
				</div>
            </div>
	</div>

	<div class="col-md-4">
            <div id="chart6" class="panel panel-primary">
                <div class="panel-heading">
                   <center> <h2 class="panel-title">Files per Status</h2></center>
                </div>
				<div class="panel-body">
				<a id="fullscreen" class="btn btn-primary fullscreen" role="button" href="#"><i class="fa fa-expand"></i></a>
                <div class="canvas-container">
                    <canvas id="files-per-status"></canvas>
                </div>

                <div id="files-per-status-legend"></div>
				</div>
            </div>
	</div>

    </div><!--row-->
</div><!--container-->


<script>

	if(!!(window.addEventListener)) window.addEventListener('DOMContentLoaded', main);
else window.attachEvent('onload', main);

function main() {
    uploadsDate();
   files();
	userChart();
	deptChart();
	statusChart();
}


function uploadsDate(){
	   	$.ajax({
	method:'post',
	url: "<?php echo site_url() ?>dashboard/filecount",
	dataType:'json',
	data: {'<?php echo $this->security->get_csrf_token_name() ?>':'<?php echo $this->security->get_csrf_hash() ?>'} ,
	success: function(data)
	{
		var chartjsDate = [];
		var chartjsCount = [];
		for (var i = 0; i < data.length; i++) {
			chartjsDate.push(data[i].date);
			chartjsCount.push(data[i].count);
		}
		var uploadsByDate = {
			labels : [chartjsDate],
			datasets : [{fillColor : getRandomColor(),data : [chartjsCount]}]
		}
		var uploads = document.getElementById("file-uploads").getContext("2d");
		new Chart(uploads).Bar(uploadsByDate, {responsive: true});

	}
});//end of ajax
}

function files(){

	   	$.ajax({
	method:'post',
	url: "<?php echo site_url() ?>dashboard/filecountcategory",
	dataType:'json',
	data: {'<?php echo $this->security->get_csrf_token_name() ?>':'<?php echo $this->security->get_csrf_hash() ?>'} ,
	success: function(data)
	{
	var filesPerCat = [];
				for (var i = 0; i < data.length; i++) {
				var cat = {
					value: data[i].count,
					color:getRandomColor(),
					highlight: '#FF5A5E',
					label:data[i].category
				};
					filesPerCat.push(cat);
				}
				console.log(filesPerCat);
		var filesPerCategory = document.getElementById("files-per-category").getContext("2d");
		new Chart(filesPerCategory).Pie(filesPerCat, {responsive: true});
		legend(document.getElementById("file-per-category-legend"), filesPerCat);

	}
});//end of ajax

}


function userChart(){

	   	$.ajax({
	method:'post',
	url: "<?php echo site_url() ?>dashboard/filecountowner",
	dataType:'json',
	data: {'<?php echo $this->security->get_csrf_token_name() ?>':'<?php echo $this->security->get_csrf_hash() ?>'} ,
	success: function(data)
	{
	var filesPerOwn = [];
				for (var i = 0; i < data.length; i++) {
				var cat = {
					value: data[i].count,
					color:getRandomColor(),
					highlight: '#FF5A5E',
					label:data[i].owner
				};
					filesPerOwn.push(cat);
				}
		var filesPerOwner = document.getElementById("files-per-user").getContext("2d");
		var filesPerOwnerChart=new Chart(filesPerOwner).Pie(filesPerOwn, {responsive: true});

		legend(document.getElementById("files-per-user-legend"), filesPerOwn);

	}
});//end of ajax


}


function deptChart(){
	   	$.ajax({
	method:'post',
	url: "<?php echo site_url() ?>dashboard/filecountdept",
	dataType:'json',
	data: {'<?php echo $this->security->get_csrf_token_name() ?>':'<?php echo $this->security->get_csrf_hash() ?>'} ,
	success: function(data)
	{
	var filesPerDept = [];
				for (var i = 0; i < data.length; i++) {
				var cat = {
					value: data[i].count,
					color:getRandomColor(),
					highlight: '#FF5A5E',
					label:data[i].department
				};
					filesPerDept.push(cat);
				}
		var filesPerDeptChart = document.getElementById("files-per-dept").getContext("2d");
		new Chart(filesPerDeptChart).Pie(filesPerDept, {responsive: true});
		legend(document.getElementById("files-per-dept-legend"), filesPerDept);

	}
});//end of ajax


}

function statusChart(){
	   	$.ajax({
	method:'post',
	url: "<?php echo site_url() ?>dashboard/filecountstatus",
	dataType:'json',
	data: {'<?php echo $this->security->get_csrf_token_name() ?>':'<?php echo $this->security->get_csrf_hash() ?>'} ,
	success: function(data)
	{
	var filesPerStatus = [];
				for (var i = 0; i < data.length; i++) {
				var cat = {
					value: data[i].count,
					color:getRandomColor(),
					highlight: '#FF5A5E',
					label:data[i].status
				};
					filesPerStatus.push(cat);
				}
		var filesPerStatusChart = document.getElementById("files-per-status").getContext("2d");
		new Chart(filesPerStatusChart).Pie(filesPerStatus, {responsive: true});
		legend(document.getElementById("files-per-status-legend"), filesPerStatus);

	}
});//end of ajax


}

	function getRandomColor() {
    var letters = '0123456789ABCDEF'.split('');
    var color = '#';
    for (var i = 0; i < 6; i++ ) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
}

$(document).on( "click",'#fullscreen',function( event ) {
var elem=$(event.target).closest('div').parent('div').attr('id');
 launchIntoFullscreen(document.getElementById(elem));
$(event.target).closest('a').replaceWith('<a id="exitfullscreen" class="btn btn-danger exitfullscreen" role="button" href="#"><i class="fa fa-times"></i></a>');
 });

$(document).on( "click", '#exitfullscreen',function() {
exitFullscreen();
$("#exitfullscreen").closest('a').replaceWith('<a id="fullscreen" class="btn btn-primary fullscreen" role="button" href="#"><i class="fa fa-expand"></i></a>');
return false;
});

// Find the right method, call on correct element
function launchIntoFullscreen(element) {
  if(element.requestFullscreen) {
    element.requestFullscreen();
  } else if(element.mozRequestFullScreen) {
    element.mozRequestFullScreen();
  } else if(element.webkitRequestFullscreen) {
    element.webkitRequestFullscreen();
  } else if(element.msRequestFullscreen) {
    element.msRequestFullscreen();
  }
}

function exitFullscreen(){
if (document.exitFullscreen) {
    document.exitFullscreen();
} else if (document.webkitExitFullscreen) {
    document.webkitExitFullscreen();
} else if (document.mozCancelFullScreen) {
    document.mozCancelFullScreen();
} else if (document.msExitFullscreen) {
    document.msExitFullscreen();
}
}
$(document).ready(function(){
        $(".slidingDiv").hide();
        $(".show_hide").show();
    $('.show_hide').click(function(){
    $(".slidingDiv").slideToggle();
    });
});

	</script>

</body>
</html>