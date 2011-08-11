$(function()
{
    var submenu = $('#submenu'), clicked = false;

    var dmenu = $('#menu .dropdownmenu');
    dmenu.click(function(){
    	submenu.children().slideUp("fast");
    	$(this).parent().children().css("border", "0");
    	var d = submenu.find("#sub_" + $(this).attr('id'));
	d.slideToggle("fast");
	d.parent().css("margin-top", "-1px");
	$(this).css({"border-left" : "1px dotted #a6a6a6", "border-right" : "1px dotted #a6a6a6", 'border-bottom' : '1px solid #fff'});
	clicked = true;
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
