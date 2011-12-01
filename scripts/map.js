/**
 * Mapping script for OpenTaps project.
 * Used plain JavaScript, jQuery, OpenLayers and geo-data by JumpStart Georgia in GeoJSON format.
 * Otar Chekurishvili - otar@chekurishvili.com
 */

// Define storage object and it's options
var mapping = new Object();
mapping.loaded = false;
mapping.map = null;
mapping.options = {
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
    scales: [
    2500000,
    1500000,
    500000,
    250000,
    100000,
    35000
    ],
    project_types: [
    'sewage',
    'water_supply',
    'water_pollution',
    'irrigation',
    'water_quality',
    'water_accidents'
    ],
    project_statuses: [
    'completed',
    'current',
    'scheduled'
    ],
    general_icons: [{
        "type": "small",
        "size": 22
    }, {
        "type": "medium",
        "size": 40
    }, {
        "type": "large",
        "size": 53
    }]
};
mapping.markers = new OpenLayers.Layer.Markers('Markers');
mapping.layers = new Object();
mapping.icons = new Object();
mapping.icons['general'] = new Object();
mapping.project_storage = new Object();
mapping.place_storage = [];
mapping.project_variations = new Object();

// Generate icons
$.each(mapping.options.project_types, function(type_index, type)
{
    mapping.icons[type] = new Object();
    mapping.project_variations[type] = new Object();

    $.each(mapping.options.project_statuses, function(status_index, status)
    {
        var size = new OpenLayers.Size(27, 27),
        offset = new OpenLayers.Pixel(-(size.w/2), -size.h),
        icon = new OpenLayers.Icon(baseurl + 'images/map/projects/' + type + '_' + status + '.png', size, offset);

        mapping.icons[type][status] = icon;
        mapping.project_variations[type][status] = false;
    });
});

// Generate general icons
$.each(mapping.options.general_icons, function(index, item)
{
    var size = new OpenLayers.Size(item.size, item.size),
    offset = new OpenLayers.Pixel(-(size.w/2), -size.h),
    icon = new OpenLayers.Icon(baseurl + 'images/map/projects/general_' + item.type + '.png', size, offset);

    mapping.icons['general'][item.type] = icon;
});

var scaleByMode = function()
{
    if (typeof(mapMode) !== 'undefined')
    {
        switch (mapMode.toLowerCase())
        {
            case 'project':
                return true;
            case 'region':
                return true;
            default:
                return false;
        }
        return true;
    }
    else
        return false;
};

function initialize_mapping()
{

    // Mr. Map!
    mapping.map = new OpenLayers.Map('map', {
        controls: mapping.options.controls,
        scales: scaleByMode() ? mapping.options.scales.slice(0, 2) : mapping.options.scales,
        restrictedExtent: new OpenLayers.Bounds(mapping.options.bounds_left, mapping.options.bounds_bottom, mapping.options.bounds_right, mapping.options.bounds_top),
        eventListeners: {
            'moveend': on_zoom
        }
    });

    // Load all external layers
    load_all();
    preload_layers();

    // Add markers layer as a very top overlay
    mapping.map.addLayer(mapping.markers);
    mapping.markers.setZIndex(99999);

    // Center and zoom a map to the very heart of Georgia
    mapping.map.setCenter(new OpenLayers.LonLat(mapping.options.default_lon, mapping.options.default_lat));
    mapping.map.zoomToMaxExtent();

    // Map loading...
    if (!mapping.loaded)
    {
        $('#map-overlay > span').toggle();
        mapping.loaded = true;
    }

}

function preload_layers()
{

    // Urban settlements
    mapping.layers.urban = new OpenLayers.Layer.GML('Urban', baseurl + 'map-data/settlements/urban?lang=' + lang, {
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
    mapping.layers.urban.setZIndex(150);
    mapping.layers.urban.setOpacity(0);

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
    $.each(mapping.layers, function(index, layer)
    {
        mapping.map.addLayer(layer);
    });

    // Add district boundaries from the top
    load_districts();

}

function load_bounds()
{
    if (def(mapping.layers.bounds))
        return;
    mapping.layers.bounds = new OpenLayers.Layer.GML('Bounds', baseurl + 'mapping/bounds.geojson', {
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
    if (def(mapping.layers.regions))
        return;
    mapping.layers.regions = new OpenLayers.Layer.GML('Regions', baseurl + 'mapping/regions.geojson', {
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
    if (def(mapping.layers.districts))
        return;
    mapping.layers.districts = new OpenLayers.Layer.GML('Districts', baseurl + 'mapping/districts.geojson', {
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
    if (def(mapping.layers.cities))
        return;
    mapping.layers.cities = new OpenLayers.Layer.GML('Cities', baseurl + 'map-data/settlements/city?lang=' + lang, {
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
    mapping.layers.cities.setZIndex(99999);
}

function load_urban()
{
    var is_loaded = (def(mapping.layers.urban) && mapping.layers.urban.opacity == 1);
    if (mapping.map.zoom == 0 || mapping.map.zoom == 1)
    {
        if (is_loaded)
            mapping.layers.urban.setOpacity(0);
        return;
    }
    else if (is_loaded)
        return;
    mapping.layers.urban.setOpacity(1);
}

function load_hydro()
{
    if (def(mapping.layers.hydro))
        return;
    mapping.layers.hydro = new OpenLayers.Layer.GML('Hydro', baseurl + 'mapping/hydro.geojson', {
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
    if (def(mapping.layers.protected_areas))
        return;
    mapping.layers.protected_areas = new OpenLayers.Layer.GML('Protected Areas', baseurl + 'mapping/protected_areas.geojson', {
        format: OpenLayers.Format.GeoJSON,
        styleMap: new OpenLayers.StyleMap({
            fillColor: '#C9DFAF', //#E0E4CC
            strokeWidth: 0
        })
    });
}

function load_roads_main()
{
    if (def(mapping.layers.roads_main))
        return;
    mapping.layers.roads_main = new OpenLayers.Layer.GML('Main Roads', baseurl + 'mapping/roads_main.geojson', {
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
    if (def(mapping.layers.roads_secondary))
        return;
    mapping.layers.roads_secondary = new OpenLayers.Layer.GML('Main Secondary', baseurl + 'mapping/roads_secondary.geojson', {
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
    if (def(mapping.layers.water))
        return;
    mapping.layers.water = new OpenLayers.Layer.GML('Water', baseurl + 'mapping/water.geojson', {
        format: OpenLayers.Format.GeoJSON,
        styleMap: new OpenLayers.StyleMap({
            fillColor: '#A5BFDD',
            strokeColor: '#A5BFDD',
            strokeWidth: 1
        })
    });
}

function unload_all_projects()
{
    $('a[id^="control-"]').removeClass('active');
    $.each(mapping.project_storage, function(index, marker)
    {
        mapping.markers.removeMarker(marker);
    });
    mapping.project_storage = [];
    mapping.place_storage = new Object();
}

function load_region_projects(variations)
{

    $.each(variations, function(key, value)
    {
        variations[key] = value.replace('|', '-');
    });

    var request_url = baseurl + 'map-data/cluster-region-projects/' + variations.join(',') + '?lang=' + lang;

    $.getJSON(request_url, function(result)
    {
        if (!result.length)
            return;

        $.each(variations, function(key, value)
        {
            var parts = value.split('-');
            if (parts.length != 2)
                return;
            $('#control-' + parts[0]).addClass('active');
            $('#control-' + parts[0] + '-' + parts[1]).addClass('active');
        });

        $.each(result, function(index, region)
        {
            var count = parseInt(region.places),
            size = 'small';

            if (count == 0)
                return true;

            if (count > 8)
                size = 'large';
            else if (count > 3)
                size = 'medium';

            var coordinates = new OpenLayers.LonLat(region.longitude, region.latitude),
            marker = new OpenLayers.Marker(coordinates, mapping.icons['general'][size].clone());
            mapping.markers.addMarker(marker);

            $('#' + marker.icon.imageDiv.id).
            append('<div class="region-marker-wrapper ' + size + '">' + count + '</div>');

            mapping.project_storage.push(marker);

        });

    });
}

function add_project_marker(type, status, longitude, latitude, title, id)
{
    var coordinates = new OpenLayers.LonLat(longitude, latitude),
    marker = new OpenLayers.Marker(coordinates, mapping.icons[type][status].clone());

    marker.events.register('mousedown', marker, (function()
    {
        show_project_tooltip(coordinates, '<a href="project/' + id + '/?lang=' + lang + '">' + title + '</a>', status);
    }));

    mapping.markers.addMarker(marker);
    mapping.project_storage[type][status].push(marker);
}

function calculate_cluster_distance()
{
    var meters = 1; // 100 meters
    switch (mapping.map.zoom)
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
            meters = 2;
            break;
    }
    return parseInt((mapping.options.scales.length - mapping.map.zoom) * meters);
}

function load_projects(type, status)
{
    var request_url = baseurl + 'map-data/projects/' + type + '/' + status + '?lang=' + lang,
    distance = calculate_cluster_distance();

    $.getJSON(request_url, function(result)
    {
        if (!result.length)
            return;

        $('#control-' + type).addClass('active');
        $('#control-' + type + '-' + status).addClass('active');

        $.each(result, function(index, place)
        {
            var adjusted_latitude = place.longitude,
            adjusted_longitude = place.latitude,
            coordinate_hash = String(place.latitude) + String(place.longitude);

            while (mapping.place_storage[coordinate_hash] != null)
            {
                adjusted_latitude = parseFloat(place.longitude) + (Math.random() - distance) / 750;
                adjusted_longitude = parseFloat(place.latitude) + (Math.random() - distance) / 750;
                coordinate_hash = String(adjusted_latitude) + String(adjusted_longitude);
            }
            mapping.place_storage[coordinate_hash] = true;

            var coordinates = new OpenLayers.LonLat(adjusted_latitude, adjusted_longitude),
            marker = new OpenLayers.Marker(coordinates, mapping.icons[type][status].clone());
            marker.events.register('mousedown', marker, (function(title, coordinates, status, id, lang)
            {
                return function()
                {
                    show_project_tooltip(coordinates, '<a href="project/' + id + '/?lang=' + lang + '">' + title + '</a>', status);
                }
            })(place.title, coordinates, status, place.id, lang));

            mapping.markers.addMarker(marker);

            mapping.project_storage.push(marker);
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

function show_project_tooltip(lonlat, content, status)
{
    var offset = mapping.map.getPixelFromLonLat(lonlat),
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
    return mapping.map.zoom > 1 ? 'detailed' : 'regions';
}

function toggle_projects(type, status)
{
    mapping.project_variations[type][status] = !mapping.project_variations[type][status];
    reload_all_projects();
}

function project_variations()
{
    var result = [];
    $.each(mapping.options.project_types, function(type_index, type)
    {
        $.each(mapping.options.project_statuses, function(status_index, status)
        {
            if (mapping.project_variations[type][status] === false)
                return true;
            result.push(type + '|' + status);
        });
    });
    return result;
}

function reload_all_projects()
{
    var variations = project_variations(),
    state = zoom_mode();

    mapping.place_storage = new Object();

    unload_all_projects();

    if (state == 'regions')
        load_region_projects(variations);
    else
    {
        $.each(variations, function(key, value)
        {
            var parts = value.split('|');
            if (parts.length != 2)
                return true;
            load_projects(parts[0], parts[1]);
        });
    }
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
    if (def(mapping.layers[name]) && mapping.layers[name] != 'urban')
    {
        if (mapping.layers[name].opacity == 0)
        {
            mapping.layers[name].setOpacity(1);
            $('#overlay-' + name).addClass('active');
        }
        else
        {
            $('#overlay-' + name).removeClass('active');
            mapping.layers[name].setOpacity(0);
        }
    }
    switch (name)
    {
        case 'hydro':
            load_hydro();
            $('#overlay-hydro').toggleClass('active');
            mapping.map.addLayer(mapping.layers.hydro);
            break;
        case 'roads_main':
            load_roads_main();
            $('#overlay-roads-main').toggleClass('active');
            mapping.map.addLayer(mapping.layers.roads_main);
            break;
        case 'roads_secondary':
            load_roads_secondary();
            $('#overlay-roads-secondary').toggleClass('active');
            mapping.map.addLayer(mapping.layers.roads_secondary);
            break;
        case 'water':
            load_water();
            $('#overlay-water').toggleClass('active');
            mapping.map.addLayer(mapping.layers.water);
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
    mapping.markers.loaded = false;
    mapping.markers.setVisibility(true);
}

function zoom_in()
{
    return mapping.map.zoomIn();
}

function zoom_out()
{
    return mapping.map.zoomOut();
}

function map_commons()
{

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

$(window).load(initialize_mapping);

$(map_commons);
