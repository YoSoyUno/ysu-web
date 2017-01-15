define(['jquery', 'elgg', 'jqplot/jquery.jqplot'], function($, elgg) {
	
	var init = function () {
		require(['jqplot/plugins/jqplot.pieRenderer', 
		 		'jqplot/plugins/jqplot.barRenderer', 
		 		'jqplot/plugins/jqplot.categoryAxisRenderer', 
		 		'jqplot/plugins/jqplot.canvasAxisTickRenderer', 
		 		'jqplot/plugins/jqplot.canvasTextRenderer', 
		 		'jqplot/plugins/jqplot.dateAxisRenderer', 
		 		'jqplot/plugins/jqplot.pointLabels', 
		 		'jqplot/plugins/jqplot.highlighter' ], function() {
		 			
			// initialize the plots
			$('.advanced-statistics-plot-container').each(function(){
		
				var target = $(this).attr('id');
				var parts = target.split('-');
				var chart_id = new Array();
		
				if (!$.jqplot) {
					$('#'+ target).html(elgg.echo('advanced_statistics:widgets:advanced_statistics:content:no_jqplot'));
					$('#'+ target).next().hide();
					return;
				}
				
				for(var i = 3; i < parts.length; i++){
					chart_id.push(parts[i]);
				}
		
				chart_id = chart_id.join('-');
				
				elgg.getJSON('advanced_statistics/' + parts[2] + '/' + chart_id, {
					success: function(result){
						var options = result.options;
						if(options['seriesDefaults']){
							options['seriesDefaults']['renderer'] = eval(options['seriesDefaults']['renderer']);
						}
						if(options['axes']){
							if(options['axes']['xaxis']){
								options['axes']['xaxis']['renderer'] = eval(options['axes']['xaxis']['renderer']);
								options['axes']['xaxis']['tickRenderer'] = eval(options['axes']['xaxis']['tickRenderer']);
							}
							if(options['axes']['yaxis']){
								options['axes']['yaxis']['renderer'] = eval(options['axes']['yaxis']['renderer']);
							}
							if(options['axes']['y2axis']){
								options['axes']['y2axis']['renderer'] = eval(options['axes']['y2axis']['renderer']);
							}
						}
						if(options['axesDefaults']){
							options['axesDefaults']['tickRenderer'] = eval(options['axesDefaults']['tickRenderer']);
						}
						
						if(result.data[0].length){
							$.jqplot(target, result.data, options);
						} else {
							$('#'+ target).html(elgg.echo('notfound'));
						}
						// hide loader
						$('#'+ target).next().hide();
					}
				});
			});
		});
	};

	init();

	return {
		init: init
	};
});