$(function(){


	$('.admin_edit_button').click(function(){
		var input_container = $(this).parent().parent().find('div');
		/*console.log(input_container.html());*/
		if ($(this).attr('id') == 'basic_info')
		{
			var uri = 'admin/project-ajax/' + $('#project_unique').val() + '/basic_info';
		}
		else if ($(this).attr('id') == 'project_data')
		{
			var uri = 'admin/project-ajax/' + input_container.attr('data_unique') + '/project_data';
		}
		input_container.css('height', 'auto');
		input_container.load(baseurl + uri, { 'test': '' });
	});

	$('#admin_save_button').live('click', function(){
		var uri = 'admin/project-ajax-save/',
		message_container = $('#message_container');
		if ($(this).attr('datatype') == "basic_info")
		{
			uri += $('#project_unique').val() + '/basic_info';
			message_container.load(baseurl + uri, {
				':city': $('#p_city').val(),
				':place_unique': $('#p_place_unique').val(),
				':grantee': $('#p_grantee').val(),
				':sector': $('#p_sector').val(),
				':budget': $('#p_budget').val(),
				':start_at': $('#p_start_at').val(),
				':end_at': $('#p_end_at').val(),
				':type': $('#p_type').val()
			});
		}
		else if ($(this).attr('datatype') == "project_data")
		{
			uri += $(this).attr('data_unique') + '/project_data';
			message_container.load(baseurl + uri, {
				':key': $('#p_key').val(),
				':value': $('#p_value').val()
			});
		}
		return false;
	});


});
