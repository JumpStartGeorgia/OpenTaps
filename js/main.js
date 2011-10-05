
function init()
{
    map_init();
    chart_init();
}

String.prototype.reverse = function()
{
    splitext = this.split("");
    revertext = splitext.reverse();
    reversed = revertext.join("");
    return reversed;
}


var img_src  = "";
var img_style = "";
var click_done = false;

function getArray(){
	for (var i=1;i<projects.length;i++)
			if( projects[i][0] == marker_id  ){
				console.log(projects[i]);
			}
		
}


function show_data(type,i)
{
var content = [];
	if( type === 'project' ){
					 content.push("<center><p><font style='color:#FFF;font-family:arial;font-size:12pt;'>"+projects[i][3]+"</font></p>");
                content.push("<hr style='height:1px;width:180px;border:0px;border-top:1px dotted #FFF;'/>");
                content.push("<p><font style='color:#000;font-size:9pt;'>Grantee:</font>&nbsp;<font style='font-size:10pt;color:#FFF;'>"+projects[i][4]+"</font></p>");
                content.push("<p><font style='color:#000;font-size:9pt;'>Budget:</font>&nbsp;<font style='font-size:10pt;color:#FFF;'>"+projects[i][5]+"</font></p>");
                content.push("<p><font style='color:#000;font-size:9pt;'>City/Town:</font>&nbsp;<font style='font-size:10pt;color:#FFF;'>"+projects[i][6]+"</font></p>");
                content.push("<p><font style='font-size:10pt;color:#FFF;'>"+months[projects[i][1].getMonth()]+"."+projects[i][1].getDate()+"."+projects[i][1].getFullYear()+" - "+months[projects[i][2].getMonth()]+"."+projects[i][2].getDate()+"."+projects[i][2].getFullYear()+"</font></p>");
                content.push("</center>");
             }
             else{
	             
            	 content.push("<center style='margin-top:30px;margin-left:10px;'><p><font style='color:#FFF;font-family:arial;font-size:17pt;'>"+news[i][3]+"</font></p>");
                content.push("<hr style='height:1px;width:100px;border:0px;border-top:1px dotted #FFF;'/>");
                content.push("<p><font style='font-size:10pt;color:#FFF;'><a href='"+news[i][0]+"'>Naxe</a></font></p>");
                content.push("<p><font style='font-size:10pt;color:#FFF;'>"+months[news[i][4].getMonth()]+"."+news[i][4].getDate()+"."+news[i][4].getFullYear()+"</font></p>");
                content.push("</center>");
            	 
				 }
      return content.join('');
}

var click_done = false;
function marker_animate(id, lon, lat, type, i)
{
	if (click_done == false)
   	{
            click_done = true;

            if( type === 'news'){
            	var width = 250;
            	var height = 240;
            	var top = -105;
            	var left = -110;
				}else{
					var width = 250;
					var height = 240;
					var top = -105;
					var left = -110;
				}
	    
	    img = $('#' + id).css('cursor', 'pointer'),
	    img_src = img.attr('src'),
	    img_style = img.attr('style');
            img.attr('src', 'images/marker.png');
            img.css('z-index', '99999').animate({
                'cursor': 'normal',
                'top': top+'px',
                'left': left+'px',
                'width': width+'px',
                'height': height+'px'
            }, 'normal', function()
            {
               

                //console.log(  show_data(i) );
              if( type === 'news' ){
              		var size = {
							'width': 190,
							'height':100           			
              		};
				  }else{
						var size = {
                    'width': 200,
                    'height':120
                	};
				  }
                make_popup({
                    'lon': lon,
                    'lat': lat
                },size,  show_data(type,i+1));	       
                
                $(this).parent().parent().parent().children('div:last').css({
                		'top' : '-=60px',
                		'left' : '-=100px'
                	});
            });
	}
}	
function marker_animate_back(id){
	//if(document.getElementById(id).style.width == "200px")
	//if( document.getElementById(id).style.height == "200px")
	if(click_done == true){
		$("#"+id).animate({"top":"0px","left":"0px","width":"20px","height":"20px"},570,function(){
			$(this).attr('style',img_style);
			$(this).attr('src',img_src);
			click_done = false;		
		});
	}
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

function check_sidebar(element)
{
	if (element.find('input').attr('checked'))
	{
		//alert('ari checked mara qreba');
		element.parent().find('.data_unique_container').val('not_checked');
	}
	else
	{
		//alert('ari unchecked mara inishneba');
		element.parent().find('.data_unique_container').val('checked');
	}
}

$(function()
{
    $('.admin').hover(function(){
        $(this).children('div').slideToggle(100);
    });


    /*$('#ptags').change(function(){
        var selected_tags = [];
        $(this).find('option:selected').each(function(){
            selected_tags.push($(this).text());
        });

	$('#tag_box').val(selected_tags.join(', '));
    });*/



	$('.expand_title').click(function(){
		var element = $(this),
		expandable = element.parent().find('.expandable');
		abbr = element.parent().find('abbr');

		$('.expandable:visible').parent().find('abbr').hide();
		$('.expandable:visible').slideUp().parent().find('span.racxa').html('►');

		if (expandable.is(':visible'))
		{
			expandable.stop().slideUp('normal');
			element.find('span.racxa').text('►');
			abbr.hide();
		}
		else
		{
			expandable.slideDown('normal');
			element.find('span.racxa').text('▼');
			abbr.show();
		}

	});




// Map Overlay
$(function(){

    var disabling = false;
    $('#map-overlay')
    .css('opacity', 0.5)
    .hover(function(){
        $(this).stop().animate({
            opacity: 0.33
        }, 'slow');
    }, function(){
        if (disabling)
            return false;
        $(this).stop().animate({
            opacity: 0.5
        }, 'slow');
    })
    .click(function(){
        disabling = true;
        $(this).fadeOut('slow', function(){
            deven.setOpacity(1);
            $(this).remove();
        });
    });

});


	$('.slidenews').slideQuery({
	    slides: '.slide', // Selector for slide elements, must be a children of '.my-slideshow' class in this case.
	    type: 'fade', // Animation type. 'fade', 'slide' and 'none' are supported.
	    speed: 'normal', // Animation speed. 'normal', 'fast', 'slow' or miliseconds, ignored if animation type is 'none'.
	    delay: 999*999*999, // Delay between switching slides in miliseconds.
	    direction: 'right', // Direction of the slideshow, 'right', 'left' and 'random' are supported.
	    switcher: true, // Display slide switcher
	    switcherTextLeft: '<span class="slide_switcher_left"><</span>',
	    switcherStyleLeft: {
		position: 'absolute',
		bottom: 1,
		left: 0
	    }, // CSS style for left slide switcher container. Note, slideshow container has a relative property.
	    switcherTextRight: '<span class="slide_switcher_right">></span>',
	    switcherStyleRight: {
		position: 'absolute',
		bottom: 0,
		right: 0
	    }, // CSS style for right slide switcher container. Note, slideshow container has a relative property.
	    stopOnOver: true, // Stop slideshow on mouse over and continue on mouse out.
	    mouseOutInstantStart: false, // Continue sliding after mouse out instantly, without delay. Note, stopOnOver option should be set to true.
	    speedIn: null, // Slide show speed, if not set 'speed' option value is used. Ignored if animation type is 'none'.
	    speedOut: null, // Slide hide speed, if not set 'speed' option value is used. Ignored if animation type is 'none'.
	    startIndex: 'first' // Starting index/point of the slide. Can be 'first', 'last', 'random' or a index number.
	});





	var data_field_index = 0;
	$('#add_data_field').click(function(){
		var container = $('#data_fields_container'),
		bg = (data_field_index % 2 == 1) ? "url(" + baseurl + "images/bg.jpg) repeat;" : 'white;',
		html = "<div class='group' style='display: none; background: " + bg + "'>" +
			"<label style='cursor: pointer'>" +
  	    			"Title: <br /><input name='data_key[]' type='text' />" +
  	    		"</label><br /><br />" +
  	    		"<label style='cursor: pointer'>" +
				"Sort: <br /><input name='data_sort[]' type='text' style='width: 40px' />" +
  	    		"</label>" +
  	    		"<input type='hidden' name='sidebar[]' value='not_checked' class='data_unique_container' />" +
  	    		"<label style='margin-left: 25px; cursor: pointer;' onmouseup='check_sidebar($(this))'>" +
  	    			"<input type='checkbox' value='checked' /> Sidebar" +
  	    		"</label><br /><br />" +
			"<label style='cursor: pointer'>" +
  	    			"Text: <br /><textarea name='data_value[]' cols='55' rows='5'></textarea>" +
	    		"</label>" +
	    		"<a style='color: red; cursor: pointer; font-size: 13px;'" +
	    		   "onclick='$(this).parent().slideUp(function(){ $(this).remove(); })'>" +
	    			" - Remove data" +
	    		"</a>" +
	    		"<br /><hr style='margin-left: -27px' />" +
	    		"</div>";
		container.append(html);
		container.find('.group:last-child').slideDown('normal');
		data_field_index ++;
	});



	var over_background_visible = false;
	$('.top_image').mouseenter(function(){
		if (!over_background_visible)
		{
			$(this).find('.over_background').slideUp();
			over_background_visible = true;
		}
	});
	$('.top_image').mouseleave(function(){
		if (over_background_visible)
		{
			$(this).find('.over_background').slideDown();
			over_background_visible = false;
		}
	});

	$('.right_title_one').hover(function(){
		$('#left_image_box').find('img').attr('src', $(this).find('.src_container').val());
	});



});

// Block Errors
$(function(){
    $(window).error(function(){
        return true;
    });
});
