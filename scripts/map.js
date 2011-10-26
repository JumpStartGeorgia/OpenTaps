var loaded = false,
map,
base,
map_options = {
    boundsLeft: 4390630.1231925,
    boundsTop: 5427277.3672416,
    boundsRight: 5422472.9529191,
    boundsBottom: 4999230.0089212,
    zoom: 7,
    lat: 42.236652,
    lon: 43.59375,
    controls: [
    new OpenLayers.Control.Navigation(),
    new OpenLayers.Control.MousePosition()
    ]
},
//geojson = new OpenLayers.Format.GeoJSON(),
markers = new OpenLayers.Layer.Markers('Markers'),

hydro_marker_size = new OpenLayers.Size(15, 14),
hydro_marker = new OpenLayers.Icon('images/map/hydro.png', hydro_marker_size, new OpenLayers.Pixel(-(hydro_marker_size.w / 2), -hydro_marker_size.h)),

village_marker_size = new OpenLayers.Size(9, 9),
village_marker = new OpenLayers.Icon('images/map/city.png', hydro_marker_size, new OpenLayers.Pixel(-(hydro_marker_size.w / 2), -hydro_marker_size.h)),
village_markers = [],

city_marker_size = new OpenLayers.Size(9, 9),
city_marker = new OpenLayers.Icon('images/map/city.png', hydro_marker_size, new OpenLayers.Pixel(-(hydro_marker_size.w / 2), -hydro_marker_size.h)),
city_markers = [];

var layers = new Object(),
popups = [];

function mapping()
{

    // Map
    map = new OpenLayers.Map('map', {
        controls: map_options.controls,
        //projection: new OpenLayers.Projection('EPSG:900913'),
        //displayProjection: new OpenLayers.Projection('EPSG:900913'),
        restrictedExtent: new OpenLayers.Bounds(map_options.boundsLeft, map_options.boundsBottom, map_options.boundsRight, map_options.boundsTop),
        eventListeners: {
            'loadend': on_load,
            'moveend': on_move
        }
    });

    // Base Layer
    base = new OpenLayers.Layer.OSM('Georgia', 'http://tile.mapspot.ge/en/${z}/${x}/${y}.png', {
        numZoomLevels: 19
    });

    // Configuration
    map.addLayers([base, markers]);
    map.setCenter(new OpenLayers.LonLat(map_options.lon, map_options.lat));
    map.zoomTo(map_options.zoom);

    // Load and initialize vector overlays
    load_regions();
    //load_cities();
    //load_water();
    load_projects('Sewage');

    // Add initialized vector layers to the map
    for (var idx in layers)
        map.addLayer(layers[idx]);

}

function load_regions()
{
    layers.region = new OpenLayers.Layer.GML('Regions', 'map-data/regions', {
        format: OpenLayers.Format.GeoJSON,
        styleMap: new OpenLayers.StyleMap({
            fillColor: '#FFFFFF',
            strokeWidth: 0
        })
    });
}

function load_water()
{
    layers.water = new OpenLayers.Layer.GML('Water', 'map-data/water', {
        format: OpenLayers.Format.GeoJSON,
        styleMap: new OpenLayers.StyleMap({
            fillColor: '#6CD1F8',
            strokeWidth: 0
        })
    });
}

function load_hydro()
{
    $.getJSON('map-data/hydro', function(json)
    {
        if ($.isEmptyObject(json))
            return;
        var coordinates;
        for (var idx in json)
        {
            coordinates = new OpenLayers.LonLat(json[idx].longitude, json[idx].latitude);
            markers.addMarker(new OpenLayers.Marker(coordinates, hydro_marker.clone()));
        }
    });
}

function load_cities()
{
    $.getJSON('map-data/cities', function(json)
    {
        if ($.isEmptyObject(json.features))
            return;
        var coordinates,
        marker;
        for (var idx in json.features)
        {
            coordinates = new OpenLayers.LonLat(json.features[idx].geometry.coordinates[1], json.features[idx].geometry.coordinates[0]);
            //coordinates.transform(new OpenLayers.Projection('EPSG:900913'), new OpenLayers.Projection('EPSG:4326'));
            marker = new OpenLayers.Marker(coordinates, city_marker.clone());
            markers.addMarker(marker);
        }
    });
}

function load_villages(left, top, right, bottom)
{
    var url = 'map-data/villages/' + left + '/' + top + '/' + right + '/' + bottom;
    $.getJSON(url, function(result)
    {
        var json = result.features,
        marker,
        coordinates;
        if ($.isEmptyObject(json))
            return;
        for (var idx in village_markers)
            markers.removeMarker(village_markers[idx]);
        idx = 0;
        for (idx in json)
        {
            if (idx == 5)
                break;
            coordinates = new OpenLayers.LonLat(json[idx].longitude, json[idx].latitude);
            //.transform(new OpenLayers.Projection('EPSG:900913'), new OpenLayers.Projection('EPSG:4326'));
            //console.log(json[idx]);
            continue;
            marker = new OpenLayers.Marker(coordinates, village_marker.clone());
            village_markers.push(marker);
            markers.addMarker(marker);
        }
    });
}

function load_projects(type, status)
{
    $.getJSON('map-data/projects/' + type, function(result)
    {
        if ($.isEmptyObject(result))
            return;
        for (var idx in popups)
            popups[idx].destroy();
        popups = [];
        var coordinates,
        marker;
        idx = 0;
        for (idx in result)
        {
            for (var place_idx in result[idx].places)
            {
                //console.log(result[idx].places);
                //console.log(result[idx].title + ' ' + result[idx].places[place_idx].name);
                coordinates = new OpenLayers.LonLat(result[idx].places[place_idx].longitude, result[idx].places[place_idx].latitude);
                //coordinates.transform(new OpenLayers.Projection("EPSG:900913"), new OpenLayers.Projection("EPSG:4326"));
                console.log(coordinates);
                popups.push(new OpenLayers.Popup('popup-' + result[idx].id, coordinates, new OpenLayers.Size(200, 200), '<b>' + result[idx].title + '</b>', true));
                marker = new OpenLayers.Marker(coordinates, city_marker.clone());
                markers.addMarker(marker);
            }
        }
        idx = 0;
        for (idx in popups)
        {
            popups[idx].closeOnMove = true;
            map.addPopup(popups[idx]);
        }
    });
//feature.geometry.getBounds().getCenterLonLat();
}

function on_load()
{
    loaded = true;
}

function on_move(event)
{
    var bounds = event.object.baseLayer.getExtent();
//.transform(new OpenLayers.Projection("EPSG:900913"), new OpenLayers.Projection("EPSG:4326"));
//load_villages(bounds.left, bounds.top, bounds.right, bounds.bottom);
}

$(function()
{
    $('#map-filter-button').click(function()
    {
        $('#map-filter').toggle();
    });
});