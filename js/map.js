var zoomNum = 1;
var maxZoomOut = 7;
var map = null;

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

function map_init()
{
	map = new OpenLayers.Map("map",{
		controls:[],
		restrictedExtent:new OpenLayers.Bounds(38.704833984374,
											  -45.120849609376,
											  49.141845703124,
											  -41.275634765626)
	});
	
	var mapspot_layer = new OpenLayers.Layer.TMS(
			"MapSpot",
			"http://tile.mapspot.ge/new_en/",
			{type:"png",getURL:get_osm_url}
	);
	
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
	map.addLayers([mapspot_layer]);
	map.addControls([panel,nav]);
	map.setCenter(new OpenLayers.LonLat(44.230957031249,-43.483886718751));
	map.zoomTo(7.5);
}
