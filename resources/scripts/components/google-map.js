import {Loader} from '@googlemaps/js-api-loader';

// TODO: need to add backend for this code in homepage
// TODO: need to add this code to widget in homepage
function create_map(element_id) {
    const MAP_API_KEY = window.GOOGLE_MAPS_JS_API_KEY ? window.GOOGLE_MAPS_JS_API_KEY : " ";
    const loader = new Loader({
        apiKey: MAP_API_KEY,
        version: "weekly",
        libraries: ["places"]
    });
    loader.load().then(function (google) {
        var location = {lat: 48.519712, lng: 32.274394};
        var map = new google.maps.Map(document.getElementById(element_id), {
            zoom: 14,
            center: location
        });

        var marker = new google.maps.Marker({
            position: location,
            map: map,
            title: window.google_maps_marker.title
        });

        var infowindow = new google.maps.InfoWindow({
            content: window.google_maps_marker.content
        });

        infowindow.open(map, marker);

        marker.addListener('click', function() {
            infowindow.open(map, marker);
        });

    });
}

window.onload = function () {
    create_map("contact_page_map");
};
