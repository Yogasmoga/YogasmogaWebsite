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
			var count = arGiftIdCount[1];

			addToBag(giftId, count, jm(this).closest(".product_filters"));
		}
	});

	jm(".size").click(function(){

		jm(this).closest(".sizes").find(".size").removeClass("active-size");

		if(jm(this).hasClass("active-size"))
			jm(this).removeClass("active-size");
		else
			jm(this).addClass("active-size");

		if(jm(this).closest(".product_filters").find(".active-size").length==2) {
			jm(this).closest(".product_filters").find(".add_to_bag").addClass("bag-active");
			jm(this).closest(".product_filters").find(".add_to_bag").html('');
		}
		else {
			jm(this).closest(".product_filters").find(".add_to_bag").removeClass("bag-active");
			jm(this).closest(".product_filters").find(".add_to_bag").html('ADD TO BAG');
		}
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

jm(document).ready(function () {
    var wh = jm(window).height();
	jm('#fullpage').fullpage({

		css3:false,

        afterLoad: function (anchorLink, index) {
            currentCityIndex = jm(".contain_product.active").index()-1;
            showTemperature();
        },
        onLeave: function (anchorLink, index) {

			if (index == 2) {
				setTimeout(function(){
					jm(".map_data_section").addClass("fixed");
				},400);
			}
			if(index==1){
				setTimeout(function(){
					jm(".map_data_section").removeClass("fixed");
				},300);
			}
			jm(".product_set>div.side1").removeClass("inverse-flipped");
			jm(".product_set>div.side2").addClass("flipped");

        },
        afterResize: function () {
            wh = jm(window).height();
			jm("#fullpage .section,.fp-tableCell").height(wh - 89);
        }
    });

	jm("#fullpage .section,.fp-tableCell").height(wh - 89);


    init();

});


function init() {
	jm(".contain_product .side1 .buy_product, .product_set .side2 span.reverse_flip").click(function () {
		jm(this).closest(".product_set").find(".side1").toggleClass("inverse-flipped");
		jm(this).closest(".product_set").find(".side2").toggleClass("flipped");
	});

	jm(".toggle_description").click(function () {
		jm(this).closest(".product_set").find(".description_box").css({
			"bottom": 0
		});
	});
	jm(".close_desc").click(function () {
		jm(this).closest(".product_set").find(".description_box").css({
			"bottom": "-130px"
		});
	});

}


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
			jm(".time div").html(cityTimeValues[0]);

			jm(".flora p").html(cities[0] + " FLORA");
			jm(".fauna p").html(cities[0] + " FAUNA");

			firstTemperature = false;
		}
		else{
			if(currentCityIndex>=0) {
				jm(".temprature p").html(cities[currentCityIndex] + " TEMP");
				jm(".temprature div").html(temperatures[currentCityIndex]);

				jm(".latlong").html(latlongs[currentCityIndex]);

				jm(".time p").html(cities[currentCityIndex] + " TIME");
				jm(".time div").html(cityTimeValues[currentCityIndex]);

				jm(".flora p").html(cities[currentCityIndex] + " FLORA");
				jm(".fauna p").html(cities[currentCityIndex] + " FAUNA");
			}
			else{
				jm(".temprature p").html(cities[0] + " TEMP");
				jm(".temprature div").html(temperatures[0]);

				jm(".latlong").html(latlongs[0]);

				jm(".time p").html(cities[0] + " TIME");
				jm(".time div").html(cityTimeValues[0]);

				jm(".flora p").html(cities[0] + " FLORA");
				jm(".fauna p").html(cities[0] + " FAUNA");
			}
		}
	}
}

function addToBag(giftProductId, count, parent){
	_colorattributeid = 92;
	var currentProductColorCode = 216;

	var ar = Array();
	for(var i=0;i<count;i++){
		var size = parent.find("size-" + i + ".active").attr("rel");
		ar.push(size);
	}
console.log(ar);
	var productUrl = homeUrl + 'mycheckout/mycart/add?product=' + giftProductId;
	productUrl += '&qty=' + _productorderqty;
	productUrl += '&super_attribute[' + _colorattributeid + ']=' + currentProductColorCode;
	productUrl += '&type=gift';
//	productUrl = productUrl + '&super_attribute[' + _sizeattributeid + ']=' + currentProductSize;

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
