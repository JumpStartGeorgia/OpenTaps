var zoomNum = 1;
var map = null;
var markers = null;
var maximize = null;
var minimize = null;
var map_confs = {"boundsLeft": region_map_boundsLeft != false ? region_map_boundsLeft : 4260630.1231925,
		"boundsBottom": region_map_boundsBottom != false ? region_map_boundsBottom : 4999230.0089212,
		"boundsRight": region_map_boundsRight != false ? region_map_boundsRight : 5422472.9529191,
		"boundsTop": region_map_boundsTop != false ? region_map_boundsTop : 5427277.3672416,
		"zoom": region_map_zoom != false ? region_map_zoom : 7.5,
		"maxZoomOut": region_map_maxzoomout != false ? region_map_maxzoomout : 7,
		"lon":  region_map_longitude  != false ? region_map_longitude  : 4876406.8229462 ,
		"lat":  region_map_latitude != false ? region_map_latitude : 5183290.372998,
		"make_default_markers": region_make_def_markers == false ? region_make_def_markers : true,
		"show_default_buttons": region_show_def_buttons == false ? region_show_def_buttons : true
		};
var mapspot_confs = {"boundsLeft":38.704833984374,
		     "boundsBottom":-45.120849609376,
		     "boundsRight":49.141845703124,
		     "boundsTop":-41.275634765626,
		     "zoom":7,
		     "maxZoomOut": 7,
		     "lon":44.230957031249,
		     "lat":-43.483886718751};

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
    		}
    return url + path;
}

function setUpPanControls(){
	var max_button = function(){
		map.zoomTo(map.getZoom() + zoomNum);
	};
	var min_button = function(){
		stopZoomOut();
	};	
	var filter_button = function(){
		alert("filters");
	};
	var set_button = function(){
		alert("sets");
	};
	var tag_button = function(){
		alert("tags");
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
		
	return [keyboard_def,filters,sets,tags]; 
}

function stopZoomOut(){
	if(map.getZoom() != map_confs.maxZoomOut){
		map.zoomTo(map.getZoom() - zoomNum);
	}
}

function buthoverEffect(but_class){
		document.getElementsByClassName(but_class)[0].onmouseover = function(){
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
		}
}

function addMarkerLayer(layer_name)
{
     markers = new OpenLayers.Layer.Markers( layer_name );
    map.addLayer(markers);
}

function makeMarker(img_source,img_width,img_height,lon,lat)
{
	
    var size = new OpenLayers.Size(img_width,img_height);
    var offset = new OpenLayers.Pixel(-size.w / 2, -size.h / 2);
    var ico = new OpenLayers.Icon(img_source,size,offset);
    markers.addMarker(new OpenLayers.Marker(new OpenLayers.LonLat(lon,lat),ico));
}








function map_init()
{

	map = new OpenLayers.Map("map",{
		controls:[],
		restrictedExtent:new OpenLayers.Bounds(map_confs.boundsLeft,map_confs.boundsBottom,map_confs.boundsRight,map_confs.boundsTop)
	});
	
	 var deven = new OpenLayers.Layer.OSM("English", "http://a.tile.mapspot.ge/ndi_en/${z}/${x}/${y}.png", {numZoomLevels: 19}, {isBaseLayer:true});
	var devka = new OpenLayers.Layer.OSM("Georgian", "http://a.tile.mapspot.ge/ndi_ka/${z}/${x}/${y}.png", {numZoomLevels: 19}, {isBaseLayer:false});
	
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
	});panel.addControls(conts);
	map.addLayers([deven,devka]);//[mapspot_layer]);
	addMarkerLayer("Marker Layer");
	
	if(	map_confs.make_default_markers	  ){
		for(var i=0;i<places.length;i++){
			makeMarker("http://localhost/OpenTaps/images/marker.png",20,20,places[i][1],places[i][2]);
			}
		}
		else{
			makeMarker("http://localhost/OpenTaps/images/marker.png",20,20,map_confs.lon,map_confs.lat);
		}
			
	map.addControls([panel,nav]);//,new OpenLayers.Control.MousePosition()]);
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
