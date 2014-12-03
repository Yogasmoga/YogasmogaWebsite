{% capture collection_handle %}{{ product-loop | handleize }}{% endcapture %}
{% capture url %}{% if collection_handle != "" %}/collections/{{ product-loop }}{{ product.url }}{% else %}{{ product.url }}{% endif %}{% endcapture %}

{% if settings.products_per_row == '3' %}{% assign product_span_size = 'span4' %}{% endif %}
{% if settings.products_per_row == '4' %}{% assign product_span_size = 'span3' %}{% endif %}
{% if template == 'index' %}
{% if collections[collection_handle].products.size == 4 %}{% assign product_span_size = 'span4' %}{% endif %}
{% if collections[collection_handle].products.size == 5 %}{% assign product_span_size = 'span3' %}{% endif %}
{% endif %}

{% assign travelSize = false %}
{% for variant in product.variants %}
{% if variant.metafields.trb.travel_size != "0" %}
{% assign travelSize = true %} {%break%}{% endif %}
{% endfor %}

<form action="/cart/add" class="foxycart" method="post" id="{{ product.id }}">
<!--<div class="addToCartInformation">-->
    {% for variant in product.variants limit:1 %}
    <input type="hidden" name="id" value="{{ variant.id }}" id="var_id">
    {% endfor %}


    {% if travelSize == true %}
    <div class="item travelSized" style="height:auto;">
        {%else%}
        <div class="item nonTravelSized">  
            {%endif%}

            <span class="travelSizeIconHolder"></span>

            {% if product.price_min < product.compare_at_price_min %}
            <span class="circle sale">Sale</span>
            {% endif %}

            <a href="{{ url }}">
                <img src="{{ product.featured_image | product_img_url: 'medium' }}" alt="{{ product.title | escape  }}" />
            </a>

            <div class="itemDescription" style="height:auto;">
                <a href="{{ url }}" class="clearfix">

                    <span class="shopify-product-reviews-badge" data-id="{{ product.id }}"></span>
                    <span class="bandName">
                        <strong class="productBrand">{{ product.vendor }}</strong>
                        <span class="productName">{{ product.title }}</span>

                        {% assign product_country = "nowhere" %}
                        {% assign countries = shop.metafields.trb.all_countries | split: ',' %}

                        {% for country in countries %}
                        {% if shop.metafields.trb_country_brands.[country] contains product.vendor %}
                        {% capture product_country %}{{country | replace: "_"," "}}{% endcapture %}		
                        {%break %}
                        {% endif %}
                        {% endfor %}

                        <span class="countryNameList">From {{product_country}}</span>
                    </span>    

                    <span class="productPrice">
                        {% if product.available %}
                        {% if product.compare_at_price_max > product.price %}
                        <del>{{ product.compare_at_price | money }}</del>
                        {% endif %}
                        {% if product.price_varies %}
                        <small><em>from</em></small>
                        {% endif %}
                        {{ product.price | money }}
                        {% else %}
                        {{ product.price | money }} Sold Out
                        {% endif %}
                    </span>
                    <!-- /.productPrice -->

          <!-- <span class="shopify-product-reviews-badge" data-id="{{ product.id }}"></span> -->
                </a>
                <div class="clear"></div>
            </div>
            <!-- /.itemDescription -->

            <div class="quantityDropdownWrapper" style="float: right; margin-top: 11px; width: 50px; margin-right: 10px;">
                <select name="quantity" style="width:100%;">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>
            <button class="addtocart productPageAddToCart" type="submit" style="float: left; margin: 10px 0px 0px 9px;">Add to cart</button>      
            <div class="cart-animation" style="display:none;left:113px !important;">1</div>
            {% for variant in product.variants limit:1 %}
            {% unless variant.metafields.trb.travel_size == '0' %}
            <span class="icon_travel"></span> 
            {% endunless %}
            {% endfor %}


        </div>
        <!-- /.item 
    </div>
</div>-->
</form>

{% unless homepage %}
{% if product_span_size == 'span4' %}{% cycle 'clear-product-loop': '', '', '<div style="clear:both;"></div>' %}{% endif %}
{% if product_span_size == 'span3' %}{% cycle 'clear-product-loop': '', '', '', '<div style="clear:both;"></div>' %}{% endif %}
{% endunless %}