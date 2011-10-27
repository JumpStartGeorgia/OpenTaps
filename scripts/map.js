var loaded = false,
map,
base,
map_options = {
    boundsLeft: 4390630.1231925,
    boundsTop: 5427277.3672416,
    boundsRight: 5422472.9529191,
    boundsBottom: 4999230.0089212,
    zoom: 8,
    default_lat: 42.23665,
    default_lon: 43.59375,
    controls: [
    new OpenLayers.Control.Navigation()
    //new OpenLayers.Control.MousePosition(),
    //new OpenLayers.Control.LoadingPanel()
    ]
},
markers = new OpenLayers.Layer.Markers('Markers')
layers = new Object(),
    icon_size = new OpenLayers.Size(27, 27),
    icon_offset = new OpenLayers.Pixel(-(icon_size.w/2), -icon_size.h),
    icons = new Object();

icons.sewage = new Object();
icons.sewage.completed = new OpenLayers.Icon('images/map/projects/sewage_completed.png', icon_size, icon_offset);
icons.sewage.current = new OpenLayers.Icon('images/map/projects/sewage_current.png', icon_size, icon_offset);
icons.sewage.scheduled = new OpenLayers.Icon('images/map/projects/sewage_scheduled.png', icon_size, icon_offset);

icons.water_supply = new Object();
icons.water_supply.completed = new OpenLayers.Icon('images/map/projects/water_supply_completed.png', icon_size, icon_offset);
icons.water_supply.current = new OpenLayers.Icon('images/map/projects/water_supply_current.png', icon_size, icon_offset);
icons.water_supply.scheduled = new OpenLayers.Icon('images/map/projects/water_supply_scheduled.png', icon_size, icon_offset);

icons.water_pollution = new Object();
icons.water_pollution.completed = new OpenLayers.Icon('images/map/projects/water_pollution_completed.png', icon_size, icon_offset);
icons.water_pollution.current = new OpenLayers.Icon('images/map/projects/water_pollution_current.png', icon_size, icon_offset);
icons.water_pollution.scheduled = new OpenLayers.Icon('images/map/projects/water_pollution_scheduled.png', icon_size, icon_offset);

icons.irrigation = new Object();
icons.irrigation.completed = new OpenLayers.Icon('images/map/projects/irigation_completed.png', icon_size, icon_offset);
icons.irrigation.current = new OpenLayers.Icon('images/map/projects/irigation_current.png', icon_size, icon_offset);
icons.irrigation.scheduled = new OpenLayers.Icon('images/map/projects/irigation_scheduled.png', icon_size, icon_offset);

icons.water_quality = new Object();
icons.water_quality.completed = new OpenLayers.Icon('images/map/projects/water_quality_completed.png', icon_size, icon_offset);
icons.water_quality.current = new OpenLayers.Icon('images/map/projects/water_quality_current.png', icon_size, icon_offset);
icons.water_quality.scheduled = new OpenLayers.Icon('images/map/projects/water_quality_scheduled.png', icon_size, icon_offset);

icons.water_accidents = new Object();
icons.water_accidents.completed = new OpenLayers.Icon('images/map/projects/water_accidents_completed.png', icon_size, icon_offset);
icons.water_accidents.current = new OpenLayers.Icon('images/map/projects/water_accidents_current.png', icon_size, icon_offset);
icons.water_accidents.scheduled = new OpenLayers.Icon('images/map/projects/water_accidents_scheduled.png', icon_size, icon_offset);

function mapping()
{

    // Map
    map = new OpenLayers.Map('map', {
        controls: map_options.controls,
        restrictedExtent: new OpenLayers.Bounds(map_options.boundsLeft, map_options.boundsBottom, map_options.boundsRight, map_options.boundsTop),
        eventListeners: {
            'loadend': on_load,
            'moveend': on_move
        }
    });

    // Base Layer
    base = new OpenLayers.Layer.OSM('Georgia', 'http://tile.mapspot.ge/en/${z}/${x}/${y}.png', {
        numZoomLevels: 19,
        opacity: 0
    });

    // Add base and markers overlay layers to the map
    map.addLayers([base, markers]);

    // Load and initialize vector overlays
    load_regions();
    load_roads();
    load_protected_areas();
    load_water();
    load_cities();
    load_hydro();

    // Add initialized vector overlay-layers to the map
    for (var idx in layers)
        map.addLayer(layers[idx]);

    // Center and zoom map to the very heart of Georgia
    map.setCenter(new OpenLayers.LonLat(map_options.default_lon, map_options.default_lat));
    map.zoomTo(map_options.zoom);

}

function load_regions()
{
    layers.region = new OpenLayers.Layer.GML('Regions', 'mapping/regions.geojson', {
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

function load_cities()
{
    layers.cities = new OpenLayers.Layer.GML('Regions', 'mapping/cities.geojson', {
        format: OpenLayers.Format.GeoJSON,
        styleMap: new OpenLayers.StyleMap({
            pointRadius: 2,
            fillColor: '#FFFFFF',
            fillOpacity: 0.9,
            strokeWidth: 0.5,
            strokeColor: '#555555',
            label: '${NAME_ENG}',
            fontColor: '#AAAAAA',
            fontSize: '9px',
            fontFamily: 'Arial',
            labelAlign: 'ct'
        })
    });
}

function load_hydro()
{
    layers.hydro = new OpenLayers.Layer.GML('Regions', 'mapping/hydro.geojson', {
        format: OpenLayers.Format.GeoJSON,
        styleMap: new OpenLayers.StyleMap({
            pointRadius: 4,
            fillColor: '#F38630',
            fillOpacity: 0.9,
            strokeWidth: 0,
            label: '${NAME_ENG}',
            fontColor: '#AAAAAA',
            fontSize: '9px',
            fontFamily: 'Arial',
            labelAlign: 'ct'
        })
    });
}

function load_protected_areas()
{
    layers.protected_areas = new OpenLayers.Layer.GML('Regions', 'mapping/protected_areas.geojson', {
        format: OpenLayers.Format.GeoJSON,
        styleMap: new OpenLayers.StyleMap({
            pointRadius: 4,
            fillColor: '#E0E4CC',
            fillOpacity: 0.9,
            strokeWidth: 0,
            label: '${NAME}',
            fontColor: '#AAAAAA',
            fontSize: '10px',
            fontFamily: 'Arial',
            labelAlign: 'cm'
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
    object.setOpacity(object.opacity == 0 ? 1 : 0);
}

function on_load()
{
    console.log('Loaded...');
    $('#map-overlay span').toggle();
}

function on_move(event)
{
    var bounds = event.object.baseLayer.getExtent();
//.transform(new OpenLayers.Projection("EPSG:900913"), new OpenLayers.Projection("EPSG:4326"));
//load_villages(bounds.left, bounds.top, bounds.right, bounds.bottom);
}

function zoom_in()
{
    return map.zoomIn();
}

function zoom_out()
{
    return map.zoomOut();
}

$(function()
{

    var drop_menus = $('.map-drop-menu');

    $('body').not('.map-drop-menu').click(function(){
        drop_menus.hide();
    });

    $('#map-filter-button').click(function(event)
    {
        event.stopPropagation();
        drop_menus.hide();
        $('#map-filter').toggle();
    });

    $('#map-overlays-button').click(function(event)
    {
        event.stopPropagation();
        drop_menus.hide();
        $('#map-overlays').toggle();
    });

    $('.map-drop-menu ul li a').not('.skip').click(function()
    {
        $(this).toggleClass('active');
    /*
        if ($(this).hasClass('sub') && $(this).hasClass('active'))
            $(this).parent().parent().children('a').addClass('active');
        else
            $(this).parent().parent().children('a').removeClass('active');
            */
    });

    $('.map-drop-menu ul li').hover(function()
    {
        var sub_menu = $(this).children('ul');
        if (sub_menu.length)
            sub_menu.toggle();
    });

});
