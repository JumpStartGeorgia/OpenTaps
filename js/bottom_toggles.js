$(function(){

	about_button = $('#about_us_button');
	contact_button = $('#contact_us_button');
	bot = $('#bot-container');
	about = $('#about-us');
	contact = $('#contact-us');

	var timeout = 500, about_is_visible = false, contact_is_visible = false;

	about_button.click(function(){
		if (about_is_visible)
		{
			about_is_visible = false;
			about.hide("slide", { direction: "down" }, timeout);
			$('#contact_us_toggle').attr('src', baseurl + 'images/contact-line.gif');
		}
		else
		{
			about_is_visible = true;
			if (contact_is_visible){
				contact.hide("slide", { direction: "down" }, timeout);
				contact_is_visible = false;
			}
			about.show("slide", { direction: "down" }, timeout);
			$('#contact_us_toggle').attr('src', baseurl + 'images/contact-line-amoshlili.gif');
		}
	});

	contact_button.click(function(){
		if (contact_is_visible)
		{
			contact.hide("slide", { direction: "down" }, timeout);
			contact_is_visible = false;
			$('#contact_us_toggle').attr('src', baseurl + 'images/contact-line.gif');
		}
		else
		{
			contact_is_visible = true;
			if (about_is_visible)
			{
				about.hide("slide", { direction: "down" }, timeout);
				about_is_visible = false;
			}
			contact.show("slide", { direction: "down" }, timeout);
			$('#contact_us_toggle').attr('src', baseurl + 'images/contact-line-amoshlili.gif');
		}
	});


	$('#contact-us-close-button').click(function(){
		contact_button.click();
	});

	$('#about-us-close-button').click(function(){
		about_button.click();
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
