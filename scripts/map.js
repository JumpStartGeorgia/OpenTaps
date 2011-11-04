/**
 * Mapping script for project OpenTaps.
 * Used plain JavaScript, jQuery, OpenLayers and geo-data by JumpStart Georgia in GeoJSON format.
 * Otar Chekurishvili - otar@chekurishvili.com
 */

// Define globals and configurations
var loaded = false,
map,
base,
map_options = {
    bounds_left: 39.83642,
    bounds_top: 43.73079,
    bounds_right: 46.80175,
    bounds_bottom: 40.97322,
    //zoom: 7,
    default_lat: 42.23665,
    default_lon: 43.59375,
    controls: [
    new OpenLayers.Control.MousePosition(),
    new OpenLayers.Control.Navigation()
    ]
},
markers = new OpenLayers.Layer.Markers('Markers')
layers = new Object(),
    icon_size = new OpenLayers.Size(27, 27),
    icon_offset = new OpenLayers.Pixel(-(icon_size.w/2), -icon_size.h),
    icons = new Object(),
    icon_index = 0,
    project_types = ['sewage', 'water_supply', 'water_pollution', 'irrigation', 'water_quality', 'water_accidents'],
    project_statuses = ['completed', 'current', 'scheduled'],
    project_status_index = 0,
    project_storage = new Object(),
    popup = null;

// Generate icons
for (icon_index in project_types)
{
    icons[project_types[icon_index]] = new Object();
    project_storage[project_types[icon_index]] = new Object();
    for (project_status_index in project_statuses)
    {
        icons[project_types[icon_index]][project_statuses[project_status_index]] = new OpenLayers.Icon('images/map/projects/' + project_types[icon_index] + '_' + project_statuses[project_status_index] + '.png', icon_size, icon_offset);
        project_storage[project_types[icon_index]][project_statuses[project_status_index]] = [];
    //project_storage[project_types[icon_index]][project_statuses[project_status_index]] = new Object();
    }
    project_status_index = 0;
}
icon_index = 0;

function mapping()
{

    // Mr. Map!
    map = new OpenLayers.Map('map', {
        controls: map_options.controls,
        scales: [2500000, 1500000, 500000, 250000, 100000, 35000],
        restrictedExtent: new OpenLayers.Bounds(map_options.bounds_left, map_options.bounds_bottom, map_options.bounds_right, map_options.bounds_top),
        eventListeners: {
            /*'click': function(event){
                console.log(map.getLonLatFromViewPortPx(event.xy));
            },*/
            //'movestart': on_zoom,
            'moveend': on_zoom
        }
    });

    /*
    base = new OpenLayers.Layer.Google('Google Satellite', {
        type: google.maps.MapTypeId.SATELLITE,
        isBaseLayer: false,
        opacity: 0
    });
    */

    // Load all external layers
    preload_layers();
    load_all();

    // Add markers overlay to a map
    map.addLayer(markers);

    // Center and zoom map to the very heart of Georgia
    map.setCenter(new OpenLayers.LonLat(map_options.default_lon, map_options.default_lat));
    map.zoomToMaxExtent();

}

function preload_layers()
{
    // Urban
    layers.urban = new OpenLayers.Layer.GML('Urban', 'map-data/settlements/urban?lang=' + lang, {
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
    layers.urban.setOpacity(0);


// Villages
/*
    layers.villages = new OpenLayers.Layer.GML('Villages', 'map-data/settlements/village?lang=' + lang, {
        format: OpenLayers.Format.GeoJSON,
        styleMap: new OpenLayers.StyleMap({
            strokeWidth: 0,
            label: '${name}',
            fontColor: '#787878',
            fontSize: '8px',
            labelAlign: 'cm'
        })
    });
    layers.villages.setOpacity(0);
    */
}

function load_all()
{

    // Load and initialize vector overlays
    load_regions();
    //load_around();
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
        isBaseLayer: true,
        styleMap: new OpenLayers.StyleMap({
            fillColor: '#FFFFFF',
            strokeWidth: 0.33,
            strokeColor: '#B0B0B0'
        })
    });
}

function load_around()
{
    if (def(layers.around))
        return;
    layers.around = new OpenLayers.Layer.GML('Around Georgia', 'mapping/around.geojson', {
        format: OpenLayers.Format.GeoJSON,
        styleMap: new OpenLayers.StyleMap({
            fillColor: '#999999',
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
    layers.cities = new OpenLayers.Layer.GML('Cities', 'map-data/settlements/city?lang=' + lang, {
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
    var is_loaded = (def(layers.urban) && layers.urban.opacity == 1);
    if (map.zoom == 0 || map.zoom == 1)
    {
        if (is_loaded)
            layers.urban.setOpacity(0);
        return;
    }
    else if (is_loaded)
        return;
    layers.urban.setOpacity(1);
}

function load_villages()
{
    var is_loaded = (def(layers.villages) && layers.villages.opacity == 1);
    if (map.zoom < 4)
    {
        if (is_loaded)
            layers.villages.setOpacity(0);
        return;
    }
    else if (is_loaded)
        return;
    layers.villages.setOpacity(1);
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
    if (def(layers.roads))
        return;
    layers.roads = new OpenLayers.Layer.GML('Roads', 'mapping/roads.geojson', {
        format: OpenLayers.Format.GeoJSON,
        styleMap: new OpenLayers.StyleMap({
            strokeWidth: 1,
            strokeColor: '#E8C98B'
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
    var url = 'map-data/projects/' + type;
    //if (status)
    url += '/' + status;
    $.getJSON(url + '?lang=' + lang, function(result)
    {
        if ($.isEmptyObject(result))
            return;
        status = status || 'completed';
        var coordinates,
        marker,
        pidx = 0;
        for (var cidx in project_storage[type][status])
            markers.removeMarker(project_storage[type][status][cidx]);
        project_storage[type][status] = [];
        for (var idx in result)
        {
            for (pidx in result[idx].places)
            {
                coordinates = new OpenLayers.LonLat(result[idx].places[pidx].latitude, result[idx].places[pidx].longitude);
                marker = new OpenLayers.Marker(coordinates, icons[type][status].clone());
                marker.setOpacity(0.95);
                markers.addMarker(marker);
                marker.events.register('mousedown', marker, (function(title, coordinates, status, id, lang)
                {
                    return function()
                    {
                        show_project_tooltip(coordinates, '<a href="project/' + id + '/?lang=' + lang + '">' + title + '</a>', status);
                    }
                })(result[idx].title, coordinates, status, result[idx].id, lang));
            }
            pidx = 0;
        }
    });
}

function show_project_tooltip(lonlat, content, status)
{
    var offset = map.getPixelFromLonLat(lonlat),
    tooltip = $('#tooltip')
    .removeClass('completed')
    .removeClass('current')
    .removeClass('scheduled')
    .addClass(status)
    .click(function(event)
    {
        event.stopPropagation();
        $(this).fadeOut();
    })
    .css({
        left: parseInt(offset.x - 88),
        top: parseInt(offset.y - 88)
    });
    //////////
    return tooltip
    .children('span')
    .html(content)
    .end()
    .fadeIn();
}

//feature.geometry.getBounds().getCenterLonLat();

function toggle_projects(type, status)
{
    return load_projects(type, status);
}

function toggle_layer(object)
{
    if (def(object))
        return object.setOpacity(object.opacity == 0 ? 1 : 0);
    else
        return false;
}

function toggle_overlay(name)
{
    if (!name)
        return;
    if (def(layers[name]) && layers[name] != 'urban' && layers[name] != 'villages')
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
        case 'urban':
            if (map.zoom == 0 || map.zoom == 1)
                break;
            alert('Gotcha!')
            break;
    }
}

function on_zoom()
{
    load_all();
}

function zoom_in()
{
    return map.zoomIn();
}

function zoom_out()
{
    return map.zoomOut();
}

function popup_assign_class(cls)
{
    var pop_goes_my_heart = $('#map-popup');
    return pop_goes_my_heart
    .removeClass('completed')
    .removeClass('current')
    .removeClass('scheduled')
    .addClass(cls);
}

function map_commons()
{

    mapping();

    $('body').click(function()
    {
        $('#tooltip').fadeOut();
    });

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

    // Popup Tweaks
    $('#map-popup').live('click', function()
    {
        console.log('hey!');
    //popup.hide();
    });

}

$(map_commons);
