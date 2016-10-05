(function($){
    var map;
    var geocoder;
    var address = "100 East St S, Sarnia, ON";
    
    $(function(){
            $("#widgets-right").append("<div id='contact-map'></div>");
            mapInit();
    });

    function mapInit()
    {
        geocoder = new google.maps.Geocoder();
        var mapOptions = {
            zoom: 16,
            scrollwheel: false,
            draggable: false, 
            disableDefaultUI: true,
            styles: [
                {
                    "featureType": "all",
                    "elementType": "geometry",
                    "stylers": [
                        { 
                            "color": "#dce4e9"
                        }
                    ]
                },
                {
                    "featureType": "all",
                    "elementType": "labels.text.fill",
                    "stylers": [
                        {
                            "gamma": 0.01
                        },
                        {
                            "lightness": 20
                        }
                    ]
                },
                {
                    "featureType": "all",
                    "elementType": "labels.text.stroke",
                    "stylers": [
                        {
                            "saturation": -31
                        },
                        {
                            "lightness": -33
                        },
                        {
                            "weight": 2
                        },
                        {
                            "gamma": 0.8
                        }
                    ]
                },
                {
                    "featureType": "all",
                    "elementType": "labels.icon",
                    "stylers": [
                        {
                            "visibility": "off"
                        }
                    ]
                },
                {
                    "featureType": "landscape",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "lightness": 30
                        },
                        {
                            "saturation": 30
                        }
                    ]
                },
                {
                    "featureType": "poi",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "saturation": 20
                        }
                    ]
                },
                {
                    "featureType": "poi.park",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "lightness": 20
                        },
                        {
                            "saturation": -20
                        }
                    ]
                },
                {
                    "featureType": "road",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "lightness": 10
                        },
                        {
                            "saturation": -30
                        }
                    ]
                },
                {
                    "featureType": "road",
                    "elementType": "geometry.fill",
                    "stylers": [
                        {
                            "color": "#ffffff"
                        }
                    ]
                },
                {
                    "featureType": "road",
                    "elementType": "geometry.stroke",
                    "stylers": [
                        {
                            "saturation": 25
                        },
                        {
                            "lightness": 25
                        },
                        {
                            "color": "#d2d2d2"
                        }
                    ]
                },
                {
                    "featureType": "road",
                    "elementType": "labels.text.fill",
                    "stylers": [
                        {
                            "hue": "#ff0000"
                        }
                    ]
                },
                {
                    "featureType": "road",
                    "elementType": "labels.text.stroke",
                    "stylers": [
                        {
                            "color": "#ffffff"
                        }
                    ]
                },
                {
                    "featureType": "water",
                    "elementType": "all",
                    "stylers": [
                        {
                            "lightness": -20
                        }
                    ]
                }
            ]
        }
        map = new google.maps.Map(document.getElementById('contact-map'), mapOptions);

        showMap(address);
        showMarker();
    }

    function showMarker()
    {
        getAddressLatLng(address, showMarkerLatLng);
    }
    function showMarkerLatLng(latlng, address)
    {
        var marker = new google.maps.Marker({
            map: map,
            position: latlng,
            Class: 'marker',
            icon: {
                url: "/sites/all/themes/LABE/images/icon-mapmarker-2x.png",
                scaledSize: new google.maps.Size(22, 31),
                origin: new google.maps.Point(0, 0),
                anchor: new google.maps.Point(22, 31)
            },
            optimized: false
        });

        var infowindow = new google.maps.InfoWindow({
            content: "<p class='map-info'>100 East Street South,<br/> Sarnia, Ontario<br/>N7T 6X2</p>",
            maxWidth: 200
        });
        google.maps.event.addListener(marker, 'click', function() {
            infowindow.open(map, marker);
            $(".gmap [style*='skewX']").css("background","#106232");
            $(".gmap").find('div[style*="rgb(255, 255, 255)"]').filter(function () { return this.innerHTML == "" }).css("background","#106232")
        });
    }
    function showMap(address)
    {
        getAddressLatLng(address, showMapLatLng);
    }
    function showMapLatLng(latlng)
    {
        map.setCenter(latlng);
    }

    function getAddressLatLng(address, callback)
    {
        geocoder.geocode( {'address':address}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK)
            {
                callback(results[0].geometry.location, address);
            }
        });
    }
})(jQuery);