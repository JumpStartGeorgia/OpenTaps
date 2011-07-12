function init(){
	map_init();
	chart_init();
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
