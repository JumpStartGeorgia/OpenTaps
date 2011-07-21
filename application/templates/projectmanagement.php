<center>
<div>
<script type="text/javascript">
	function showhide(div){
		var hdiv = document.getElementById(div);
		if(hdiv.style.display == "none") hdiv.style.display = "block";	
		else hdiv.style.display = "none";
	}
</script>
<div>Projects</a></div>
<div style="border:1px solid #000;width:400px;">
	<div style="background-color:#CCC;cursor:default;" onclick="showhide('proj_form')">
		<font size="2pt">
			<?php if(isset($id)):?>Edit Project<?php else: ?>Add project<?php endif; ?>
		</font>
	</div>
	<div id="proj_form" style="overflow:hidden;<?php if(isset($id)):?> display:block; <?php else: ?> display:none; <?php endif;?>">
	<br />
		<form action="<?php if(isset($id)): ?> ../../ <?php endif; ?>" method="POST">
		<?php if(isset($id)): ?><input type="hidden" name="proj_id" value="<?php echo $id; ?>"/><?php endif; ?> 
		Project name:
		<input <?php if(isset($id)): ?> value="<?php echo $proj_name; ?>" <?php endif; ?> type="text" name="proj_name"/>
		<p align="top">
			Project description:
		</p>
		<textarea style="resize:none;" name="proj_desc" rows="4" cols="50"><?php if(isset($id)): echo $proj_desc; endif; ?></textarea>
		<br />
		<input type="submit" value="<?php if(isset($id)): ?> Edit <?php else: ?> Add <?php endif; ?>"/>
		</form>
		<br />
	</div>
</div>


<div style="border:0px solid #000;width:500px;height:auto;">

	<?php if(empty($projects)):?>
		<h2>No projects</h2>
	<?php else: ?>
	<table>
	<tr>
		<td>N.</td>
		<td>Name</td>
		<td>Description</td>
	</tr>
	<?php $idx = 1; ?>
	<?php foreach($projects as $project): ?>
		<tr>
			<td><?php echo $idx; ?></td>
			<td><?php echo $project['title']; ?></td>
			<td><?php echo $project['description'];?></td>
			<td><a href="<?php echo href("/projmanagement/{$project['id']}/edit") ?>">edit</a></td>
			<td><a href="<?php echo href("/projmanagement/{$project['id']}/delete") ?>">delete</a></td>
		</tr>
		
		<?php $idx++; ?>
	<?php endforeach;?>
	</table>
	<?php endif;?>
</div>
</div>
</center>

