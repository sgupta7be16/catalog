(function($) {
    "use strict";

    /*
     * Prevent loading
     * roboto font family
     */
    var head = document.getElementsByTagName('head')[0];
    // Save the original method
    var insertBefore = head.insertBefore;
    // Replace it!
    head.insertBefore = function ( newElement, referenceElement ) {
        if ( newElement.href && newElement.href.indexOf('https://fonts.googleapis.com/css?family=Roboto') === 0 ) {
            console.info('Prevented Roboto from loading!');
            return;
        }
        insertBefore.call( head, newElement, referenceElement );
    };

    var map_ids = $("#sc-map-1, #sc-map-2, #sc-map-3, #sc-map-4");

    map_ids.each(function() {
        var map_height_lg = $(this).attr("data-map-height-lg"),
            map_height_xs = $(this).attr("data-map-height-xs");

        if ( $(window).width() <= 768 ) {
            map_ids.css( "height", map_height_xs );
        } else {
            map_ids.css( "height", map_height_lg );
        }
    });

    var latlong = new google.maps.LatLng( 23.751510, 90.386137 ),
        mapDefaultOptions = {
        // How zoomed in you want the map to start at (always required)
        zoom: 15,
        disableDefaultUI: false,
        scrollwheel: false,
        navigationControl: true,
        mapTypeControl: true,
        scaleControl: true,
        draggable: true,

        // The latitude and longitude to center the map (always required)
        center: latlong, // dhaka

        // How you would like to style the map. 
        styles: [{"featureType":"water","elementType":"geometry","stylers":[{"color":"#e9e9e9"},{"lightness":17}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":20}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#ffffff"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#ffffff"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":16}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":21}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#dedede"},{"lightness":21}]},{"elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#ffffff"},{"lightness":16}]},{"elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#333333"},{"lightness":40}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#f2f2f2"},{"lightness":19}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#fefefe"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#fefefe"},{"lightness":17},{"weight":1.2}]}]
    };
    
    function mapInit() {
            // For more options see: https://developers.google.com/maps/documentation/javascript/reference#MapOptions
        var mapOptions = mapDefaultOptions,

            // Get the HTML DOM element that will contain your map 
            // We are using a div with id="map-half" seen inside in the <body>
            mapElement = document.getElementById("map-half"),

            // Create the Google Map using our element and options defined above
            map = new google.maps.Map(mapElement, mapOptions);

        // Let's also add a marker while we're at it
        var marker = new google.maps.Marker({
            position: latlong,
            map: map,
            title: 'Materialist!'
        });
    }
    // When the window has finished loading create our google map below
    google.maps.event.addDomListener(window, 'load', mapInit);

    function sc_mape_1() {
        // For more options see: https://developers.google.com/maps/documentation/javascript/reference#MapOptions
        var mapOptions = mapDefaultOptions,

            // Get the HTML DOM element that will contain your map 
            // We are using a div with id="map-half" seen inside in the <body>
            mapElement = document.getElementById("sc-map-1"),

            // Create the Google Map using our element and options defined above
            map = new google.maps.Map(mapElement, mapOptions);

        // Let's also add a marker while we're at it
        var marker = new google.maps.Marker({
            position: latlong,
            map: map,
            title: 'Materialist!'
        });
    }
    // When the window has finished loading create our google map below
    google.maps.event.addDomListener(window, 'load', sc_mape_1);

    function sc_mape_2() {
        // For more options see: https://developers.google.com/maps/documentation/javascript/reference#MapOptions
        var mapOptions = mapDefaultOptions,

            // Get the HTML DOM element that will contain your map 
            // We are using a div with id="map-half" seen inside in the <body>
            mapElement = document.getElementById("sc-map-2"),

            // Create the Google Map using our element and options defined above
            map = new google.maps.Map(mapElement, mapOptions);

        // Let's also add a marker while we're at it
        var marker = new google.maps.Marker({
            position: latlong,
            map: map,
            title: 'Materialist!'
        });
    }
    // When the window has finished loading create our google map below
    google.maps.event.addDomListener(window, 'load', sc_mape_2);

    function sc_mape_3() {
        // For more options see: https://developers.google.com/maps/documentation/javascript/reference#MapOptions
        var mapOptions = mapDefaultOptions,

            // Get the HTML DOM element that will contain your map 
            // We are using a div with id="map-half" seen inside in the <body>
            mapElement = document.getElementById("sc-map-3"),

            // Create the Google Map using our element and options defined above
            map = new google.maps.Map(mapElement, mapOptions);

        // Let's also add a marker while we're at it
        var marker = new google.maps.Marker({
            position: latlong,
            map: map,
            title: 'Materialist!'
        });
    }
    // When the window has finished loading create our google map below
    google.maps.event.addDomListener(window, 'load', sc_mape_3);

    function sc_mape_4() {
        // For more options see: https://developers.google.com/maps/documentation/javascript/reference#MapOptions
        var mapOptions = mapDefaultOptions,

            // Get the HTML DOM element that will contain your map 
            // We are using a div with id="map-half" seen inside in the <body>
            mapElement = document.getElementById("sc-map-4"),

            // Create the Google Map using our element and options defined above
            map = new google.maps.Map(mapElement, mapOptions);

        // Let's also add a marker while we're at it
        var marker = new google.maps.Marker({
            position: latlong,
            map: map,
            title: 'Materialist!'
        });
    }
    // When the window has finished loading create our google map below
    google.maps.event.addDomListener(window, 'load', sc_mape_4);

})(jQuery);