<?
  echo isset($alert) ? "<i>".$alert."</i><br />" : "";

  $menu = Storage::instance()->menu;

  echo "
	<div class=\"admin\">
	    <p>Menu</p>
	    <div class='admin_show'>";
  for($i = 0, $c = count($menu); $i < $c; $i ++)
  {
    $link_add = URL . 'menu/' . 'add';
    $link_edit = URL . 'menu/' . $menu[$i]['id'] . '/edit';
    $link_del = URL . 'menu/' . $menu[$i]['id'] . '/delete';
    echo "
		<div class='name'>" . strtoupper($menu[$i]['name']) . "</div>
		<div class='link'>
		    <a href=\" " . $link_edit . " \">Edit</a> | 
		    <a href=\" " . $link_del . " \">Delete</a>
		</div><br/><hr />
	 ";
  }
    echo "
  	        <center>
  	          <div class='add'><a href=\" " . $link_add . " \">Add Menu</a></div>
  	        </center>
	    </div>
	</div><br />
	<div class=\"admin\">
	    <a href=\" " . URL . " \">News</a>
	    <ul style=\" display:none; \">
	        <li>Add Menu</li>
	    </ul>
	</div><br />
  ";
