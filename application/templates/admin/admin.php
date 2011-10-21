<div id="showtables">
    <table>
	<tr>
		<td>
			<h3><?php echo l('admin_menu_management') ?></h3>
			<ul>
				<li><a href="<?php echo href("admin/menu/new", TRUE) ?>"><?php echo l('admin_add_menu') ?></a></li>
				<li><a href="<?php echo href("admin/menu", TRUE) ?>"><?php echo l('admin_list_menu') ?></a></li>
			</ul>
		</td>
		<td>
			<h3><?php echo l('admin_news_management') ?></h3>
			<ul>
				<li><a href="<?php echo href("admin/news/new", TRUE) ?>"><?php echo l('admin_add_news') ?></a></li>
				<li><a href="<?php echo href("admin/news", TRUE) ?>"><?php echo l('admin_list_news') ?></a></li>
			</ul>
		</td>
		<td>
			<h3><?php echo l('admin_tags_management') ?></h3>
			<ul>
				<li><a href="<?php echo href("admin/tags/new", TRUE) ?>"><?php echo l('admin_add_tag') ?></a></li>
				<li><a href="<?php echo href("admin/tags", TRUE) ?>"><?php echo l('admin_list_tags') ?></a></li>
			</ul>
		</td>
	</tr>
	<tr>
		<td>
			<h3><?php echo l('admin_user_management') ?></h3>
			<ul>
				<li><a href="<?php echo href("admin/users/new", TRUE) ?>"><?php echo l('admin_add_user') ?></a></li>
				<li><a href="<?php echo href("admin/users", TRUE) ?>"><?php echo l('admin_list_users') ?></a></li>
			</ul>
		</td>
		<td>
			<h3><?php echo l('admin_places_management')?></h3>
			<ul>
				<li><a href="<?php echo href("admin/places/new", TRUE) ?>"><?php echo l('admin_add_place') ?></a></li>
				<li><a href="<?php echo href("admin/places", TRUE) ?>"><?php echo l('admin_list_places') ?></a></li>
			</ul>
		</td>
		<td>
			<h3><?php echo l('admin_projects_management') ?></h3>
			<ul>
				<li><a href="<?php echo href("admin/projects/new", TRUE) ?>"><?php echo l('admin_add_project') ?></a></li>
				<li><a href="<?php echo href("admin/projects", TRUE) ?>"><?php echo l('admin_list_projects') ?></a></li>
			</ul>
		</td>
	</tr>
	<tr>
		<td>
			<h3><?php echo l('admin_organizations_management') ?></h3>
			<ul>
				<li><a href="<?php echo href("admin/organizations/new", TRUE) ?>"><?php echo l('admin_add_organization') ?></a></li>
				<li><a href="<?php echo href("admin/organizations", TRUE) ?>"><?php  echo l('admin_list_organizations') ?></a></li>
			</ul>
		</td>
		<td>
			<h3><?php  echo l('admin_regions_management') ?></h3>
			<ul>				
				<li><a href="<?php echo href("admin/regions/new", TRUE) ?>"><?php echo l('admin_add_region') ?></a></li>
				<li><a href="<?php echo href("admin/regions", TRUE) ?>"><?php echo l('admin_list_regions') ?></a></li>
			</ul>
		</td>
		<td>
			<h3><?php echo l('admin_georgia_profile') ?></h3>
			<ul>
				<li><a href="<?php echo href("admin/georgia_profile", TRUE) ?>"><?php echo l('admin_manage_georgia_profile') ?></a></li>
			</ul>
		</td>
	</tr>
    </table>
</div>
