jQuery(function ($) {
	$(window).load(function(){

		var api = $.Jcrop('#cropbox',{
			setSelect: [ 0, 0, 940, 200 ],
			aspectRatio: 940 / 200,
			onChange: setCoords,
			onSelect: setCoords,
			boxWidth: 940
		});
		var i, ac;

		// A handler to kill the action
		function nothing(e)
		{
			e.stopPropagation();
			e.preventDefault();
			return false;
		};

		// Returns event handler for animation callback
		function anim_handler(ac)
		{
			return function(e) {
				api.animateTo(ac);
				return nothing(e);
			};
		};
		
		function setCoords(c)
			{
				$('#coordx').val(c.x);
				$('#coordy').val(c.y);
				$('#coordx2').val(c.x2);
				$('#coordy2').val(c.y2);
				$('#widht').val(c.w);
				$('#height').val(c.h);
			};
	});  
});