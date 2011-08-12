$(function()
{
    var submenu = $('#submenu'), clicked = false;

    var dmenu = $('#menu .dropdownmenu');
    dmenu.click(function(){
    	var t = $(this);
    	var o = $('#override_border');
    	submenu.children().slideUp("normal");
    	t.parent().children().css("border", "0");
    	var d = submenu.find("#sub_" + t.attr('id'));
	d.stop().slideToggle("fast");
        o.stop().show().css({
        	"left" : t.position().left,
        	"top" : t.position().top + t.height() + 1,
        	"width" : t.width() + 1,
        	"height" : 1,
       	});
	t.css({"border-left" : "1px dotted #a6a6a6", "border-right" : "1px dotted #a6a6a6", 'border-bottom' : '1px solid #fff'});
	return false;
    });

});

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
