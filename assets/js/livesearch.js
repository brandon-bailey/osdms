// Start Ready
$(document).ready(function() {  
	// Icon Click Focus
	$('div.icon').click(function(){
		$('input#search').focus();
	});

	$("input#search").on("keyup", function(e) {	
		// Set Timeout
		clearTimeout($.data(this, 'timer'));
		// Set Search String
		var searchString = $(this).val();
		// Do Search
		if (searchString == '') {
			$("ul#results").fadeOut();
			$('h4#results-text').fadeOut();
		}else{
			$("ul#results").fadeIn();
			$('h4#results-text').fadeIn();
			$(this).data('timer', setTimeout(jsonSearch, 100));
		};
	});	
	
	function jsonSearch() {	  
	    var queryValue = $('input#search').val();
	    if (queryValue !== '') {
	        jQuery.ajax({
	            type: "POST",
	            url: "./search/livesearch",
	            data: {search: queryValue},
	            cache: false,
	            dataType: 'json',
	            success: function(data) {
					$('div#searchResults').html('');	
					if(data.status == 'error'){
						var error = $('<div class="alert alert-danger"><p>'+  data.msg +'</p></div>') 
						$('div#searchResults').append(error);
						return;
					}
	                console.log(data);									
					var row = $('<div class="row text-center" >')
	                for (var i = 0; i < data.length; i++) {
						row.append('<div class="col-md-3 col-sm-6 col-xs-12" data-toggle="tooltip" title="'+data[i].description+'" >'+
							'<div class="thumbnail well">'+
							'<div class="thumb"><img class="img-responsive" src="' +  data[i].thumbnail + '" alt="'+ data[i].realname +'"></div>'+
							'<div class="caption">'+
						'<h4>' + data[i].realname + '</h4>'+
						'<p>'+ data[i].description + '</p>'+
						'<p><a href="'+ data[i].detailsLink +'" class="btn btn-primary">Details</a></p>'+
						'</div>'+
						'</div></div>');						
	                } 
					$('div#searchResults').append(row);

	            }
	        });

	    }
	  //  return false;
	}	
	

});