function init(){
	map_init();
	chart_init();
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

<<<<<<< HEAD
$(function()
{
    var menu = $('#menu'),
    minimum_submenu_width = 144;
    menu.children('li').hover(function(){
        $(this).children('ul.submenu').slideToggle(100);
        $(this).find('li').width($(this).width());
    });

     $('.admin').hover(function(){
        $(this).children('div').slideToggle(100);
    });
});
=======
>>>>>>> 9015394620aca5f81778a8764afedc7dce890948
function hideOthers(div_hide,div_show){
			var div_all = div_hide.concat(div_show);
		for(var i=0;i<div_all.length;i++){
			if(i<div_hide.length)document.getElementById(div_all[i]).style.display = 'none';
			else document.getElementById(div_all[i]).style.display = 'block';
		}
}
<<<<<<< HEAD

=======
	
>>>>>>> 9015394620aca5f81778a8764afedc7dce890948
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
<<<<<<< HEAD
		edit_div.setAttribute("style","margin-top:5px;border:1px solid #000;width:300px;height:70px;");
=======
		edit_div.setAttribute("style","margin-top:5px;border:1px solid #000;width:250px;height:130px;");
>>>>>>> 9015394620aca5f81778a8764afedc7dce890948
		
		edit_div.appendChild(edit_form);
		edit_form.appendChild(edit_hidden);
		edit_form.appendChild(edit_label);
		edit_form.appendChild(edit_text);
		edit_form.appendChild(edit_br);
		edit_form.appendChild(edit_label1);
		edit_form.appendChild(edit_text1);
<<<<<<< HEAD
		edit_form.appendChild(edit_br);
=======
>>>>>>> 9015394620aca5f81778a8764afedc7dce890948
		edit_form.appendChild(edit_button);
		
		document.getElementById(id).appendChild(edit_div);
		}else{
			$("#"+id).animate({"height":"60px"},1000);
			document.getElementById(id).removeChild(document.getElementById(parseInt(id)+453475345));
		}
		
}
