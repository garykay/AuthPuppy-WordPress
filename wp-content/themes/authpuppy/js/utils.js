
/* Open and close the map */

$(function() {
	$('#openmap a').toggle(function () {
				$('#map').animate({ height: "400px"}, 500);
				$('#openmap').addClass('up');
				$('#authutilsnav').addClass('up');
				$('#map_outer_wrapper').show();
 			},function(){
				$('#map').animate({ height: "0px"}, 250);
				$('#openmap').removeClass('up');
				$('#authutilsnav').removeClass('up');
				$('#map_outer_wrapper').hide();
	});
	
	$("#map_trigger").click(function () {
		$('#openmap_trigger').click();
	});
	
	return false;
	});