	
	jQuery(document).on("click", "button#advancedSearchOptions", function() {
	    jQuery("div#advancedOptions").toggle();
	    jQuery("input[name='search']").val('');
	});
	
	jQuery(document).on("click", "span#filter a", function() {
		event.preventDefault();
		jQuery(this).parent().remove();
	});

	jQuery(document).on("click", "#allSearchResults", function() {
	    link = jQuery(this).attr('src');
	    window.open(link, '', 'location=no,menubar=no,scrollbars=yes,status=no,toolbar=yes,directories=no,resizable=no,width=800,height=800,autoplay=false');
	});
	jQuery(document).on("change", "select#searchLocation", function() {
	    newVal = jQuery(this).val();
	    jQuery("input[name='search']").attr('id', newVal);
	    jQuery("input[name='search']").attr('placeholder', 'Start typing to search ' + newVal + '...');
	    jQuery("#rt-mainbody").html('');
	    if (newVal == 'documents') {
	        getDepartmentList();
	    }
		else{
			  jQuery("div#advancedOptions").toggle();
		}
	});
	
	jQuery(document).on("change", "select#departmentFilter", function() {
	    event.preventDefault();
	    jQuery("div#searchFilters").html('')
	    jQuery("div#listOfDepartments").toggle();
	    jQuery("div#advancedOptions").toggle();
	    var deptList = jQuery(this).val();	   

		jsonDeptList=[];
	    for (var i = 0; i < deptList.length; i++) {
			var id = jQuery(this).children(":selected").attr("id");
		item = {}
        item ["id"] = id;
        item ["name"] = deptList[i];
        jsonDeptList.push(item);	        
	        jQuery("div#searchFilters").append('<span id="filter" class="label label-primary"><a href="#"><i class="icon icon-trash"></i></a> ' + deptList[i] + '</span>');
	    }
		console.log(jsonDeptList);
	});

	function getDepartmentList() {
	    jQuery("div#listOfDepartments").toggle();
	    jQuery.ajax({
	        type: "get",
	        url: "http://frontiercaredesk.com/api/documentDataApi.php",
	        data: {
	            departmentList: 'true'
	        },
	        cache: false,
	        dataType: 'json',
	        success: function(data) {
	            for (var i = 0; i < data.length; i++) {
	                jQuery('#departmentFilter').append('<option id="' + data[i].id + '" value="' + data[i].name + '">' + data[i].name + '</option>');
	            }
	        }
	    });
	}
	
	function getDeptColor(id){
			jQuery.ajax({
				type: "get",
				url: "http://frontiercaredesk.com/api/documentDataApi.php",
				data: {
	            departmentColor: 'true',
				id:id
				},
				cache: false,
				dataType: 'json',
				success: function(data) {

	        }
	    });						
	}
	function jsonAllSearch(searchType,input) {
	    jQuery('ul#liveSearchResults').html('');
	    var queryValue = input.val();
	    if (queryValue !== '') {
	        jQuery.ajax({
	            type: "POST",
	            url: "http://frontiercaredesk.com/search/advancedSearch.php",
	            data: {				
					action:searchType,
	                search: queryValue,
					filters:getSearchFilters()
	            },
	            cache: false,
	            dataType: 'json',
	            success: function(data) {
	                //console.log(data);
	                jQuery('ul#liveSearchResults').html('');  
					
	                for (var i = 0; i < data.length; i++) {	               
					switch(data[i].type){
						case 'document':
							img = data[i].thumb.replace(/\.[^/.]+$/, "");
							Location='http://doc.frontiercaredesk.com/document/'+data[i].id;
							thumb = 'http://doc.frontiercaredesk.com/documents/files/thumbnails/'+img+'.png';					
							break;
						case 'simulator':
							Location= 'http://frontiercaredesk.com'+data[i].location;
							thumb = data[i].thumb;
							break;
						case 'video':
							Location= 'http://frontiercaredesk.com'+data[i].location;
							thumb=data[i].thumb;
							break;						
					}
						var object = jQuery('<li><div class="col-md-12"><div class="col-md-9">'+
						'<a id="allSearchResults" role="button" data-toggle="popover" src="'+Location+'" href="#" '+
							' title="'+data[i].name+'" id="'+data[i].id+'" data-content=\'<img name="img" class="" src="' + thumb + '" '+
							' alt="' + data[i].description + '"  width="145" height="80">\'>'+
							'<span class="title" >' + data[i].name + '</span>'+
							'</a></div>'+
							'<div class="col-md-3" ><form><input type="hidden" name="link" id="link" value="' + Location + '"/>'+
							'<input type="hidden" name="name" id="name" value="' + data[i].name + '">'+							
							 '<input type="hidden" name="type" id="type" value="' + data[i].type + '">' +
						'<button type="submit"  id="addToFavorites" class="btn btn-danger"><i class="fa fa-star"></i></button>'+
						'</form></div></div></li>'+
						'<li role="separator" class="divider"></li>');					
						  jQuery('#liveSearchResults').append(object);
	                }	               

	            }
	        });

	    }
	    return false;
	}
	
		function getSearchFilters(){			
			searchFilter=[];  
			jQuery('span#filter').each(function(){
			searchFilter.push(jQuery(this).text());
			});				
			return searchFilter;
		}	

	jQuery(document).on("keyup", "input.search", function() {		
		var input=jQuery(this);
	    var searchType = jQuery(this).attr('id');
	    clearTimeout(jQuery.data(this, 'timer'));
	    var searchString = jQuery(this).val();
	    // Set Search String
	    switch (searchType) {
	        case 'all':
	            if (searchString == '') {

	                jQuery("ul.search-results-dropdown").fadeOut();
	            } else {

	                jQuery("ul.search-results-dropdown").fadeIn();
	                jQuery(this).data('timer', setTimeout(jsonAllSearch('allSearch',input), 100));
	            };
	            break;
	        case 'videos':
	            if (searchString == '') {
	                jQuery("div#searchResults").fadeOut();
	            } else {
	                jQuery("div#searchResults").fadeIn();
	                jQuery(this).data('timer', setTimeout(jsonAllSearch('videoSearch',input), 100));
	            };
	            break;
	        case 'documents':
	            // Do Search
	            if (searchString == '') {
	                jQuery("div#searchResults").fadeOut();
	            } else {
	                jQuery("div#searchResults").fadeIn();
	                jQuery(this).data('timer', setTimeout(jsonAllSearch('docSearch',input), 100));
	            };
	            break;
	        case 'simulators':
	            if (searchString == '') {
	                jQuery("div#searchResults").fadeOut();
	            } else {
	                jQuery("div#searchResults").fadeIn();
	                jQuery(this).data('timer', setTimeout(jsonAllSearch('simSearch',input), 100));
	            };
	            break;
	        default:
	            if (searchString == '') {
					jQuery('ul.search-results-dropdown').attr('style','display:none;');
	                jQuery("div#searchResults").fadeOut();
	            } else {
					jQuery('ul.search-results-dropdown').attr('style','');
	                jQuery("div#searchResults").fadeIn();
	                jQuery(this).data('timer', setTimeout(jsonAllSearch('allSearch',input), 100));
	            };
	            break;				
			}
	});   
var hideTimer = null;
	jQuery(document).on("focus", "input.search", function() {	
		if(jQuery('ul.search-results-dropdown li').length > 0){
			console.log('results are present');
			jQuery('ul.search-results-dropdown').fadeIn();
			    hideTimer = setTimeout(function() {
					jQuery('ul.search-results-dropdown').fadeOut();
				}, 3000);
		}
	});	
	

jQuery('.search-results-dropdown').bind('mouseleave', function() {
    hideTimer = setTimeout(function() {
      jQuery('ul.search-results-dropdown').fadeOut();
    }, 2000);
});

jQuery('.search-results-dropdown').bind('mouseenter', function() {
    if (hideTimer !== null) {
        clearTimeout(hideTimer);
    }
});