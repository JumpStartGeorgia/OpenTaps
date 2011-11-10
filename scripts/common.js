function def(item)
{
    return typeof(item) !== 'undefined';
}

String.prototype.reverse = function()
{
    splitext = this.split("");
    revertext = splitext.reverse();
    reversed = revertext.join("");
    return reversed;
}

var img_src = null;
var img_style = null;
var click_done = false;

function getArray(){
    for (var i = 1; i < projects.length; i ++)
    {
        if( projects[i][0] == marker_id  )
        {
    /*console.log(projects[i]);*/
    }
    }
}


function show_data(type,i)
{
    var content = [];
    if( type === 'project' )
    {
        content.push("<center><p><font style='color:#FFF;font-family:arial;font-size:12pt;'>"+projects[i][3]+"</font></p>");
        content.push("<hr style='height:1px;width:180px;border:0px;border-top:1px dotted #FFF;'/>");
        content.push("<p><font style='color:#000;font-size:9pt;'>Grantee:</font>&nbsp;<font style='font-size:10pt;color:#FFF;'>"+projects[i][4]+"</font></p>");
        content.push("<p><font style='color:#000;font-size:9pt;'>Budget:</font>&nbsp;<font style='font-size:10pt;color:#FFF;'>"+projects[i][5]+"</font></p>");
        content.push("<p><font style='color:#000;font-size:9pt;'>City/Town:</font>&nbsp;<font style='font-size:10pt;color:#FFF;'>"+projects[i][6]+"</font></p>");
        content.push("<p><font style='font-size:10pt;color:#FFF;'>"+months[projects[i][1].getMonth()]+"."+projects[i][1].getDate()+"."+projects[i][1].getFullYear()+" - "+months[projects[i][2].getMonth()]+"."+projects[i][2].getDate()+"."+projects[i][2].getFullYear()+"</font></p>");
        content.push("</center>");
    }
    else
    {

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

        if( type === 'news')
        {
            var width = 250;
            var height = 240;
            var top = -105;
            var left = -110;
        }
        else
        {
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
        }, 'normal', function() {

            if( type === 'news' )
            {
                var size = {
                    'width': 190,
                    'height':100
                };
            }
            else
            {
                var size = {
                    'width': 200,
                    'height':120
                };
            }
            make_popup({
                'lon': lon,
                'lat': lat
            }, size, show_data(type, i + 1));
            $(this).parent().parent().parent().children('div:last').css({
                'top' : '-=60px',
                'left' : '-=100px'
            });
        });
    }
}
function marker_animate_back(id)
{
    //if(document.getElementById(id).style.width == "200px")
    //if( document.getElementById(id).style.height == "200px")
    if(click_done == true)
    {
        $("#"+id).animate({
            "top":"0px",
            "left":"0px",
            "width":"20px",
            "height":"20px"
        }, 570, function(){
            $(this).attr('style',img_style);
            $(this).attr('src',img_src);
            click_done = false;
        });
    }
}


function hideOthers(div_hide,div_show)
{
    var div_all = div_hide.concat(div_show);
    for(var i = 0; i < div_all.length; i++)
        document.getElementById(div_all[i]).style.display = (i < div_hide.length) ? 'none' : 'block';
}

function showedit(id,lon,lat)
{

    if(document.getElementById(id).style.height == "60px"){
        $("#"+id).animate({
            "height":"+=170"
        },1000);
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
    }
    else
    {
        $("#"+id).animate({
            "height":"60px"
        },1000);
        document.getElementById(id).removeChild(document.getElementById(parseInt(id)+453475345));
    }

}

function check_sidebar(element)
{
    if (element.find('input').attr('checked'))
    {
        element.parent().find('.data_unique_container').val('not_checked');
    }
    else
    {
        element.parent().find('.data_unique_container').val('checked');
    }
}

$(function()
{
    $('.admin').hover(function(){
        $(this).children('div').slideToggle(100);
    });

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
        /*	enable chosenJS	
        $('select').addClass('chosen-select');
        $(".chosen-select").chosen();
        /*	..
$(function(){
    $("textarea").htmlarea();
});*/
        wysiwyg_init();
        container.find('.group:last-child').slideDown('slow');
        data_field_index ++;
    });

    var gp_data_field_index = 0;
    $('#gp_add_data_field').click(function(){
        var container = $('#data_fields_container'),
        bg = (gp_data_field_index % 2 == 1) ? "url(" + baseurl + "images/bg.jpg) repeat;" : 'white;',
        html = "<div class='group' style='display: none; background: " + bg + "; padding: 13px; border-bottom: 2px solid #ccc;'>" +
        "<label style='cursor: pointer'>" +
        "	Title: <br />" + "<input name='data_key[]' type='text' />" +
        "</label><br /><br />" +
        "<label style='cursor: pointer'>" + "Value: <br />" +
        "	<input name='data_value[]' type='text' />" +
        "</label><br /><br />" +
        "<label style=\"cursor: pointer\" onmouseup=\"$(this).parent().parent().find('.hidden_radio').val('no'); $(this).find('.hidden_radio').val('yes');\">" +
        "	<input name='main' type='radio' /> Main" +
        "	<input type=\"hidden\" class='hidden_radio' name=\"data_main[]\" />" +
        "</label><br /><br />" +
        "<a style='color: red; cursor: pointer; font-size: 13px;'" +
        "   onclick='$(this).parent().slideUp(function(){ $(this).remove(); })'>" +
        "	- Remove data" +
        "</a><br /><br />" +
        "</div>";
        container.append(html);
        container.find('.group:last-child').slideDown('normal');
        gp_data_field_index ++;
    });



    var over_background_visible = false;
    $('.top_image').mouseenter(function(){
        if (!over_background_visible)
        {
            $(this).find('.over_background').stop(true, true).slideUp();
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



    $('select').not('.chosen_deselector').addClass('chosen-select');
    $(".chosen-select").chosen();



    $('#add_budget_field').click(function(){
        var container = $('#budget_fields_container'),
        html = '<div class="budget-container group" style="display: none;">' +
        '	<div style="width: 100%; height: 30px;">' +
        '	    <div style="margin-top: 1px; float: left">Organization</div>' +
        '	    <div style="float: right">' +
        '		<select class="chosen-select" name="p_budget_org[]" style="width: 160px;">';

        for (i = 0, num = organization_names.length; i < num; i ++)
        {
            html += '<option value="' + organization_uniques[i] + '">' + organization_names[i] + '</option>';
        }

        html += '		</select>' +
        '	    </div>' +
        '	</div>' +
        '	<div style="width: 100%; height: 30px;">' +
        '	    <div style="margin-top: 1px; float:left;">Budget</div>' +
        '	    <div style="float:right;"><input name="p_budget[]" type="text" /></div>' +
        '	</div>' +
        '	<div style="width: 100%; height: 25px; display: none;">' +
        '	    <div style="margin-top: 1px; float:left;">Currency</div>' +
        '	    <div style="float:right;">' +
        '		<select class="chosen-select" name="p_budget_currency[]" style="width: 160px;">';

        for (i = 0, num = currency_list.length; i < num; i ++)
        {
            var s = (currency_list[i] == 'gel') ? 'selected="selected"' : '';
            html += '<option ' + s + ' value="' + currency_list[i] + '">' + currency_list[i] + '</option>';
        }

        html += '		</select>' +
        '	    </div>' +
        '	</div>' +
        '	<a onclick="$(this).parent().slideUp(function(){$(this).remove();})"' +
        '	   class="region_link" style="color: red; font-size: 12px;">' +
        '	    -Remove budget' +
        '	</a>' +
        '</div>';
        container.append(html);
        $(".chosen-select").chosen();
        container.find('.group:last-child').slideDown('normal');
    });


});

// Map Overlay
$(function(){

    var disabling = false;

    $('#map-overlay').css('opacity', .65).hover(function()
    {
        $(this).stop().animate({
            opacity: .35
        }, 'slow');
    }, function()
    {
        if (disabling)
            return false;
        $(this).stop().animate({
            opacity: .65
        }, 'slow');
    }).click(function()
    {
        disabling = true;
        $(this).fadeOut('slow', function()
        {
            //deven.setOpacity(1);
            $(this).remove();
        });
    });

});

// News Slider
$(function()
{

    var options = {
        slides: '.slide',
        delay: 999 * 999 * 999,
        switcherTextLeft: '<span class="slide_switcher_left">&lt;</span>',
        switcherStyleLeft: {
            position: 'absolute',
            bottom: 1,
            left: 0
        },
        switcherTextRight: '<span class="slide_switcher_right">&gt;</span>',
        switcherStyleRight: {
            position: 'absolute',
            bottom: 0,
            right: 0
        }
    };

    $('.slidenews').slideQuery(options);

});

// Logo Animation
$(function(){
    $('#site-logo').hover(function(){
        $(this).stop().animate({
            opacity: 0.65
        });
    }, function(){
        $(this).stop().animate({
            opacity: 1
        });
    });
});

// Resize height for submenu items
$(function()
{

    /*
    var group = $('#sub_organizations_dropdown table td'),
    tallest = 0;
    group.each(function()
    {
        var current_height = $(this).height();
        if(current_height > tallest)
            tallest = current_height;
    });
    group.height(tallest);
    */

    });

// Focus on username field on login page
$(function()
{

    var field = $('#login-username');
    field.length && field.focus();

});


/* Bottom Toggles */
var i = 0, t;
function timedScroll()
{
    if (i > document.body.clientHeight)
        return;
    window.scrollTo(0, i);
    i += 18;
    t = setTimeout('timedScroll()', 10);
}
$(function()
{
    var timeout = 500,
    about_is_visible = false,
    contact_is_visible = false,
    about_button = $('#about_us_button'),
    contact_button = $('#contact_us_button'),
    about = $('#about-us')
    about_height = about.height(),
    contact = $('#contact-us'),
    contact_height = contact.height();


    about_button.click(function()
    {
        if (about_is_visible)
        {
            about.animate({
                height: 0
            }, function(){
                about.hide();
            });
            about_is_visible = false;
            $('#contact_us_toggle').attr('src', baseurl + 'images/contact-line.gif');
        }
        else
        {
            if (contact_is_visible)
            {
                contact.animate({
                    height: 0
                }, function(){
                    contact.hide();
                });
                contact_is_visible = false;
            }
            i = about.position().top;
            timedScroll();
            about.css('height', 0).show().animate({
                height: about_height
            });
            about_is_visible = true;
            $('#contact_us_toggle').attr('src', baseurl + 'images/contact-line-amoshlili.gif');
        }

        $('body').bind('mousewheel', function()
        {
            clearTimeout(t);
            $('body').unbind('mousewheel');
        });
    });

    contact_button.click(function()
    {
        if (contact_is_visible)
        {
            contact.animate({
                height: 0
            }, function(){
                contact.hide();
            });
            contact_is_visible = false;
            $('#contact_us_toggle').attr('src', baseurl + 'images/contact-line.gif');
        }
        else
        {
            if (about_is_visible)
            {
                about.animate({
                    height: 0
                }, function(){
                    about.hide();
                });
                about_is_visible = false;
            }
            i = contact.position().top;
            timedScroll();
            contact.css('height', 0).show().animate({
                height: contact_height
            });
            contact_is_visible = true;
            $('#contact_us_toggle').attr('src', baseurl + 'images/contact-line-amoshlili.gif');
        }

        $('body').bind('mousewheel', function()
        {
            clearTimeout(t);
            $('body').unbind('mousewheel');
        });
    });

    /*
    bot = $('#bot-container');

    about_button.click(function(){
        if (about_is_visible)
        {
            about_is_visible = false;
            about.hide("slide", {
                direction: "down"
            }, timeout);
            $('#contact_us_toggle').attr('src', baseurl + 'images/contact-line.gif');
        }
        else
        {
            about_is_visible = true;
            if (contact_is_visible){
                contact.hide("slide", {
                    direction: "down"
                }, timeout);
                contact_is_visible = false;
            }
            about.show("slide", {
                direction: "down"
            }, timeout);
            $('#contact_us_toggle').attr('src', baseurl + 'images/contact-line-amoshlili.gif');
        }
    });

    contact_button.click(function(){
        if (contact_is_visible)
        {
            contact.hide("slide", {
                direction: "down"
            }, timeout);
            contact_is_visible = false;
            $('#contact_us_toggle').attr('src', baseurl + 'images/contact-line.gif');
        }
        else
        {
            contact_is_visible = true;
            if (about_is_visible)
            {
                about.hide("slide", {
                    direction: "down"
                }, timeout);
                about_is_visible = false;
            }
            contact.show("slide", {
                direction: "down"
            }, timeout);
            $('#contact_us_toggle').attr('src', baseurl + 'images/contact-line-amoshlili.gif');
        }
    });*/

    $('#contact-us-close-button').click(function(){
        contact_button.click();
    });
    $('#about-us-close-button').click(function(){
        about_button.click();
    });

    Array.prototype.max = function(){
        return Math.max.apply(null, this);
    }

    var maxh = 0;
    $('.about-us-inner-button').click(function(){
        var target = $(this).parent().find('.inner-text-box');
        $('.inner-text-box').each(function(){
            if ($(this).height() > maxh) maxh = $(this).height();
        });

        if (!target.is(":visible"))
        {
            i = target.position().top;
            setTimeout('timedScroll()', 100);
            if ($('.inner-text-box:visible').length == 0)
            {
                about_height += maxh;
            }
        }
        target.slideToggle(function()
        {
            if ($('.inner-text-box:visible').length == 0)
            {
                about_height -= maxh;
                about.animate({
                    height: about_height
                });
            }
        });
    });

});


function contact_us_input_focus(element, value)
{
    element.style.backgroundColor = "#fff";
    element.style.color = "#6d6d6d";
    if (element.value == value)
        element.value = "";
}
function contact_us_input_blur(element, value)
{
    element.style.backgroundColor = "rgba(12, 181, 246, .9)";
    element.style.color = "#fff";
    if (element.value = "" || element.value.length == 0)
        element.value = value;
}

/* Menus */
$(function()
{

    var submenu = $('#submenu');

    $('#menu .dropdownmenu').click(function(event)
    {
        event.preventDefault();

        var me = $(this),
        border = $('#override_border'),
        item = submenu.find('#sub_' + me.attr('id'));

        submenu.children().slideUp('normal');

        me.parent().children().css('border', '0');

        item.stop().slideToggle('fast');

        border.stop().show().css({
            'left' : me.position().left,
            'top' : me.position().top + me.height() + 1,
            'width' : me.width() + 1,
            'height' : 1
        });

        me.css({
            'border-left': '1px dotted #a6a6a6',
            'border-right': '1px dotted #a6a6a6',
            'border-bottom' : '1px solid #fff'
        });

    });

});

$(document).ready(function(){
	wysiwyg_init();
});

/* Initialize TinyMCE
function wysiwyg()
{
    if (typeof(tinyMCE) === 'undefined')
        return false;

    var options = {
        mode : 'textareas',
        theme : 'advanced',
        editor_deselector : 'mceNoEditor',
        plugins : 'autolink,lists,pagebreak,style,layer,table,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave',
        theme_advanced_buttons1 : 'bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect,|,visualchars,nonbreaking,restoredraft',
        theme_advanced_buttons2 : 'cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor',
        theme_advanced_buttons3 : 'tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen',
        theme_advanced_toolbar_location : 'top',
        theme_advanced_toolbar_align : 'left',
        theme_advanced_statusbar_location : 'bottom',
        theme_advanced_resizing : true,
        template_external_list_url : 'lists/template_list.js',
        external_link_list_url : 'lists/link_list.js',
        external_image_list_url : 'lists/image_list.js',
        media_external_list_url : 'lists/media_list.js'
    };

    tinyMCE.init(options);


}
$(wysiwyg);*/

// Keyboard shortcut to admin panel
$(function()
{

    $(document).keypress(function(event)
    {
        if (event.ctrlKey && event.shiftKey && (event.keyCode ? event.keyCode : event.which) == 13)
            window.location = baseurl + 'admin/';
    });

});

// Initialize Cufon
if (typeof(Cufon) !== 'undefined')
{
    Cufon.replace('.menu-item > div').now();
    Cufon.replace('.font').now();
//    Cufon.now();
}

// Container minimum height
$(function()
{
    var container = $('.content'),
    minimum = 400;
    (container.height() < minimum) && container.height(minimum);
});


// Block Errors
$(function()
{

    $(window).error(function(event)
    {
        event.preventDefault();
        return true;
    });

});

if($('#logo_img').length)
    $('#logo_img').css('height', $('#project_details').css('height'));

// Watter Supply Request/Response
$(function()
{

    var regions = $('#ws_regions'),
    districts = $('#ws_districts');

    regions.change(function()
    {
        var request_url = baseurl + 'water_supply/districts/' + $(this).val() + '?lang=' + lang;
        $.getJSON(request_url, function(response)
        {
            if ($.isEmptyObject(response))
                return;
            districts.html('<option></option>');
            $.each(response, function()
            {
                var option = '<option id="' + $(this).attr('id') + '">' + $(this).attr('name') + '</option>';
                districts.append(option);
            });
            districts.trigger('liszt:updated');
        });
    });

    districts.change(function()
    {
        var request_url = baseurl + 'water_supply/' + $(this).children('option:selected').attr('id') + '?lang=' + lang;
        $.get(request_url, function(response)
        {
            console.log(response);
            response = response || '';
            $('#cont').html(data);
        });
    });

});

// Footer Map
$(function()
{
    var footer_map = new OpenLayers.Map('contact-us', {
        controls: [
        new OpenLayers.Control.Navigation(),
        new OpenLayers.Control.ArgParser(),
        new OpenLayers.Control.Attribution()
        ]
    }),
    footer_map_layer = new OpenLayers.Layer.OSM('JumpStart Tile-Set', 'http://tile.mapspot.ge/en/${z}/${x}/${y}.png', {
        isBaseLayer: true
    });
    footer_map.addLayer(footer_map_layer);
    footer_map.setCenter(
        new OpenLayers
        .LonLat(44.798735,41.697960)
        .transform(new OpenLayers.Projection('EPSG:4326'), footer_map.getProjectionObject())
        , 15);

});

