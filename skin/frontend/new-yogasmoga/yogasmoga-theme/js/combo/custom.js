var jm = jQuery.noConflict();

var cities = Array();
var temperatures = Array();
var latlongs = Array();
var cityTimes = Array();
var cityTimeValues = Array();

var currentCityIndex = 0;

var temperaturesLoaded = true;
var temperature1Loaded = true;
var temperature2Loaded = true;

var firstTemperature = true;

var wh=0;
jm(document).ready(function() {
	getWeather(); //Get the initial weather.
	//setInterval(getWeather, 300000);		// every 5 minutes
	setInterval(updateTimes, 60000);		// every 1 minute

	jm(".header-container").css('top','20px');

	jm(".add_to_bag").click(function(){

		if(jm(this).hasClass("bag-active")) {

			var giftIdCount = jm(this).attr('rel');

			var arGiftIdCount = giftIdCount.split(':');

			var giftId = arGiftIdCount[0];
			var currentProductColorCode = arGiftIdCount[1];
			var count = arGiftIdCount[2];

			addToBag(giftId, count, jm(this).closest(".product_filters"), currentProductColorCode);
		}
	});

	jm(".size").click(function(){

		jm(this).closest(".sizes").find(".size").removeClass("active-size");

		if(jm(this).hasClass("active-size"))
			jm(this).removeClass("active-size");
		else
			jm(this).addClass("active-size");

		var totalSetProducts = jm(this).closest(".product_filters").find(".set_item").length;

		if(jm(this).closest(".product_filters").find(".active-size").length==totalSetProducts) {
			jm(this).closest(".product_filters").find(".add_to_bag").addClass("bag-active");
//			jm(this).closest(".product_filters").find(".add_to_wishlist").addClass("bag-active");
		}
		else {
			jm(this).closest(".product_filters").find(".add_to_bag").removeClass("bag-active");
//			jm(this).closest(".product_filters").find(".add_to_wishlist").removeClass("bag-active");
		}
	});


	jQuery(".gift").click(function(){
		var personType = jQuery(this).text().toLowerCase();

		jQuery(".gift_set_link").hide();
		jQuery(".person." + personType).show();
	});

	updateTimes();
});

function updateTimes(){

	var city_times = cityTimes.join();

	jm.ajax({
		url: homeUrl + 'ys/utility/citytime',
		type: 'GET',
		data: 'city_times=' + city_times,
		dataType: 'json',
		success: function(result){

			if(result!=undefined && result.message!=undefined){

				if(result.message.indexOf("found")>-1 && result.times!=undefined) {
					cityTimeValues = Array();

					for (var i = 0; i < result.times.length; i++) {
						cityTimeValues[i] = result.times[i];
					}

					showTemperature();
				}
			}
		}
	});
}

//currentCityIndex = jm(".contain_product.active").index()-1;
//showTemperature();

function getWeather(){

	jm.simpleWeather({
		location: cities[0],
		woeid: '',
		unit: 'f',
		success: function (weather) {
			temperatures[0] = weather.temp + '&deg;' + weather.units.temp;
			temperature1Loaded = true;

			checkTemperaturesLoaded();
		},
		error: function (error) {
			temperatures[0] = "N/A";
		}
	});

	jm.simpleWeather({
		location: cities[1],
		woeid: '',
		unit: 'f',
		success: function(weather) {

			temperatures[1] = weather.temp+'&deg;'+weather.units.temp;
			temperature2Loaded = true;

			checkTemperaturesLoaded();
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
			temperature3Loaded = true;

			checkTemperaturesLoaded();
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
			temperature4Loaded = true;

			checkTemperaturesLoaded();
		},
		error: function(error) {
			temperatures[3] = "N/A";
		}
	});

	jm.simpleWeather({
		location: cities[4],
		woeid: '',
		unit: 'f',
		success: function(weather) {

			temperatures[4] = weather.temp+'&deg;'+weather.units.temp;
			temperature5Loaded = true;

			checkTemperaturesLoaded();
		},
		error: function(error) {
			temperatures[4] = "N/A";
		}
	});

	jm.simpleWeather({
		location: cities[5],
		woeid: '',
		unit: 'f',
		success: function(weather) {

			temperatures[5] = weather.temp+'&deg;'+weather.units.temp;
			temperature6Loaded = true;

			checkTemperaturesLoaded();
		},
		error: function(error) {
			temperatures[5] = "N/A";
		}
	});

	jm.simpleWeather({
		location: cities[6],
		woeid: '',
		unit: 'f',
		success: function(weather) {

			temperatures[6] = weather.temp+'&deg;'+weather.units.temp;
			temperature7Loaded = true;

			checkTemperaturesLoaded();
		},
		error: function(error) {
			temperatures[6] = "N/A";
		}
	});

	jm.simpleWeather({
		location: cities[7],
		woeid: '',
		unit: 'f',
		success: function(weather) {

			temperatures[7] = weather.temp+'&deg;'+weather.units.temp;
			temperature8Loaded = true;

			checkTemperaturesLoaded();
		},
		error: function(error) {
			temperatures[7] = "N/A";
		}
	});
}

function checkTemperaturesLoaded(){
	temperaturesLoaded =
		temperature1Loaded &&
		temperature1Loaded;

	if(temperaturesLoaded)
		showTemperature();
}

function showTemperature(){

	if(temperaturesLoaded) {

		if(currentCityIndex<0) currentCityIndex=0;

		if(firstTemperature){
			jm(".temprature p").html(cities[0] + " TEMP");
			jm(".temprature div").html(temperatures[0]);

			jm(".latlong").html(latlongs[0]);

			jm(".time p").html(cities[0] + " TIME");

			var tempTime = cityTimeValues[0];
			if(tempTime!=undefined) {
				var tempTimeNoAM_PM = tempTime.substr(0, tempTime.indexOf(" "));

				if (tempTime.indexOf("a") > -1 || tempTime.indexOf("A") > -1)
					jm(".time div").html(tempTimeNoAM_PM + "<span class='am'></span>");
				else
					jm(".time div").html(tempTimeNoAM_PM + "<span class='pm'></span>");
			}

			jm(".flora p").html(cities[0] + " FLORA");
			jm(".fauna p").html(cities[0] + " FAUNA");

			firstTemperature = false;
		}
		else{
			if(currentCityIndex>=0) {
				jm(".temprature div").html("<span class='temp'></span> " + temperatures[currentCityIndex]);

				jm(".latlong").html(latlongs[currentCityIndex]);

				var tempTime = cityTimeValues[currentCityIndex];

				if(tempTime!=undefined) {
					var tempTimeNoAM_PM = tempTime.substr(0, tempTime.indexOf(" "));

					if (tempTime.indexOf("a") > -1 || tempTime.indexOf("A") > -1)
						jm(".time div").html(tempTimeNoAM_PM + "<span class='am'></span>");
					else
						jm(".time div").html(tempTimeNoAM_PM + "<span class='pm'></span>");
				}

				jm(".flora p").html(cities[currentCityIndex] + " FLORA");
				jm(".fauna p").html(cities[currentCityIndex] + " FAUNA");
			}
			else{
				jm(".temprature div").html(temperatures[0]);

				jm(".latlong").html(latlongs[0]);

				var tempTime = cityTimeValues[0];
				if(tempTime!=undefined) {
					tempTime = tempTime.substr(0, tempTime.indexOf(" "));

					if (tempTime.indexOf("a") > -1 || tempTime.indexOf("A") > -1)
						jm(".time div").html(tempTime + "<span class='am'></span>");
					else
						jm(".time div").html(tempTime + "<span class='pm'></span>");
				}

				jm(".flora p").html(cities[0] + " FLORA");
				jm(".fauna p").html(cities[0] + " FAUNA");
			}
		}
	}
}

function addToBag(giftProductId, count, parent, currentProductColorCode){
	var colorAttributeId = 92;
	var sizeAttributeId = 138;

	var ar = Array();
	for(var i=0;i<count;i++){
		var size = parent.find(".size-" + i + ".active-size").attr("rel");
		var size_data = sizeAttributeId + "-" + size;
		var color_data = colorAttributeId + "-" + parent.find(".product-color-" + i).attr("rel");
		var product_id = parent.find(".product-detail-" + i).attr("rel");
		ar.push(product_id + ":" + color_data + ":" + size_data);
	}

	var bundle_data = ar.join();

	var productUrl = homeUrl + 'mycheckout/mycart/add?product=' + giftProductId;
	productUrl += '&qty=' + _productorderqty;
	productUrl += '&super_attribute[' + colorAttributeId + ']=' + currentProductColorCode;
	productUrl += '&type=gift';
	productUrl += '&bundle=' + bundle_data;

	productUrl += '&showhtml=0';

	jm("#addtobagloader").show();

	jm.ajax({
		type: 'POST',
		url: productUrl,
		data: {},
		success: function (result) {
			jm(".sizes").find(".size").removeClass("active-size");
			jm(".add_to_bag").removeClass("bag-active");
			jm(".add_to_bag").html('ADD TO BAG');

			jm("#addtobagloader").show();
			jm("div#myminicart").html(result.html);
			showShoppingBagHtmlOpen();
		}
	});
}
