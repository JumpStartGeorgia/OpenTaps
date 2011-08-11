function init(){
	map_init();
	chart_init();
	configure_marker_animation();        
}



function configure_marker_animation(){
	for(var i=0,len=places_id.length;i<len;i++){
	   	var marker_img_handle = document.getElementById(places_id[i]).getElementsByTagName('img')[0];
	    		marker_img_handle.setAttribute("onmouseover","marker_animate(this.id)");
	    		marker_img_handle.setAttribute("onmouseout","marker_animate_back(this.id)");
	    		
	    	}
}

function show_menu_img(img,this_handle)
{
	document.getElementById('menu_img').src = img;
	//this_handle.style.background = "url('images/bg.jpg')";
}

$(function()
{
    var menu = $('#menu'),   minimum_submenu_width = 144;
    menu.children('li').hover(function(){
        $(this).children('ul.submenu').slideToggle(100);
        $(this).find('li').width($(this).width());
    });

     $('.admin').hover(function(){
        $(this).children('div').slideToggle(100);
    });
});


function marker_animate(id){
	//console.log(document.getElementById(id).style.width);
	if(document.getElementById(id).style.width == "20px")
	if(document.getElementById(id).style.height == "20px")
	$("#"+id).animate({"margin-top":"-15px","margin-left":"-15px","width":"200px","height":"200px"},570);	
}	
function marker_animate_back(id){
	//if(document.getElementById(id).style.width == "200px")
	//if( document.getElementById(id).style.height == "200px")
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
	

