$(function(){

    var cont = $('#bot-container'),
    about_clicked = false,
    about_link = $('#about_us_button');
    
    about_link.click(function()
    {
        var about_us = $('#about-us'),
        about_us_height = about_us.height();
        if (about_clicked)
        {
            cont.stop().animate({ height: about_us_height });	
            about_us.show().stop().animate({ bottom: about_us_height });
//            $('#about_us').stop().hide('slide', { direction: 'up' });
            about_clicked = false;
        }
        else
        {
//            $('#about_us').stop().show('slide', { direction: 'down' });
            about_clicked = true;
        }
    });

});

/*
$(function(){

	about_button = $('#about_us_button');
	contact_button = $('#contact_us_button');

	about = $('#about_us');
	contact = $('#contact_us');

	var timeout = 500, about_is_visible = false, contact_is_visible = false;

	about_button.click(function(){
		if (about_is_visible)
		{
			about_is_visible = false;
			about.parent().stop().animate({ height: -about.height() }, timeout);
			about.stop().hide("slide", { direction: "up" }, timeout);
		}
		else
		{
			about_is_visible = true;
			about.parent().stop().animate({ height: about.parent().height()+about.height() }, timeout);
			about.stop().show("slide", { direction: "down" }, timeout);
		}
	});

	contact_button.click(function(){
		if (contact_is_visible)
		{
			contact_is_visible = false;
			contact.parent().stop().animate({ height: -contact.height() }, timeout);
			contact.stop().hide("slide", { direction: "up" }, timeout);
		}
		else
		{
			contact_is_visible = true;
			about.parent().stop().animate({ height: $(this).height()+contact.height() }, timeout);
			contact.stop().show("slide", { direction: "down" }, timeout);
		}
	});

});
*/
