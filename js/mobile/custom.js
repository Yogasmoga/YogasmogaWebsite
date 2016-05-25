jQuery.noConflict();
jQuery(window).load(function() {
 jQuery('.flexslider').flexslider({
	animation: "slide"
  });
});

function isValidPostalCode(zip, countryCode) {
 switch (countryCode) {
  case "US":
   re = /^([A-z0-9]{5,10})$/;
   break;
  default:
   var re = /(^[A-z0-9]{2,10}([\s]{0,1}|[\-]{0,1})[A-z0-9]{2,10}$)/;
 }
 return re.test(zip);
}