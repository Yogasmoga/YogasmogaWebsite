var _currenturl = window.location.href;
var _currentfullscreenid = '';
var _ismenuhovered = false;
var _isglobalsharinghovered = false;
var _isglobalsharingopen = false;
var _isglobalsharinganimating = false;
var _winW = 630, _winH = 460;//Window Width and Height respectively
var _headerHeight = 80;//Height of the global header
var _currentshareurl = '';//Share Url of the current page section
var _hovercollection = new Array(); //Contains Information about image switcher.
var _productorderqty = 0;//Order Quantity of the product
var _productcolorinfo = new Array();//Stores Information about different colors of a configurable product
var _rewardpointsearned = 0.1;//Reward Points Earned Per Dollar Spent
var _colorattributeid = '';//Color Attribute Id of the Product
var _sizeattributeid = '';//Size Attribute Id of the Product
var _lengthattributeid = '';// length Attribute Id of the Product
var _islengthavailable = 0; // check if length attribute is available
var _isoptionavailable = 0; // check if Bra option available
var _productid = ''; //Id of the product currently being displayed
var _productdisplaymode = 'page';//Product Display Mode ('popup' and 'page')
var _addingtocart = false; //Is Product being added to cart
var _minicartopen = false;
var _minicartdeleteid = '';
var _isdeletingcartitem = false;
var _dontclosecart = false;
var _minimumwindowwidth = 960;
var _disablesidenavigation = false;
var _isproductzoomed = false;
var _oldmousex = 0;
var _oldmousey = 0;
var _fabrictechnologyimage = '';
var _minzoomscale = 0;
var _howdoesitfithovered = false;
var _sizecharthovered = false;
var _curshippingstate = '';
var _curbillingstate = '';
var _checkoutmethod = 'guest';
var _stripesendaddressinfo = false;
var _stripevalidateccv = false;
var _ischeckoutprocessing = false;
var _isshippable = true;
var _usesecureurl = false;
var _cnfrewardpoint = 0;
var _rotateprimages = true;
var _currentproductid = '';
var _allowcheckoutexit = false;
var _canzoomimages = false;
var _curshareimgurl = '';
var _onipad = false;
var _checkoutdatachanged = false;
var _sizesuperattribute = true;
var _cursharetype = '';
var _cursharedesc = '';
var _curshareimg = new Array();
var _cursharesummary = '';
var _oncartpage = false;
var _enablediscounttype = '';
var _defaultprcolor = ''; //used for storing color info to be default selected when product detail page loads
var _isCheckoutSuccessPage = false;
var _orderNumberCheckout =  '';
var _orderRevenueCheckout = '';
var _isOnProductDetailPage = false; // check for product on product detail page
var _checksinghupformsubmit = false;
var _islogedinuser = false; // check if user is logged in
var _isClickShareWithFriends = false;  // check if click on share with friends
var _flagForShareFriends = false;
var _quickViewObjectPage = {}; // object variable to store quick view popup html
var _isClickAddtowishlist = false; // check user click on add to wish list because without login user can not add to wishlist
var _isClickShoppingbagSignin = false; // check user click on sign in via shopping bag
var _isClickApplySmogiBucks = false;
var _isClickSmogiLogin = false;
var _showShoppingbagLoader = true;
var _isClickSigninMenu = false; // check if user click on sign in from the drop down menu
var _isClickRemoveGiftYS = 1; // check if user click gift ys
var _isClickContinueNotLogedin = false; // check when click on continue checkout button on top of shopping bag
var _isClickSmogiBucksPageLogin = false;
var _isClickFooterWelcomeName = false;
var _isClickFooterTrackOrder = false;
var _redirectFromSingingPopup = null; // redirect from singing popup to track order or dashboard
var _braSelected = 0;
var _braOptionID = null;
var _braOptionTypeID = null;
var _footerLinkId = 1;
var _getGOYSFirstUser = 0; // check for First time user for GOYS
var _smogiPageLogin = false; // for the smogi bucks login
var _isEmptyShoppingBag = false; // set