function init(){
	map_init();
	chart_init();
	
	configure_marker();
	
        configure_marker_animation();
       	 
	    	
        
}

function configure_marker(){
	for(var i=0,len=places_id.length;i<len;i++){
		var marker_img_handle = document.getElementById(places_id[i]).getElementsByTagName('img')[0];
		marker_img_handle.src = "../images/marker.png";
		marker_img_handle.style.width = "20px";
		marker_img_handle.style.height = "20px";
	}
}

function configure_marker_animation(){
	for(var i=0,len=places_id.length;i<len;i++){
	   	var marker_img_handle = document.getElementById(places_id[i]).getElementsByTagName('img')[0];
	    		marker_img_handle.setAttribute("onmouseover","marker_animate(this.id)");
	    		marker_img_handle.setAttribute("onmouseout","marker_animate_back(this.id)");
	    		
	    	}
}

function marker_animate(id){
	//console.log(document.getElementById(id).style.width);
	if(document.getElementById(id).style.width == "20px")
	if(document.getElementById(id).style.height == "20px")
	$("#"+id).animate({"margin-top":"-15px","margin-left":"-15px","width":"200px","height":"200px"},570);	
}	
function marker_animate_back(id){
	if(document.getElementById(id).style.width == "200px")
	if( document.getElementById(id).style.height == "200px")
	$("#"+id).animate({"margin-top":"0px","margin-left":"0px","width":"20px","height":"20px"},570);
}
function menu_over(m)
{
  m.style.backgroundColor = "#5FCCF3";
  m.style.color = "#FFFFFF";
}

function menu_out(m)
{
  m.style.backgroundColor = "#FFFFFF";
  m.style.color = "#01AEF0";
}

function news_over(m,i)
{
  m.style.color = "#00AFF2";
  document.getElementById('news'+i).style.color = "#000000";
  document.getElementById('p_news'+i).style.color = "#000000";
  m.style.backgroundColor = "#FCFAFB";
}

function news_out(m,i)
{
  m.style.color = "#565656";
  document.getElementById('news'+i).style.color = "#565656";
  document.getElementById('p_news'+i).style.color = "#565656";
  m.style.backgroundColor = "#FFF";
}

function hideOthers(div_hide,div_show){
			var div_all = div_hide.concat(div_show);
		for(var i=0;i<div_all.length;i++){
			if(i<div_hide.length)document.getElementById(div_all[i]).style.display = 'none';
			else document.getElementById(div_all[i]).style.display = 'block';
		}
}
	
function showedit(id,lon,lat){
	
		if(document.getElementById(id).style.height == "60px"){
		$("#"+id).animate({"height":"+=170"},1000);
		var edit_div = document.createElement("div");
		var edit_form = document.createElement("form");
		var edit_text = document.createElement("input");
		var edit_text1 = document.createElement("input");
		var edit_button = document.createElement("input");
		var edit_label = document.createElement("label");
		var edit_label1 = document.createElement("label");
		var edit_br = document.createElement("br");
		var edit_hidden = document.createElement("input");
		
		edit_form.setAttribute("action","");
		edit_form.setAttribute("method","post");
		
		edit_hidden.setAttribute("type","hidden");
		edit_hidden.setAttribute("name","id_edit");
		edit_hidden.setAttribute("value",id);
		
		edit_label.innerHTML = "New Longitude:";
		edit_label1.innerHTML = "New Latitude:";
		
		edit_text.setAttribute("type","text");
		edit_text.setAttribute("name","lon_edit");
		edit_text.setAttribute("value",lon);
		
		edit_text1.setAttribute("type","text");
		edit_text1.setAttribute("name","lat_edit");
		edit_text1.setAttribute("value",lat);
		
		edit_button.setAttribute("type","submit");
		edit_button.setAttribute("value","Refactor");
		
		edit_div.setAttribute("id",parseInt(id)+453475345);
		edit_div.setAttribute("style","margin-top:5px;border:1px solid #000;width:250px;height:130px;");
		
		edit_div.appendChild(edit_form);
		edit_form.appendChild(edit_hidden);
		edit_form.appendChild(edit_label);
		edit_form.appendChild(edit_text);
		edit_form.appendChild(edit_br);
		edit_form.appendChild(edit_label1);
		edit_form.appendChild(edit_text1);
		edit_form.appendChild(edit_button);
		
		document.getElementById(id).appendChild(edit_div);
		}else{
			$("#"+id).animate({"height":"60px"},1000);
			document.getElementById(id).removeChild(document.getElementById(parseInt(id)+453475345));
		}
		
}
