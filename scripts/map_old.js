/*var mouse_is_over_map_menu = true;
$('#map_menu').mouseenter(function(){ mouse_is_over_map_menu = true; });
$('#map_menu').mouseleave(function(){ mouse_is_over_map_menu = false; });*/

var mouse_is_over_map = false;
$('#map').mouseenter(function(){
    mouse_is_over_map = true;
});
$('#map').mouseleave(function(){
    mouse_is_over_map = false;
/*if (!mouse_is_over_map_menu)
	{
		$("#map_menu").animate({ 'height': '0px' }, 500, function(){
			$(this).css('visibility', 'hidden');
			map_menu_animate = false;
		});
	}*/
});


var zoomNum = 1;
var map = null;
var markers = null;
var maximize = null;
var minimize = null;
var map_confs = {
    "boundsLeft": region_map_boundsLeft != false ? region_map_boundsLeft : 4260630.1231925,
    "boundsBottom": region_map_boundsBottom != false ? region_map_boundsBottom : 4999230.0089212,
    "boundsRight": region_map_boundsRight != false ? region_map_boundsRight : 5422472.9529191,
    "boundsTop": region_map_boundsTop != false ? region_map_boundsTop : 5427277.3672416,
    "zoom": region_map_zoom != false ? region_map_zoom : 7,
    "maxZoomOut": region_map_maxzoomout != false ? region_map_maxzoomout : 7,
    "lon":  region_map_longitude  != false ? region_map_longitude  : 4876406.8229462 ,
    "lat":  region_map_latitude != false ? region_map_latitude : 5183290.372998,
    "make_default_markers": region_make_def_markers == false ? region_make_def_markers : true,
    "show_default_buttons": region_show_def_buttons == false ? region_show_def_buttons : true,
    "marker_click" : region_marker_click == false ? region_marker_click : true
};

var mapspot_confs = {
    "boundsLeft":38.704833984374,
    "boundsBottom":-45.120849609376,
    "boundsRight":49.141845703124,
    "boundsTop":-41.275634765626,
    "zoom":7,
    "maxZoomOut": 7,
    "lon":44.230957031249,
    "lat":-43.483886718751
};

var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];

function get_osm_url (bounds)
{
    var res = this.map.getResolution();
    var x = Math.round ((bounds.left - this.maxExtent.left) / (res * this.tileSize.w));
    var y = Math.round ((this.maxExtent.top - bounds.top) / (res * this.tileSize.h));
    var z = this.map.getZoom();
    var path =  z + "/" + x + "/" + y ;
    var url = this.url;
    if (url instanceof Array)
    {
        url = this.selectUrl(path, url);
    };
    return url + path;
}
var map_menu_animate = false;
function setUpPanControls(){
    var max_button = function(){
        map.zoomTo(map.getZoom() + zoomNum);
    };
    var min_button = function(){
        stopZoomOut();
    };
    var filter_button = function(){
        if(map_menu_animate == false){
            map_menu_animate = true;
            $("#map_menu").css('visibility','visible').animate({
                'height':'161px'
            },500);
        }
        else{
            map_menu_animate = false;
            $('#map_and_menus').children('div').each(function(){
                if( $(this).attr('id').indexOf('map_submenu') == 0 ){
                    $(this).css('visibility','hidden');
                }
            });
            $("#map_menu").animate({
                'height':'0px'
            },500,function(){
                $(this).css('visibility','hidden');
            });

        }

    };
    var set_button = function(){
    //alert("sets");
    };
    var tag_button = function(){
    //alert("tags");
    };
    if(map_confs.show_default_buttons){
        maximize = new OpenLayers.Control.Button({
            displayClass:"max",
            trigger:max_button
        });
        minimize = new OpenLayers.Control.Button({
            displayClass:"min",
            trigger:min_button
        });
    }
    var filters = new OpenLayers.Control.Button({
        displayClass:"filters",
        trigger:filter_button
    });
    var sets = new OpenLayers.Control.Button({
        displayClass:"sets",
        trigger:set_button
    });
    var tags = new OpenLayers.Control.Button({
        displayClass:"tags",
        trigger:tag_button
    });
    var keyboard_def = new OpenLayers.Control.KeyboardDefaults({
        slideFactor:50
    });

    return [keyboard_def,filters];//,sets,tags];
}

function stopZoomOut(){
    if(map.getZoom() != map_confs.maxZoomOut){
        map.zoomTo(map.getZoom() - zoomNum);
    }
}

function buthoverEffect(but_class){
/*document.getElementsByClassName(but_class)[0].onmouseover = function(){
			this.style.opacity = 1;
		}
		document.getElementsByClassName(but_class)[0].onmouseout = function(){
			this.style.opacity = 0.5;
		}
		document.getElementsByClassName(but_class)[0].onmouseover = function(){
			this.style.opacity = 1;
		}
		document.getElementsByClassName(but_class)[0].onmouseout = function(){
			this.style.opacity = 0.5;
		}*/
}
var k = null;
function addMarkerLayer(layer_name)
{
    markers = new OpenLayers.Layer.Markers( layer_name );
    map.addLayer(markers);
}

var popup_over = false;
var popup=null;
function make_popup(lonlat, size, content)
{
    popup = new OpenLayers.Popup("chicken",
        new OpenLayers.LonLat(lonlat['lon'],lonlat['lat']),
        new OpenLayers.Size(size['width'],size['height']),
        content,
        false);

    popup.events.register('mouseout', popup, function(){
        popup_over = true;
    });


    popup.backgroundColor = "rgb(18%,72%,93%);";
    map.addPopup(popup);
}

var marker_id = null;
function makeMarker(img_source, img_width, img_height, lon, lat, id, type, i)
{
    var size = new OpenLayers.Size(img_width,img_height);
    var offset = new OpenLayers.Pixel(-size.w / 2, -size.h / 2);
    var ico = new OpenLayers.Icon(img_source,size,offset);
    var marker = new OpenLayers.Marker(new OpenLayers.LonLat(lon,lat),ico);
    if (map_confs.marker_click)
    {
        marker.events.register('click', marker, function(e){
            marker_id = id;
            //alert(marker_id);
            marker_animate(e.target.id, lon, lat,type,i);
            $(e.target).css('cursor', 'default');
        });
        marker.events.register('mouseover',marker,function(e){
            $(e.target).css('cursor','pointer');
            $(e.target).css({
                'z-index':'6000'
            });
        });
        marker.events.register('mouseout',marker,function(e){
            if(popup_over){
                marker_animate_back(e.target.id);
                $(e.target).css({
                    'z-index':''
                });
                popup_over = false;
                popup.destroy();
                popup = null;
            }
            else{
                $(e.target).css({
                    'z-index':''
                });
            }
        });
    }
    markers.addMarker(marker);
}

var timeout = null;
function map_menu_filter_over( ths,filter_text )
{
    $('#' + ths).css('background-color','#FFF');
    $('#filter_text_' + filter_text).css('font-weight','bold');

    if( filter_text.indexOf('projects')!=-1 ){
        if( filter_text === 'projects' ){
            $('#map_and_menus').children('div').each(function(){
                if( $(this).attr('id').indexOf('map_submenu') == 0 ){
                    $(this).css('visibility','hidden');
                }
            });
        }
        window.clearTimeout(timeout);
        timeout=null;
        $('#map_submenu_' + filter_text).css('visibility','visible');
    }
    else if( filter_text === 'news' ){
        if( filter_text === 'news' ){
            $('#map_and_menus').children('div').each(function(){
                if( $(this).attr('id').indexOf('map_submenu') == 0 ){
                    $(this).css('visibility','hidden');
                }
            });
        }
        window.clearTimeout(timeout);
        timeout=null;
    }
    else if( filter_text === 'date' || !isNaN(filter_text) ){
        if( filter_text === 'date'){
            $('#map_and_menus').children('div').each(function(){
                if( $(this).attr('id').indexOf('map_submenu') == 0 ){
                    $(this).css('visibility','hidden');
                }
            });
        }
        window.clearTimeout(timeout);
        timeout=null;
        $('#map_submenu_' + filter_text+'_1').css('visibility','visible');
        $('#map_submenu_' + filter_text+'_2').css('visibility','visible');
    }
    else {
        if( filter_text === 'type' ){
            $('#map_and_menus').children('div').each(function(){
                if( $(this).attr('id').indexOf('map_submenu') == 0 ){
                    $(this).css('visibility','hidden');
                }
            });
        }
        window.clearTimeout(timeout);
        timeout=null;
        $('#map_submenu_' + filter_text).css('visibility','visible');
    }
}

function map_menu_filter_out( ths,filter_text )
{
    $('#' + ths).css('background-color','#F5F5F5');
    $('#filter_text_' + filter_text).css('font-weight','normal');
    if( filter_text.indexOf('projects')!=-1 ){
        timeout = window.setTimeout(function(){
            $('#map_submenu_projects').css('visibility','hidden');
        },1000);
    }
    else if( !isNaN(filter_text) || filter_text === 'date'){
        timeout = window.setTimeout(function(){
            $('#map_submenu_date_1').css('visibility','hidden');
            $('#map_submenu_date_2').css('visibility','hidden');
        },1000);
    }
    else{
        timeout = window.setTimeout(function(){
            $('#map_submenu_type').css('visibility','hidden');
        },1000);
    }
}

function display_filter_markers(filter)
{


    if( filter ===  'filter_checkbox_projects_completed'){
        for(var i=0;i<projects.length-1;i++){
            if( projects[i+1][2].getTime() < projects[0][0].getTime()  ){
                var img = baseurl + "images/project.png";
                makeMarker(img,20,20,projects[i+1][8],projects[i+1][9],projects[i+1][0],'project',i);
            }
        }
    }
    else if( filter === 'filter_checkbox_projects_current' ){
        for(var i=0;i<projects.length-1;i++){
            if( projects[i+1][1].getTime() < projects[0][0].getTime() && projects[i+1][2].getTime() > projects[0][0].getTime()  ){
                var img = baseurl + "images/project-current.png";
                makeMarker(img,20,20,projects[i+1][8],projects[i+1][9],projects[i+1][0],'project',i);
            }
        }
    }
    else if( filter === 'filter_checkbox_projects_scheduled' ){
        for(var i=0;i<projects.length-1;i++){
            if(  projects[i+1][1].getTime() > projects[0][0].getTime() ){
                var img = baseurl + "images/project-scheduled.png";
                (img,20,20,projects[i+1][8],projects[i+1][9],projects[i+1][0],'project',i);
            }
        }
    }
    else if( filter === 'filter_checkbox_Water_Pollution' ){
        for(var i=0;i<projects.length-1;i++)
            if( projects[i+1][7] === "Water Pollution" ){
                makeMarker(baseurl + "images/water-pollution.png",20,20,projects[i+1][8],projects[i+1][9],projects[i+1][0],'project',i);
            }
    }
    else if( filter === 'filter_checkbox_Sewage' ){
        for(var i=0;i<projects.length-1;i++)
            if( projects[i+1][7] === "Sewage" ){
                makeMarker(baseurl + "images/sewage.png",20,20,projects[i+1][8],projects[i+1][9],projects[i+1][0],'project',i);
            }
    }
    else if( filter === 'filter_checkbox_Water_Supply' ){
        for(var i=0;i<projects.length-1;i++)
            if( projects[i+1][7] === "Water Supply" ){
                makeMarker(baseurl + "images/water-supply.png",20,20,projects[i+1][8],projects[i+1][9],projects[i+1][0], 'project',i);
            }
    }
    else if (filter === 'filter_checkbox_Irrigation'){
        for (var i = 0; i < projects.length - 1; i ++)
            if( projects[i+1][7] === "Irrigation" )
            {
                makeMarker(baseurl + "images/irrigation.png",20,20,projects[i+1][8],projects[i+1][9],projects[i+1][0], 'project',i);
            }
    }
    else if( filter === 'filter_checkbox_Water_Quality' ){
        for(var i=0;i<projects.length-1;i++)
            if( projects[i+1][7] === "Water Quality" ){
                makeMarker(baseurl + "images/water-quality.png",20,20,projects[i+1][8],projects[i+1][9],projects[i+1][0],'project',i);
            }
    }
    else if( filter === 'filter_checkbox_Water_Accidents' ){
        for(var i=0;i<projects.length-1;i++)
            if( projects[i+1][7] === "Water Accidents" ){
                makeMarker(baseurl + "images/water-accidents.png",20,20,projects[i+1][8],projects[i+1][9],projects[i+1][0],'project',i);
            }
    }
    else if( !isNaN(filter.substr(filter.length-4)) ){
        var year = filter.substr(filter.length-4);
        for(var i=0;i<projects.length-1;i++){
            if( projects[i+1][1].getFullYear() == year || projects[i+1][2].getFullYear() == year || (projects[i+1][2].getFullYear() > year && projects[i+1][1].getFullYear() < year) ){
                var img = baseurl + "images/project.png";
                makeMarker(img,20,20,projects[i+1][8],projects[i+1][9],projects[i+1][0],'project',i);
            }
        }
    }
    else if( filter === 'filter_checkbox_news' ){
        for(var i=0;i<news.length;i++){
            var img = baseurl + "images/news.png";
            makeMarker(img,20,20,news[i][1],news[i][2],1,'news',i);
        }
    }


}

function change_filter_checkboxes(checkbx)
{
    if( checkbx != 'projects' && checkbx != 'type' && checkbx != 'date' ){
        var filter_checkboxes = document.getElementById('map_and_menus').getElementsByTagName('input');
        for(var i=0,len=filter_checkboxes.length;i<len;i++)
        {
            if ( !isNaN(checkbx))
            {
                if (isNaN(filter_checkboxes[i].id.substr(filter_checkboxes[i].id.length - 4)))
                {
                    $(filter_checkboxes[i]).removeAttr('checked');
                }
            }
            else if (checkbx.indexOf('projects') != -1)
            {
                if (filter_checkboxes[i].id.indexOf('projects') == -1)
                {
                    $(filter_checkboxes[i]).removeAttr('checked');
                }
            }
            else if( checkbx === 'news'){
                if( filter_checkboxes[i].id != 'filter_checkbox_news' ){
                    $(filter_checkboxes[i]).removeAttr('checked');
                }
            }
            else{
                if( filter_checkboxes[i].id.indexOf('projects')!=-1 || !isNaN( filter_checkboxes[i].id.substr(filter_checkboxes[i].id.length-4) ) || filter_checkboxes[i].id.indexOf('news')!=-1 ){
                    $(filter_checkboxes[i]).removeAttr('checked');
                }
            }
        }
    }
}

function check_filter_checkboxes()
{

    var filter_checkboxes = document.getElementById('map_and_menus').getElementsByTagName('input');

    for(var i=0,len=filter_checkboxes.length;i<len;i++)
    {
        if( $("#"+filter_checkboxes[i].id).is(':checked') )
            display_filter_markers(filter_checkboxes[i].id);
    }

}

function map_menu_filter_click(checkbox_text)
{

    if( $('#filter_checkbox_' + checkbox_text).is(':checked') ){

        $('#filter_checkbox_' + checkbox_text).removeAttr('checked');
        if(checkbox_text === 'projects'){
            $('#filter_checkbox_projects_completed').removeAttr('checked');
            $('#filter_checkbox_projects_current').removeAttr('checked');
            $('#filter_checkbox_projects_scheduled').removeAttr('checked');
        }


        if( popup != null ){
            popup.destroy();
            popup = null;
            click_done = false;
        }
        map.removeLayer(markers);

        addMarkerLayer("Marker Layer");
        check_filter_checkboxes();

    }
    else{

        $('#filter_checkbox_' + checkbox_text).attr('checked','checked');
        /*			if(checkbox_text === 'projects'){
				$('#filter_checkbox_projects_completed').attr('checked','checked');
				$('#filter_checkbox_projects_current').attr('checked','checked');
				$('#filter_checkbox_projects_scheduled').attr('checked','checked');
			}
			if( checkbox_text === 'projects_completed' || checkbox_text === 'projects_current' || checkbox_text === 'projects_scheduled')
				$('#filter_checkbox_projects').attr('checked','checked');*/



        change_filter_checkboxes(checkbox_text);
        if( popup != null ){
            popup.destroy();
            popup = null;
            click_done = false;
        }
        map.removeLayer(markers);
        addMarkerLayer("Marker Layer");
        check_filter_checkboxes();
    }
}



var deven = null;
function map_init()
{

    map = new OpenLayers.Map("map",{
        controls:[],
        restrictedExtent:new OpenLayers.Bounds(map_confs.boundsLeft,map_confs.boundsBottom,map_confs.boundsRight,map_confs.boundsTop)
    });

    deven = new OpenLayers.Layer.OSM("English", "http://a.tile.mapspot.ge/ndi_en/${z}/${x}/${y}.png", {
        numZoomLevels: 19
    }, {
        isBaseLayer:true
    });
    deven.setOpacity(0.4);
    var devka = new OpenLayers.Layer.OSM("Georgian", "http://a.tile.mapspot.ge/ndi_ka/${z}/${x}/${y}.png", {
        numZoomLevels: 19
    }, {
        isBaseLayer:false
    });
    var vector_layer = new OpenLayers.Layer.Vector("Boxes");
    /*var mapspot_layer = new OpenLayers.Layer.TMS(
			"MapSpot",
			"http://tile.mapspot.ge/new_en/",
			{type:"png",getURL:get_osm_url},
			{isBaseLayer:true}
	);*/

    var nav = new OpenLayers.Control.Navigation({
        handleRightClicks:true,
        wheelDown:function(evt,delta){
            stopZoomOut();
        }
    });
    nav.defaultDblRightClick = function(){
        stopZoomOut();
    };

    var conts = setUpPanControls();
    if(map_confs.show_default_buttons) conts.push(maximize,minimize);
    conts[0].defaultKeyPress = function(code){
        if (!mouse_is_over_map)
            return;
        switch(code.keyCode) {
            case OpenLayers.Event.KEY_LEFT:
                this.map.pan(-this.slideFactor, 0);
                break;
            case OpenLayers.Event.KEY_RIGHT:
                this.map.pan(this.slideFactor, 0);
                break;
            case OpenLayers.Event.KEY_UP:
                this.map.pan(0, -this.slideFactor);
                break;
            case OpenLayers.Event.KEY_DOWN:
                this.map.pan(0, this.slideFactor);
                break;
            case 33:
                var size = this.map.getSize();
                this.map.pan(0, -0.75*size.h);
                break;
            case 34:
                var size = this.map.getSize();
                this.map.pan(0, 0.75*size.h);
                break;
            case 35:
                var size = this.map.getSize();
                this.map.pan(0.75*size.w, 0);
                break;
            case 36:
                var size = this.map.getSize();
                this.map.pan(-0.75*size.w, 0);
                break;

            case 43:
            case 61:
            case 187:
            case 107:
                this.map.zoomIn();
                break;
            case 45:
            case 109:
            case 189:
            case 95:
                stopZoomOut();
                break;
        }
    };

    var panel = new OpenLayers.Control.Panel({
        div:document.getElementById("panel"),
        defaultControl:conts[0]
    });
    panel.addControls(conts);
    map.addLayers([deven,devka]);//[mapspot_layer]);
    addMarkerLayer("Marker Layer");

    if(	map_confs.make_default_markers	  )//{
        for(var i=0;i<places.length;i++){
            makeMarker(baseurl + "images/marker.png",20,20,places[i][1],places[i][2]);
        }
    /*}
		else{
			makeMarker("../../images/marker.png",20,20,map_confs.lon,map_confs.lat);
		}*/

    map.addControls([panel,nav,new OpenLayers.Control.MousePosition()]);
    map.zoomTo(map_confs.zoom);
    if( map_confs.show_default_buttons ){
        new function (){
            var hover_control_classes = ["maxItemInactive","minItemInactive","filtersItemInactive","setsItemInactive","tagsItemInactive"];
            for(var i=0,len = hover_control_classes.length;i<len;i++)
                buthoverEffect(hover_control_classes[i]);

        }
    }

    map.setCenter(new OpenLayers.LonLat(map_confs.lon,map_confs.lat));
}


