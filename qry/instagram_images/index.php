<!DOCTYPE HTML>
<html>
<head>
    <script type="text/javascript" src="angular.js"></script>
    <script type="text/javascript" src="app.js"></script>
</head>
<body ng-app="instagramApp">
<div class="row" ng-controller="instagramController as instagram">
    <form ng-submit="form.$valid && instagram.submit()" novalidate name="form">
        <input type="text" ng-model="instagram.hastag1" placeholder="Primary HashTag" required />
        <input type="text" ng-model="instagram.hastag2" placeholder="Secondary HashTag"  />
        <input type="submit" value="GO !" />
    </form>

    <div class="row">
        <div class="span3" ng-repeat="images in instagram.images">
            <img class="row" ng-src="{{images.url}}"/>
            <label>{{images.username}}</label>
        </div>
    </div>
    <div class="row a-center">
        <button class="load-more" ng-click="instagram.next()" ng-show="instagram.nextPage">Load Next Images</button>
        <p ng-hide="instagram.noImages">Thats all folks...No more images to display.</p>
    </div>
</div>

<style>
    .row{
        width: 100%;
        float: left;
        box-sizing: border-box;
    }
    .span3 {
        width: 25%;
        float: left;
        box-sizing: border-box;
        padding: 5px;
    }
    .a-center{
        text-align: center;
    }
    .load-more{
        background: #00B900;
        color: #fff;
        font-size: 15px;
        padding: 7px 20px;
        margin: 20px 50px;
    }
    video{
        background: #000;
    }
</style>
</body>
</html>

