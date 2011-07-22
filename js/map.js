var zoomNum = 1;
var maxZoomOut = 7;
var map = null;
var map_confs = {"boundsLeft":4260630.1231925,
		"boundsBottom":4999230.0089212,
		"boundsRight":5422472.9529191,
		"boundsTop":5427277.3672416,
		"zoom":7.5,
		"lon":4876406.8229462,
		"lat":5183290.372998};
var mapspot_confs = {"boundsLeft":38.704833984374,
		     "boundsBottom":-45.120849609376,
		     "boundsRight":49.141845703124,
		     "boundsTop":-41.275634765626,
		     "zoom":7,
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
	var maximize = new OpenLayers.Control.Button({
		displayClass:"max",
		trigger:max_button
	});
	var minimize = new OpenLayers.Control.Button({
		displayClass:"min",
		trigger:min_button
	});
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
	return [keyboard_def,maximize,minimize,filters,sets,tags]; 
}

function stopZoomOut(){
	if(map.getZoom() != maxZoomOut){
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


function makeMarker(){
//	console.log(places);
    var markers = new OpenLayers.Layer.Markers( "OpenTaps::Markers" );
    map.addLayer(markers);
    for(var i=0;i<places.length;i++){
    var size = new OpenLayers.Size(20,20);
    var offset = new OpenLayers.Pixel(-size.w / 2, -size.h / 2);
    var ico = new OpenLayers.Icon("http://localhost/OpenTaps/images/marker.png",size,offset)
    	markers.addMarker(new OpenLayers.Marker(new OpenLayers.LonLat(places[i][1],places[i][2]),ico));
    }
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
	makeMarker();
	map.addControls([panel,nav,new OpenLayers.Control.MousePosition()]);
	map.setCenter(new OpenLayers.LonLat(map_confs.lon,map_confs.lat));
	map.zoomTo(map_confs.zoom);
	new function (){
		var hover_control_classes = ["maxItemInactive","minItemInactive","filtersItemInactive","setsItemInactive","tagsItemInactive"];
		for(var i=0,len = hover_control_classes.length;i<len;i++)
			buthoverEffect(hover_control_classes[i]);
	}
}
