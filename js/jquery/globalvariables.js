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