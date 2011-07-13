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

