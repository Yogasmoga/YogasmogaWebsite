var jm = jQuery.noConflict();

var cities = Array();
var temperatures = Array();
var currentCityIndex = 0;
var temperaturesLoaded = true;

var wh=0;
jm(document).ready(function() {
	getWeather(); //Get the initial weather.
	setInterval(getWeather, 60000);		// every 1 minute

	wh = jm(window).height();
	jm('#fullpage').fullpage({

		afterLoad: function(anchorLink, index){
			
			currentCityIndex = jm(".combos.active").index();
			showTemperature();
		},

		afterResize: function(){
			jm("#fullpage .section").height(wh - 250);
		}
	});

	jm("#fullpage .section").height(wh - 250);
});

function getWeather(){

	jm.simpleWeather({
		location: cities[0],
		woeid: '',
		unit: 'f',
		success: function(weather) {

		  temperatures[0] = weather.temp+'&deg;'+weather.units.temp;
		  temperaturesLoaded = temperaturesLoaded && temperatures[0]!=0;
		  
		  showTemperature();
		},
		error: function(error) {
		  temperatures[0] = "N/A";
		}
	});

	jm.simpleWeather({
		location: cities[1],
		woeid: '',
		unit: 'f',
		success: function(weather) {

		  temperatures[1] = weather.temp+'&deg;'+weather.units.temp;
		  temperaturesLoaded = temperaturesLoaded && temperatures[1]!=0;
		  
		  showTemperature();
		},
		error: function(error) {
		  temperatures[1] = "N/A";
		}
	});
	
	jm.simpleWeather({
		location: cities[2],
		woeid: '',
		unit: 'f',
		success: function(weather) {

		  temperatures[2] = weather.temp+'&deg;'+weather.units.temp;
		  temperaturesLoaded = temperaturesLoaded && temperatures[2]!=0;
		  
		  showTemperature();
		},
		error: function(error) {
		  temperatures[2] = "N/A";
		}
	});
	
	jm.simpleWeather({
		location: cities[3],
		woeid: '',
		unit: 'f',
		success: function(weather) {

		  temperatures[3] = weather.temp+'&deg;'+weather.units.temp;
		  temperaturesLoaded = temperaturesLoaded && temperatures[3]!=0;
		  
		  showTemperature();
		},
		error: function(error) {
		  temperatures[3] = "N/A";
		}
	});
	
}

function showTemperature(){
	
	if(temperaturesLoaded)
		jm("#weather").html(cities[currentCityIndex] + " => " + temperatures[currentCityIndex]);
}

jm(window).resize(function(){

	wh = jm(window).height();
});