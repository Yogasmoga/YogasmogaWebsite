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

var arBundledProductSmallImages = {};
var arBundledProductBigImages = {};
var arThumbnailImages = {};

var firstTemperature = true;

var wh=0;
jm(document).ready(function() {

    var viewAllLink = "<li class='gift'><a href=''>View All</a></li>";
    jm("ul.main-menu > li.gift-sets > ul.sub-menu>li>ul").append(viewAllLink);

    getWeather(); //Get the initial weather.
	//setInterval(getWeather, 300000);		// every 5 minutes
	setInterval(updateTimes, 60000);		// every 1 minute

	initializeBanner();

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

	jm(".outofstock img").show();

	jm(".size").click(function(){

		jm(this).closest(".sizes").find(".size").removeClass("active-size");

		if(jm(this).hasClass("outofstock"))
			return;

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

	var personType = getParameterByName('style');
	if(personType!=undefined){

		if(personType=='men' || personType=='women')
			filterGiftSet(personType);
	}


	var slideId = getParameterByName('id');
	if(slideId!=undefined){
		jQuery(".gift_set_link[rel='" + slideId + "']").click();
	}


    jQuery("ul.main-menu > li.gift-sets > ul.sub-menu>li>ul").find(".gift a").click(function (e) {
		e.preventDefault();

		var personType = jQuery(this).text().toLowerCase();

		filterGiftSet(personType);
	});

	jQuery(".thumbnail").click(function(){

		var previousQuickLookImage = jQuery(this).closest(".product_container").find(".slider").find("img").attr('src');

		var imageSrc = jQuery(this).find("img").attr('src');

		jQuery(this).closest(".product_container").find(".slider").find("img").attr('src', imageSrc);

		jQuery(this).find("img").attr('src', previousQuickLookImage);
	});
	updateTimes();
});

function filterGiftSet(personType){

	if(personType=="view all"){
		jQuery(".gift_set_link").removeClass('active');
		jQuery(".person_women:eq(0)").addClass('active');

		jQuery(".gift_set_link").show();
		jQuery(".contain_product").show();
	}
	else{
		jQuery(".gift_set_link").hide();
		jQuery(".contain_product").hide();
		jQuery(".person_" + personType).show();

		jQuery(".gift_set_link").removeClass('active');
		jQuery(".person_" + personType + ":first-child").addClass('active');
	}
	getActiveSlide();
}

function initializeBanner(){

	var str = "<p>YOGASMOGA 2015 Holiday Giftsets: Available Until 12.30.2015</p>";

	jQuery(".golden-banner").html(str);

	jQuery(".namaskar-overlay1").css("top","94px");
	jQuery(".ui-widget-overlay").css({"top":"94px","position":"fixed"});
	jQuery(".ui-widget-overlay").css({top:94});
	jQuery(".header-container").css("padding-top", "25px");
	jQuery(".header-container").css("top", "0");
	jQuery("#bodycompensator").css("height", "94px");
}

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
			temperatures[0] =  "<span class='temp icon-"+weather.code+"'></span>" + weather.temp + '&deg;' + weather.units.temp;
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

			temperatures[1] =  "<span class='temp icon-"+weather.code+"'></span>" + weather.temp+'&deg;'+weather.units.temp;
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

			temperatures[2] =  "<span class='temp icon-"+weather.code+"'></span>" + weather.temp+'&deg;'+weather.units.temp;
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

			temperatures[3] =  "<span class='temp icon-"+weather.code+"'></span>" + weather.temp+'&deg;'+weather.units.temp;
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
			console.debug(weather);
			temperatures[4] =  "<span class='temp icon-"+weather.code+"'></span>" + weather.temp+'&deg;'+weather.units.temp;
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

			temperatures[5] =  "<span class='temp icon-"+weather.code+"'></span>" + weather.temp+'&deg;'+weather.units.temp;
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

			temperatures[6] =  "<span class='temp icon-"+weather.code+"'></span>" + weather.temp+'&deg;'+weather.units.temp;
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
			temperatures[7] =  "<span class='temp icon-"+weather.code+"'></span>" + weather.temp+'&deg;'+weather.units.temp;
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

			//jm(".flora p").html(cities[0] + " FLORA");
			//jm(".fauna p").html(cities[0] + " FAUNA");

			firstTemperature = false;
		}
		else{
			if(currentCityIndex>=0) {
				jm(".temprature div").html(temperatures[currentCityIndex]);

				jm(".latlong").html(latlongs[currentCityIndex]);

				var tempTime = cityTimeValues[currentCityIndex];

				if(tempTime!=undefined) {
					var tempTimeNoAM_PM = tempTime.substr(0, tempTime.indexOf(" "));

					if (tempTime.indexOf("a") > -1 || tempTime.indexOf("A") > -1)
						jm(".time div").html(tempTimeNoAM_PM + "<span class='am'></span>");
					else
						jm(".time div").html(tempTimeNoAM_PM + "<span class='pm'></span>");
				}

				//jm(".flora p").html(cities[currentCityIndex] + " FLORA");
				//jm(".fauna p").html(cities[currentCityIndex] + " FAUNA");
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

				//jm(".flora p").html(cities[0] + " FLORA");
				//jm(".fauna p").html(cities[0] + " FAUNA");
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

	parent.find(".add_to_bag").html("Adding...");

	jm.ajax({
		type: 'POST',
		url: productUrl,
		data: {},
		success: function (result) {

			result = eval('(' + result + ')');

			if(result.status=="success") {
				jm(".sizes").find(".size").removeClass("active-size");
				jm(".add_to_bag").removeClass("bag-active");
				jm(".add_to_bag").html('ADD TO BAG');

				jm("div#myminicart").html(result.html);
				showShoppingBagHtmlOpen();
				parent.find(".add_to_bag").html("ADD TO BAG");
			}
			else if(result.status=="exists"){
				jm(".sizes").find(".size").removeClass("active-size");
				jm(".add_to_bag").removeClass("bag-active");
				jm(".add_to_bag").html('ADD TO BAG');

				parent.find(".add_to_bag").html("ADD TO BAG");
				//showShoppingBagHtmlOpen();
				jQuery(".gift-set-sorry-popup").show();
				jQuery(".gift-set-sorry-popup").find(".message").html("To order more than 1 of the same set, please place a separate order.");
			}
			else{
				jm(".sizes").find(".size").removeClass("active-size");
				jm(".add_to_bag").removeClass("bag-active");
				jm(".add_to_bag").html('ADD TO BAG');

				parent.find(".add_to_bag").html("ADD TO BAG");
				//showShoppingBagHtmlOpen();
				jQuery(".gift-set-sorry-popup").show();
				jQuery(".gift-set-sorry-popup").find(".message").html("This product is out of stock.");
			}
		}
	});
}

function getParameterByName(name) {
	name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
	var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
		results = regex.exec(location.search);
	return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}