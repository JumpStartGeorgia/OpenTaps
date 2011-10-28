/**
 * Mapping script for project OpenTaps.
 * Used plain JavaScript, jQuery, OpenLayers and GeoJSON format.
 * Otar Chekurishvili - otar@chekurishvili.com
 */

// Define globals and configurations
var loaded = false,
map,
base,
map_options = {
    bounds_left: 4390630.1231925,
    bounds_top: 5427277.3672416,
    bounds_right: 5422472.9529191,
    bounds_bottom: 4999230.0089212,
    zoom: 7,
    default_lat: 42.23665,
    default_lon: 43.59375,
    controls: [new OpenLayers.Control.Navigation()]
},
markers = new OpenLayers.Layer.Markers('Markers')
layers = new Object(),
    icon_size = new OpenLayers.Size(27, 27),
    icon_offset = new OpenLayers.Pixel(-(icon_size.w/2), -icon_size.h),
    icons = new Object(),
    project_types = ['sewage', 'water_supply', 'water_pollution', 'irrigation', 'water_quality', 'water_accidents'],
    project_status_types = ['completed', 'current', 'scheduled'],
    project_status_type_index = 0;

// Generate icons
for (var icon_index in project_types)
{
    icons[project_types[icon_index]] = new Object();
    for (project_status_type_index in project_status_types)
        icons[project_types[icon_index]][project_status_types[project_status_type_index]] = new OpenLayers.Icon('images/map/projects/' + icons[project_types[icon_index]] + '_' + project_status_types[project_status_type_index] + '.png', icon_size, icon_offset);
    project_status_type_index = 0;
}

function mapping()
{

    // Mr. Map!
    map = new OpenLayers.Map('map', {
        controls: map_options.controls,
        restrictedExtent: new OpenLayers.Bounds(map_options.bounds_left, map_options.bounds_bottom, map_options.bounds_right, map_options.bounds_top),
        eventListeners: {
            //'movestart': on_zoom,
            'moveend': on_zoom
        }
    });

    // Base Layer
    base = new OpenLayers.Layer.OSM('Georgia', 'http://tile.mapspot.ge/en/${z}/${x}/${y}.png', {
        numZoomLevels: 19,
        opacity: 0 // TO-DO
    });

    // Add base and markers overlay layers to the map
    map.addLayers([base, markers]);

    // Load all external layers
    load_all();

    // Center and zoom map to the very heart of Georgia
    map.setCenter(new OpenLayers.LonLat(map_options.default_lon, map_options.default_lat));
    map.zoomTo(map_options.zoom);

}

function load_all()
{
    // Load and initialize vector overlays
    load_regions();
    //load_water();
    load_protected_areas();
    //load_roads();
    load_cities();
    load_urban();
    load_villages();
    //load_hydro();

    // Add initialized vector overlay-layers to the map
    for (var idx in layers)
        map.addLayer(layers[idx]);
}

function load_regions()
{
    if (def(layers.regions))
        return;
    layers.regions = new OpenLayers.Layer.GML('Regions', 'mapping/regions.geojson', {
        format: OpenLayers.Format.GeoJSON,
        styleMap: new OpenLayers.StyleMap({
            fillColor: '#FFFFFF',
            strokeWidth: 0.33,
            strokeColor: '#B0B0B0'
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

function load_cities()
{
    if (def(layers.cities))
        return;
    layers.cities = new OpenLayers.Layer.GML('Cities', 'map-data/settlements/city', {
        format: OpenLayers.Format.GeoJSON,
        styleMap: new OpenLayers.StyleMap({
            pointRadius: 3,
            fillColor: '#FFFFFF',
            fillOpacity: 0.9,
            strokeWidth: 0.5,
            strokeColor: '#555555',
            label: '${name}',
            fontColor: '#787878',
            fontSize: '10px',
            labelAlign: 'ct'
        })
    });
}

function load_urban()
{
    var is_loaded = def(layers.urban);
    if (map.zoom == 0 || map.zoom == 7 || map.zoom == 8)
    {
        if (is_loaded === true)
            map.removeLayer(layers.urban);
        return;
    }
    else if (is_loaded === true)
        return;
    layers.urban = new OpenLayers.Layer.GML('Urban', 'map-data/settlements/urban', {
        format: OpenLayers.Format.GeoJSON,
        styleMap: new OpenLayers.StyleMap({
            pointRadius: 2,
            fillColor: '#FFFFFF',
            fillOpacity: 0.9,
            strokeWidth: 0.5,
            strokeColor: '#555555',
            label: '${name}',
            fontColor: '#787878',
            fontSize: '9px',
            labelAlign: 'ct'
        })
    });
}

function load_villages()
{
    var is_loaded = (def(layers.villages));
    if (map.zoom < 12)
    {
        if (is_loaded)
            map.removeLayer(layers.villages);
        return;
    }
    else if (is_loaded)
        return;
    layers.villages = new OpenLayers.Layer.GML('Villages', 'map-data/settlements/village', {
        format: OpenLayers.Format.GeoJSON,
        styleMap: new OpenLayers.StyleMap({
            strokeWidth: 0,
            label: '${name}',
            fontColor: '#787878',
            fontSize: '8px',
            labelAlign: 'cm'
        })
    });
}

function load_hydro()
{
    if (def(layers.hydro))
        return;
    layers.hydro = new OpenLayers.Layer.GML('Hydro', 'mapping/hydro.geojson', {
        format: OpenLayers.Format.GeoJSON,
        styleMap: new OpenLayers.StyleMap({
            pointRadius: 4,
            fillColor: '#F38630',
            fillOpacity: 0.9,
            strokeWidth: 0,
            label: '${NAME_ENG}',
            fontColor: '#AAAAAA',
            fontSize: '9px',
            labelAlign: 'ct'
        })
    });
}

function load_protected_areas()
{
    if (def(layers.protected_areas))
        return;
    layers.protected_areas = new OpenLayers.Layer.GML('Protected Areas', 'mapping/protected_areas.geojson', {
        format: OpenLayers.Format.GeoJSON,
        styleMap: new OpenLayers.StyleMap({
            fillColor: '#E0E4CC',
            fillOpacity: 0.8,
            strokeWidth: 0
        })
    });
}

function load_roads()
{
    layers.roads = new OpenLayers.Layer.GML('Roads', 'mapping/roads.geojson', {
        format: OpenLayers.Format.GeoJSON,
        styleMap: new OpenLayers.StyleMap({
            pointRadius: 4,
            fillColor: '#F0D878',
            fillOpacity: 0.9,
            strokeWidth: 0
        })
    });
}

function load_water()
{
    layers.water = new OpenLayers.Layer.GML('Regions', 'mapping/water.geojson', {
        format: OpenLayers.Format.GeoJSON,
        styleMap: new OpenLayers.StyleMap({
            fillColor: '#73BDF8',
            fillOpacity: 0.9,
            strokeWidth: 0
        })
    });
}

function load_projects(type, status)
{
    var request_url = 'map-data/projects/' + type;
    if (status)
        request_url += '/' + status;
    $.getJSON(request_url, function(result)
    {
        if ($.isEmptyObject(result))
            return;
        var status = status || 'completed',
        coordinates,
        marker;
        for (var idx in result)
        {
            for (var pidx in result[idx].places)
            {
                coordinates = new OpenLayers.LonLat(result[idx].places[pidx].latitude, result[idx].places[pidx].longitude);
                marker = new OpenLayers.Marker(coordinates, icons[type][status].clone());
                markers.addMarker(marker);
            }
        }
    });
//feature.geometry.getBounds().getCenterLonLat();
}

function toggle_projects(type, status)
{
    return load_projects(type, status);
}

function toggle_layer(object)
{
    if (def(object))
        return object.setOpacity(object.opacity == 0 ? 1 : 0);
}

function toggle_overlay(name)
{
    if (!name)
        return;
    if (def(layers[name]))
        layers[name].setOpacity(layers[name].opacity == 0 ? 1 : 0);
    switch (name)
    {
        case 'hydro':
            load_hydro();
            map.addLayer(layers.hydro);
            break;
        case 'roads':
            load_roads();
            map.addLayer(layers.roads);
            break;
    }
}

function on_zoom(event)
{
    load_all();
/*
    switch (event.object.zoom)
    {
        case 7:

            break;
        case 8:

            break;
        case 9:

            break;
        case 10:

            break;
        case 11:

            break;
        case 12:

            break;
    }
 */
}

function zoom_in()
{
    return map.zoomIn();
}

function zoom_out()
{
    return map.zoomOut();
}

function map_commons()
{

    mapping();

    var controls = $('#map-controls'),
    count = 3;

    // Overlays menu
    controls.children('li').hover(function()
    {
        var sub = $(this).children('ul');
        if (!sub.length)
            return;
        sub.toggle().end().find('li > a').click(function()
        {
            var me = $(this).toggleClass('active');
            par = parent().parent().parent().children('a');
            if (me.hasClass('active'))
            {
                ++count;
                par.addClass('active');
            }
            else
                --count;
            if (count < 1)
                par.removeClass('active');

        });
    });

    // Projects menu
    controls.find('li > ul > li').hover(function()
    {
        var sub = $(this).children('ul');
        if (!sub.length)
            return;
        sub.css('right', $(this).parent().width()).toggle();
    });

}

$(map_commons);
