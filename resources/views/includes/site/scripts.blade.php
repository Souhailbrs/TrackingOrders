<!-- map api -->
<script src='https://maps.googleapis.com/maps/api/js?key=AIzaSyDMjWSDG4QO9RnoYOsLOKITmRLbkg6B5TM'></script>
<!-- plugin js scripts -->
<script src='{{asset('assets/site/js/plugins.js')}}'></script>
<!-- app js -->
<script src='{{asset('assets/site/js/app.js')}}'></script>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>

<script>
    var myCenter = new google.maps.LatLng(23.8294748, 90.3845342);

    function initialize() {
        var mapProp = {
            center: myCenter,
            scrollwheel: false,
            zoom: 4,
            zoomControl: true,
            mapTypeControl: true,
            streetViewControl: true,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            styles: [{
                'featureType': 'water',
                'elementType': 'geometry',
                'stylers': [{
                    'color': '#e9e9e9'
                },
                    {
                        'lightness': 17
                    }
                ]
            },
                {
                    'featureType': 'landscape',
                    'elementType': 'geometry',
                    'stylers': [{
                        'color': '#f5f5f5'
                    },
                        {
                            'lightness': 20
                        }
                    ]
                },
                {
                    'featureType': 'road.highway',
                    'elementType': 'geometry.fill',
                    'stylers': [{
                        'color': '#ffffff'
                    },
                        {
                            'lightness': 17
                        }
                    ]
                },
                {
                    'featureType': 'road.highway',
                    'elementType': 'geometry.stroke',
                    'stylers': [{
                        'color': '#ffffff'
                    },
                        {
                            'lightness': 29
                        },
                        {
                            'weight': 0.2
                        }
                    ]
                },
                {
                    'featureType': 'road.arterial',
                    'elementType': 'geometry',
                    'stylers': [{
                        'color': '#ffffff'
                    },
                        {
                            'lightness': 18
                        }
                    ]
                },
                {
                    'featureType': 'road.local',
                    'elementType': 'geometry',
                    'stylers': [{
                        'color': '#ffffff'
                    },
                        {
                            'lightness': 16
                        }
                    ]
                },
                {
                    'featureType': 'poi',
                    'elementType': 'geometry',
                    'stylers': [{
                        'color': '#f5f5f5'
                    },
                        {
                            'lightness': 21
                        }
                    ]
                },
                {
                    'featureType': 'poi.park',
                    'elementType': 'geometry',
                    'stylers': [{
                        'color': '#f5f8fd'
                    },
                        {
                            'lightness': 21
                        }
                    ]
                },
                {
                    'elementType': 'labels.text.stroke',
                    'stylers': [{
                        'visibility': 'on'
                    },
                        {
                            'color': '#ffffff'
                        },
                        {
                            'lightness': 16
                        }
                    ]
                },
                {
                    'elementType': 'labels.text.fill',
                    'stylers': [{
                        'saturation': 36
                    },
                        {
                            'color': '#333333'
                        },
                        {
                            'lightness': 40
                        }
                    ]
                },
                {
                    'elementType': 'labels.icon',
                    'stylers': [{
                        'visibility': 'off'
                    }]
                },
                {
                    'featureType': 'transit',
                    'elementType': 'geometry',
                    'stylers': [{
                        'color': '#f2f2f2'
                    },
                        {
                            'lightness': 19
                        }
                    ]
                },
                {
                    'featureType': 'administrative',
                    'elementType': 'geometry.fill',
                    'stylers': [{
                        'color': '#fefefe'
                    },
                        {
                            'lightness': 20
                        }
                    ]
                },
                {
                    'featureType': 'administrative',
                    'elementType': 'geometry.stroke',
                    'stylers': [{
                        'color': '#fefefe'
                    },
                        {
                            'lightness': 17
                        },
                        {
                            'weight': 1.2
                        }
                    ]
                }
            ]
        };

        var map = new google.maps.Map(document.getElementById('googleMap'), mapProp);

        var marker = new google.maps.Marker({
            position: myCenter,
            animation: google.maps.Animation.DROP,
            icon: 'assets/images/all-img/mapi.gif'
        });
        marker.setMap(map);
    }

    google.maps.event.addDomListener(window, 'load', initialize);
</script>

