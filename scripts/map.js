/**
 * Mapping script for OpenTaps project.
 * Used plain JavaScript, jQuery, OpenLayers and geo-data by JumpStart Georgia in GeoJSON format.
 * Otar Chekurishvili - otar@chekurishvili.com
 */

// jQuery RegEx selector plugin
jQuery.expr[':'].regex = function(elem, index, match)
{
    var match_params = match[3].split(','),
    valid_labels = /^(data|css):/,
    attr = {
        method: match_params[0].match(valid_labels) ? match_params[0].split(':')[0] : 'attr',
        property: match_params.shift().replace(valid_labels,'')
    },
    regex = new RegExp(match_params.join('').replace(/^\s+|\s+$/g,''), 'ig');
    return regex.test(jQuery(elem)[attr.method](attr.property));
}

// Define globals and configurations
var map,
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
    index = 0,
    project_types = ['sewage', 'water_supply', 'water_pollution', 'irrigation', 'water_quality', 'water_accidents'],
    project_statuses = ['completed', 'current', 'scheduled'],
    project_status_index = 0,
    project_storage = new Object(),
    new_project_storage = [],
    places = new Object();

// Generate icons
for (index in project_types)
{
    icons[project_types[index]] = new Object();
    project_storage[project_types[index]] = new Object();
    places[project_types[index]] = new Object();
    for (project_status_index in project_statuses)
    {
        icons[project_types[index]][project_statuses[project_status_index]] = new OpenLayers.Icon('images/map/projects/' + project_types[index] + '_' + project_statuses[project_status_index] + '.png', icon_size, icon_offset);
        project_storage[project_types[index]][project_statuses[project_status_index]] = [];
        places[project_types[index]][project_statuses[project_status_index]] = false;
    }
    project_status_index = 0;
}
index = 0,
    all_icon = new OpenLayers.Icon('images/map/projects/all_all.png', icon_size, icon_offset),
    coordinate_hash_storage = new Object();

function mapping()
{

    // Mr. Map!
    map = new OpenLayers.Map('map', {
        controls: map_options.controls,
        scales: map_options.scales,
        restrictedExtent: new OpenLayers.Bounds(map_options.bounds_left, map_options.bounds_bottom, map_options.bounds_right, map_options.bounds_top),
        eventListeners: {
            /*'click': function(event){
                console.log(map.getLonLatFromViewPortPx(event.xy));
            },*/
            //'movestart': on_zoom,
            'moveend': on_zoom
        }
    });

    // Load all external layers
    load_all();
    preload_layers();

    // Add markers layer as a very top overlay
    map.addLayer(markers);
    markers.setZIndex(999999);

    // Center and zoom map to the very heart of Georgia
    map.setCenter(new OpenLayers.LonLat(map_options.default_lon, map_options.default_lat));
    map.zoomToMaxExtent();

}

function preload_layers()
{

    // Urban
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
    load_bounds();
    load_regions();
    load_protected_areas();
    load_cities();
    load_urban();
    load_water()
    load_roads_main();
    //load_villages();

    // Add initialized vector overlay-layers to the map
    for (var idx in layers)
        map.addLayer(layers[idx]);

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

/*
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
 */

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
    if (!new_project_storage.length)
        return;
    $('a[id^="control-"]').removeClass('active');
    for (var index = 0; index < new_project_storage.length; index++)
        markers.removeMarker(new_project_storage[index]);
    new_project_storage = [];
    coordinate_hash_storage = new Object();
}

function load_region_projects(type, status)
{
    var request_url = baseurl + 'map-data/cluster-region-projects/' + type + '/' + status + '?lang=' + lang;
    //var request_url = baseurl + 'map-data/region-projects?lang=' + lang;
    $.getJSON(request_url, function(result)
    {
        if ($.isEmptyObject(result) || !result.length)
            return;
        var project,
        coordinates,
        marker;
        $('#control-' + type).addClass('active');
        $('#control-' + type + '-' + status).addClass('active');
        for (var index in result)
        {
            if (!def(result[index]))
                continue;

            project = result[index];

            if (!def(project.places) || project.places == 0)
                continue;

            coordinates = new OpenLayers.LonLat(project.longitude, project.latitude);
            marker = new OpenLayers.Marker(coordinates, all_icon.clone());
            marker.setOpacity(0.95);
            markers.addMarker(marker);

            $('img[id$="_innerImage"]').
            last().
            parent().
            addClass('region-marker-container').
            append('<div class="region-marker-wrapper"><div class="region-marker-item">' + parseInt(project.places) + '</div></div>')
            .hover(function()
            {
                $(this).stop().animate({
                    opacity: .65
                });
            }, function()
            {
                $(this).stop().animate({
                    opacity: 1
                });
            })
            .click((function(coordinates)
            {
                return function()
                {
                    region_marker_action(coordinates);
                }
            })(coordinates));

            new_project_storage.push(marker);

        }
    });
//$('img[id$="_innerImage"]').attr('onclick', 'alert("dasdas");');
}

function region_marker_action(coordinates)
{
    unload_region_projects();
    map.zoomTo(2);
    map.setCenter(coordinates);
    reload_all_projects();
}

/*
function load_projects(type, status)
{
    var radius = parseInt((map_options.scales.length - map.zoom) * 10),
    request_url = baseurl + 'map-data/cluster-projects/' + type + '/' + status + '/' + radius + '?lang=' + lang;
    $.getJSON(request_url, function(result)
    {
        if ($.isEmptyObject(result) || !result.length)
            return;
        $('#control-' + type).addClass('active');
        $('#control-' + type + '-' + status).addClass('active');
        var place,
        coordinates,
        outdex,
        marker,
        element,
        minimarker
        minimarkers = [],
        minimarkers_element,
        proj;
        for (var index = 0, length = result.length; index < length; index++)
        {
            place = result[index];
            if (place.projects.length > 1)
            {
                coordinates = new OpenLayers.LonLat(place.projects[0].latitude, place.projects[0].longitude);
                marker = new OpenLayers.Marker(coordinates, all_icon.clone());
                marker.setOpacity(0.95);
                markers.addMarker(marker);
                element = $('img[id$="_innerImage"]').
                last().
                parent().
                addClass('region-marker-container').
                append('<div class="region-marker-wrapper"><div class="region-marker-item">' + parseInt(place.projects.length) + '</div><div id="minimarkers" style="display: none"></div></div>');
                for (outdex = 0; outdex < place.projects.length; outdex++)
                {
                    proj = place.projects[outdex];
                    minimarker = '<img id="minimarker-' + outdex + '" src="images/map/projects/' + type + '_' + status + '.png" />';
                    $('#minimarker-' + outdex).hover(function()
                    {
                        console.log(proj);
                    });
                    minimarkers.push(minimarker);
                }
                outdex = 0;
                minimarkers_element = $('#minimarkers').append(minimarkers.implode(''));
                element.hover(function()
                {
                    $(this).hide();
                    minimarkers_element.show();
                }, function()
                {
                    minimarkers_element.hide();
                    $(this).show();
                });
            }
            else
            {
                (function(type, status, longitude, latitude, title, id)
                {
                    add_project_marker(type, status, longitude, latitude, title, id);
                })(type, status, place.latitude, place.longitude, place.projects[0].title, place.projects[0].id);
            }
        //comment start
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
                project_storage[type][status].push(marker);
            }
            pidx = 0;
             //comment end
        }
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
    return (map_options.scales.length - map.zoom) * meters;
}

function load_projects(type, status)
{
    var request_url = baseurl + 'map-data/projects/' + type + '/' + status + '?lang=' + lang;
    $.getJSON(request_url, function(result)
    {
        if ($.isEmptyObject(result) || !result.length)
            return;
        $('#control-' + type).addClass('active');
        $('#control-' + type + '-' + status).addClass('active');
        var coordinates,
        marker,
        place,
        coordinate_hash,
        actual_latitude,
        actual_longitude,
        adjusted_latitude,
        adjusted_longitude,
        distance = calculate_cluster_distance();
        for (var index = 0, length = result.length; index < length; index++)
        {
            place = result[index];

            actual_latitude = adjusted_latitude = place.longitude;
            actual_longitude = adjusted_longitude = place.latitude;
            coordinate_hash = actual_latitude + actual_longitude;
            while (coordinate_hash_storage[coordinate_hash] != null)
            {
                adjusted_latitude = parseFloat(actual_latitude) + (Math.random() - distance) / 750;
                adjusted_longitude = parseFloat(actual_longitude) + (Math.random() - distance) / 750;
                coordinate_hash = String(adjusted_latitude) + String(adjusted_longitude);
            }
            coordinate_hash_storage[coordinate_hash] = true;
            //coordinates = new OpenLayers.LonLat(result[idx].places[pidx].latitude, result[idx].places[pidx].longitude);

            coordinates = new OpenLayers.LonLat(adjusted_latitude, adjusted_longitude);

            marker = new OpenLayers.Marker(coordinates, icons[type][status].clone());
            //marker.setOpacity(0.95);
            markers.addMarker(marker);
            marker.events.register('mousedown', marker, (function(title, coordinates, status, id, lang)
            {
                return function()
                {
                    show_project_tooltip(coordinates, '<a href="project/' + id + '/?lang=' + lang + '">' + title + '</a>', status);
                }
            })(place.title, coordinates, status, place.id, lang));

            project_storage[type][status].push(marker);

        }
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

function unload_all_projects()
{
    var variations = project_variations();
}

function unload_projects(type, status)
{
    if (!$('#control-' + type).parent().find('ul li a.active').length)
        $('#control-' + type).removeClass('active');
    $('#control-' + type + '-' + status).removeClass('active');
    for (var index = 0; index < project_storage[type][status].length; index++)
        markers.removeMarker(project_storage[type][status][index]);
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
    var result = [],
    status_index = 0;
    for (var type_index = 0; type_index < project_types.length; type_index++)
    {
        for (status_index = 0; status_index < project_statuses.length; status_index++)
        {
            if (places[project_types[type_index]][project_statuses[status_index]] === false)
                continue;
            result.push(project_types[type_index] + '|' + project_statuses[status_index]);
        }
        status_index = 0;
    }
    return result;
}

function reload_all_projects()
{
    var variations = project_variations(),
    type,
    status,
    parts;
    unload_region_projects();
    coordinate_hash_storage = new Object();
    for (var index = 0; index < variations.length; index++)
    {
        parts = variations[index].split('|');
        type = parts[0];
        status = parts[1];
        unload_projects(type, status);
        if (zoom_mode() == 'regions')
            load_region_projects(type, status);
        else
            load_projects(type, status);
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
    //if (def(layers[name]) && layers[name] != 'urban' && layers[name] != 'villages')
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
