/**
 * Mapping script for OpenTaps project.
 * Used plain JavaScript, jQuery, OpenLayers and geo-data by JumpStart Georgia in GeoJSON format.
 * Otar Chekurishvili - otar@chekurishvili.com
 */

// Define globals and configurations
var map_loaded = false,
map,
map_options = {
    bounds_left: 39.83642,
    bounds_top: 43.73079,
    bounds_right: 46.80175,
    bounds_bottom: 40.97322,
    default_lon: 43.59375,
    default_lat: 42.23665,
    controls: [
    //new OpenLayers.Control.MousePosition(),
    new OpenLayers.Control.Navigation()
    ],
    scales: [2500000, 1500000, 500000, 250000, 100000, 35000]
},
markers = new OpenLayers.Layer.Markers('Markers')
layers = new Object(),
    icon_size = new OpenLayers.Size(27, 27),
    icon_offset = new OpenLayers.Pixel(-(icon_size.w/2), -icon_size.h),
    icons = new Object(),
    project_types = ['sewage', 'water_supply', 'water_pollution', 'irrigation', 'water_quality', 'water_accidents'],
    project_statuses = ['completed', 'current', 'scheduled'],
    project_status_index = 0,
    project_storage = new Object(),
    region_projects_storage = [],
    places = new Object(),
    all_icon = new OpenLayers.Icon('images/map/projects/all_all.png', icon_size, icon_offset),
    coordinate_hash_storage = new Object();

// Generate icons
$.each(project_types, function(type_index)
{
    icons[project_types[type_index]] = new Object();
    project_storage[project_types[type_index]] = new Object();
    places[project_types[type_index]] = new Object();
    $.each(project_statuses, function(status_index)
    {
        var icon = new OpenLayers.Icon('images/map/projects/' + project_types[type_index] + '_' + project_statuses[status_index] + '.png', icon_size, icon_offset);
        icons[project_types[type_index]][project_statuses[status_index]] = icon;
        project_storage[project_types[type_index]][project_statuses[status_index]] = [];
        places[project_types[type_index]][project_statuses[status_index]] = false;
    });
});

// Generate general icons
var general_icons = new Object(),
general_icon_properties = [{
    "type": "small",
    "size": 22
}, {
    "type": "medium",
    "size": 40
}, {
    "type": "large",
    "size": 53
}];
$.each(general_icon_properties, function(index, icon)
{
    var size = new OpenLayers.Size(icon.size, icon.size),
    offset = new OpenLayers.Pixel(-(size.w/2), -size.h);
    general_icons[icon.type] = new OpenLayers.Icon('images/map/projects/general_' + icon.type + '.png', size, offset);
});

function mapping()
{

    // Mr. Map!
    map = new OpenLayers.Map('map', {
        controls: map_options.controls,
        scales: map_options.scales,
        restrictedExtent: new OpenLayers.Bounds(map_options.bounds_left, map_options.bounds_bottom, map_options.bounds_right, map_options.bounds_top),
        eventListeners: {
            'moveend': on_zoom
        }
    });

    // Load all external layers
    load_all();
    preload_layers();

    // Map loading...
    if (!map_loaded)
    {
        $('#map-overlay > span').toggle();
        map_loaded = true;
    }

    // Add markers layer as a very top overlay
    map.addLayer(markers);
    markers.setZIndex(999999);

    // Center and zoom a map to the very heart of Georgia
    map.setCenter(new OpenLayers.LonLat(map_options.default_lon, map_options.default_lat));
    map.zoomToMaxExtent();

}

function preload_layers()
{

    // Urban settlements
    layers.urban = new OpenLayers.Layer.GML('Urban', baseurl + 'map-data/settlements/urban?lang=' + lang, {
        format: OpenLayers.Format.GeoJSON,
        styleMap: new OpenLayers.StyleMap({
            pointRadius: 2,
            fillColor: '#FFFFFF',
            fillOpacity: 0.9,
            strokeWidth: 0.5,
            strokeColor: '#555555',
            label: '${name}',
            fontColor: '#333333',
            fontSize: '10px',
            labelAlign: 'ct',
            labelYOffset: -3
        })
    });
    layers.urban.setZIndex(150);
    layers.urban.setOpacity(0);

}

function load_all()
{

    // Load and initialize vector overlays
    load_bounds();
    load_regions();
    load_protected_areas();
    load_cities();
    load_urban();
    load_water()
    load_roads_main();

    // Add initialized vector overlay-layers to the map
    $.each(layers, function(index)
    {
        map.addLayer(layers[index]);
    });

    // Add district boundaries from the top
    load_districts();

}

function load_bounds()
{
    if (def(layers.bounds))
        return;
    layers.bounds = new OpenLayers.Layer.GML('Bounds', baseurl + 'mapping/bounds.geojson', {
        format: OpenLayers.Format.GeoJSON,
        styleMap: new OpenLayers.StyleMap({
            fill: false,
            strokeWidth: 1.5,
            strokeColor: '#AAAAAA'
        })
    });
}

function load_regions()
{
    if (def(layers.regions))
        return;
    layers.regions = new OpenLayers.Layer.GML('Regions', baseurl + 'mapping/regions.geojson', {
        format: OpenLayers.Format.GeoJSON,
        isBaseLayer: true,
        styleMap: new OpenLayers.StyleMap({
            fillColor: '#F4F3F0',
            strokeWidth: .65,
            strokeColor: '#BBBBBB'
        })
    });
}

function load_districts()
{
    if (def(layers.districts))
        return;
    layers.districts = new OpenLayers.Layer.GML('Districts', baseurl + 'mapping/districts.geojson', {
        format: OpenLayers.Format.GeoJSON,
        styleMap: new OpenLayers.StyleMap({
            fill: false,
            strokeWidth: .33,
            strokeColor: '#BBBBBB',
            strokeDashstyle: 'dash'
        })
    });
}

function load_cities()
{
    if (def(layers.cities))
        return;
    layers.cities = new OpenLayers.Layer.GML('Cities', baseurl + 'map-data/settlements/city?lang=' + lang, {
        format: OpenLayers.Format.GeoJSON,
        styleMap: new OpenLayers.StyleMap({
            pointRadius: 3,
            fillColor: '#FFFFFF',
            fillOpacity: 0.9,
            strokeWidth: 0.5,
            strokeColor: '#555555',
            label: '${name}',
            fontColor: '#666666',
            fontSize: '11px',
            labelAlign: 'ct',
            labelYOffset: -3
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

function load_hydro()
{
    if (def(layers.hydro))
        return;
    layers.hydro = new OpenLayers.Layer.GML('Hydro', baseurl + 'mapping/hydro.geojson', {
        format: OpenLayers.Format.GeoJSON,
        styleMap: new OpenLayers.StyleMap({
            pointRadius: 4,
            fillColor: '#F38630',
            fillOpacity: 0.9,
            strokeWidth: 0,
            label: '${NAME_ENG}',
            fontColor: '#AAAAAA',
            fontSize: '10px',
            labelAlign: 'ct',
            labelYOffset: -2
        })
    });
}

function load_protected_areas()
{
    if (def(layers.protected_areas))
        return;
    layers.protected_areas = new OpenLayers.Layer.GML('Protected Areas', baseurl + 'mapping/protected_areas.geojson', {
        format: OpenLayers.Format.GeoJSON,
        styleMap: new OpenLayers.StyleMap({
            fillColor: '#C9DFAF', // #E0E4CC
            strokeWidth: 0
        })
    });
}

function load_roads_main()
{
    if (def(layers.roads_main))
        return;
    layers.roads_main = new OpenLayers.Layer.GML('Main Roads', baseurl + 'mapping/roads_main.geojson', {
        format: OpenLayers.Format.GeoJSON,
        styleMap: new OpenLayers.StyleMap({
            fill: false,
            strokeWidth: 1.5,
            strokeColor: '#F1BC45'
        })
    });
}

function load_roads_secondary()
{
    if (def(layers.roads_secondary))
        return;
    layers.roads_secondary = new OpenLayers.Layer.GML('Main Secondary', baseurl + 'mapping/roads_secondary.geojson', {
        format: OpenLayers.Format.GeoJSON,
        styleMap: new OpenLayers.StyleMap({
            fill: false,
            strokeWidth: .75,
            strokeColor: '#F1BC45'
        })
    });
}

function load_water()
{
    if (def(layers.water))
        return;
    layers.water = new OpenLayers.Layer.GML('Water', baseurl + 'mapping/water.geojson', {
        format: OpenLayers.Format.GeoJSON,
        styleMap: new OpenLayers.StyleMap({
            fillColor: '#A5BFDD',
            strokeColor: '#A5BFDD',
            strokeWidth: 1
        })
    });
}

function unload_region_projects()
{
    $('a[id^="control-"]').removeClass('active');
    $.each(region_projects_storage, function(key, value)
    {
        markers.removeMarker(value);
    });
    region_projects_storage = [];
    coordinate_hash_storage = new Object();
}

function load_region_projects(type, status)
{
    var request_url = baseurl + 'map-data/cluster-region-projects/' + type + '/' + status + '?lang=' + lang;
    $.getJSON(request_url, function(result)
    {
        if ($.isEmptyObject(result) || !result.length)
            return;

        $('#control-' + type).addClass('active');
        $('#control-' + type + '-' + status).addClass('active');

        $.each(result, function(index)
        {

            var project = result[index];

            if (!project.places.length)
                return true;

            var count = parseInt(project.places),
            size = 'small';

            if (count > 8)
                size = 'large';
            else if (count > 3)
                size = 'medium';

            var coordinates = new OpenLayers.LonLat(project.longitude, project.latitude),
            marker = new OpenLayers.Marker(coordinates, general_icons[size].clone());
            markers.addMarker(marker);

            $('#' + marker.icon.imageDiv.id).
            append('<div class="region-marker-wrapper ' + size + '">' + count + '</div>');

            region_projects_storage.push(marker);

        });
    });
}

/*
function region_marker_action(coordinates)
{
    unload_region_projects();
    map.zoomTo(2);
    map.setCenter(coordinates);
    markers.loaded = false;
    markers.setVisibility(true);
}
*/

function add_project_marker(type, status, longitude, latitude, title, id)
{
    var coordinates = new OpenLayers.LonLat(longitude, latitude),
    marker = new OpenLayers.Marker(coordinates, icons[type][status].clone());
    console.log(marker);
    marker.setOpacity(0.95);
    markers.addMarker(marker);
    marker.events.register('mousedown', marker, (function()
    {
        show_project_tooltip(coordinates, '<a href="project/' + id + '/?lang=' + lang + '">' + title + '</a>', status);
    }));
    project_storage[type][status].push(marker);
}

function calculate_cluster_distance()
{
    var meters = 1; // 100 meters
    switch (map.zoom)
    {
        case 0:
            meters = 10;
            break;
        case 1:
            meters = 8;
            break;
        case 2:
            meters = 5;
            break;
        case 3:
            meters = 3;
            break;
        case 4:
            meters = 2;
            break;
        case 5:
            meters = 1.6;
            break;
    }
    return parseInt((map_options.scales.length - map.zoom) * meters);
}

function load_projects(type, status)
{
    var request_url = baseurl + 'map-data/projects/' + type + '/' + status + '?lang=' + lang,
    distance = calculate_cluster_distance();

    console.log(request_url);

    $.getJSON(request_url, function(result)
    {
        if ($.isEmptyObject(result) || !result.length)
            return;

        $('#control-' + type).addClass('active');
        $('#control-' + type + '-' + status).addClass('active');

        $.each(result, function(index)
        {
            var place = result[index],
            actual_latitude = adjusted_latitude = place.longitude,
            actual_longitude = adjusted_longitude = place.latitude,
            coordinate_hash = actual_latitude + actual_longitude;

            while (coordinate_hash_storage[coordinate_hash] != null)
            {
                adjusted_latitude = parseFloat(actual_latitude) + (Math.random() - distance) / 750;
                adjusted_longitude = parseFloat(actual_longitude) + (Math.random() - distance) / 750;
                coordinate_hash = String(adjusted_latitude) + String(adjusted_longitude);
            }
            coordinate_hash_storage[coordinate_hash] = true;

            var coordinates = new OpenLayers.LonLat(adjusted_latitude, adjusted_longitude),
            marker = new OpenLayers.Marker(coordinates, icons[type][status].clone());
            marker.events.register('mousedown', marker, (function(title, coordinates, status, id, lang)
            {
                return function()
                {
                    show_project_tooltip(coordinates, '<a href="project/' + id + '/?lang=' + lang + '">' + title + '</a>', status);
                }
            })(place.title, coordinates, status, place.id, lang));

            markers.addMarker(marker);

            project_storage[type][status].push(marker);

        });

        $('img[id$="_innerImage"]').css('cursor', 'pointer').hover(function()
        {
            $(this).stop().animate({
                opacity: .65
            });
        }, function()
        {
            $(this).stop().animate({
                opacity: 1
            });
        });

    });
}

function unload_projects(type, status)
{
    if (!$('#control-' + type).parent().find('ul li a.active').length)
        $('#control-' + type).removeClass('active');
    $('#control-' + type + '-' + status).removeClass('active');
    $.each(project_storage[type][status], function(key, value)
    {
        markers.removeMarker(value);
    });
    project_storage[type][status] = [];
}

function show_project_tooltip(lonlat, content, status)
{
    var offset = map.getPixelFromLonLat(lonlat),
    tooltip = $('#tooltip')
    .removeClass('completed')
    .removeClass('current')
    .removeClass('scheduled')
    .addClass(status)
    .mouseleave(function(event)
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

function zoom_mode()
{
    return map.zoom > 1 ? 'detailed' : 'regions';
}

function toggle_projects(type, status)
{
    if (places[type][status] == true)
        places[type][status] = false;
    else
        places[type][status] = true;
    reload_all_projects();
}

function project_variations()
{
    var result = [];
    $.each(project_types, function(type_index)
    {
        $.each(project_statuses, function(status_index)
        {
            if (places[project_types[type_index]][project_statuses[status_index]] === false)
                return true;
            result.push(project_types[type_index] + '|' + project_statuses[status_index]);
        });
    });
    return result;
}

function reload_all_projects()
{
    var variations = project_variations(),
    state = zoom_mode();

    coordinate_hash_storage = new Object();

    unload_region_projects();

    $.each(variations, function(key, value)
    {
        var parts = value.split('|');
        if (parts.length != 2)
            return true;

        unload_projects(parts[0], parts[1]);

        if (state == 'regions')
            load_region_projects(parts[0], parts[1]);
        else
            load_projects(parts[0], parts[1]);
    });
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
    if (def(layers[name]) && layers[name] != 'urban')
    {
        if (layers[name].opacity == 0)
        {
            layers[name].setOpacity(1);
            $('#overlay-' + name).addClass('active');
        }
        else
        {
            $('#overlay-' + name).removeClass('active');
            layers[name].setOpacity(0);
        }
    }
    switch (name)
    {
        case 'hydro':
            load_hydro();
            $('#overlay-hydro').toggleClass('active');
            map.addLayer(layers.hydro);
            break;
        case 'roads_main':
            load_roads_main();
            $('#overlay-roads-main').toggleClass('active');
            map.addLayer(layers.roads_main);
            break;
        case 'roads_secondary':
            load_roads_secondary();
            $('#overlay-roads-secondary').toggleClass('active');
            map.addLayer(layers.roads_secondary);
            break;
        case 'water':
            load_water();
            $('#overlay-water').toggleClass('active');
            map.addLayer(layers.water);
            break;
    /*
        case 'urban':
            if (map.zoom == 0 || map.zoom == 1)
                break;
            console.log('Gotcha!');
            break;
         */
    }
}

function on_zoom()
{
    load_all();
    reload_all_projects();
    markers.loaded = false;
    markers.setVisibility(true);
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

    $('body').click(function()
    {
        $('#tooltip').fadeOut();
    });

    var controls = $('#map-controls')

    // Overlays menu
    controls.children('li').hover(function()
    {
        var sub = $(this).children('ul');
        if (!sub.length)
            return;
        sub.toggle().end().find('a.sub').click(function()
        {
            $(this).toggleClass('active');
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
