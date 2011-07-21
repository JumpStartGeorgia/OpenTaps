<center>
<div>
<script type="text/javascript">
	function show_org_edit(id,org_name,org_desc){
		document.getElementById('org_form').style.display = "none";
		document.getElementById('editorg_form').getElementsByTagName('input')[0].value = id;
		document.getElementById('editorg_form').getElementsByTagName('input')[1].value = org_name;
		document.getElementById('editorg_form').getElementsByTagName('textarea')[0].value = org_desc;
		document.getElementById('edit_org').style.display = "block";
	}
	function showhide(div,div1){
			var hdiv = document.getElementById(div);
			var hdiv1 = document.getElementById(div1);
		if(hdiv.style.display == "none"){
		hdiv.style.display = "block";	
		hdiv1.style.display = "none";
		}
		else{
		hdiv.style.display = "none";
		//hdiv1.style.display = "block";
		}
	}
</script>
<div>Organizations</a></div>
<div id="addorg_tot" style="border:1px solid #000;width:400px;">
	<div id="add_org" style="background-color:#CCC;cursor:default;" onclick="showhide('org_form','editorg_form')"><font size="2pt">Add Organization</font></div>
	<div id="org_form" style="overflow:hidden;display:none;">
	<br />
		<form action="" method="POST">
		Organization name:<input type="text" name="org_name"/>
		<p align="top">Organization description:</p><textarea style="resize:none;" name="org_desc" rows="4" cols="50"></textarea><br />
		<input type="submit" value="Add"/>
		</form>
		<br />
	</div>
</div>

<div id="edit_org" style="border:1px solid #000;width:400px;display:none;">
	<div style="background-color:#CCC;cursor:default;" onclick="showhide('editorg_form','org_form')"><font size="2pt">Edit Organization</font></div>
	<div id="editorg_form" style="overflow:hidden;">
	<br />
		<form action="" method="POST">
		<input type="hidden" name="org_id"/>
		Organization name:<input type="text" name="org_name"/>
		<p align="top">Organization description:</p><textarea style="resize:none;" name="org_desc" rows="4" cols="50"></textarea><br />
		<input type="submit" value="Edit"/>
		</form>
		<br />
	</div>
</div>

<div style="border:0px solid #000;width:500px;height:auto;">

	<?php if(empty($organizations)):?>
		<h2>No organiations</h2>
	<?php else: ?>
	<table>
	<tr>
		<td>N.</td>
		<td>Name</td>
		<td>Description</td>
	</tr>
	<?php $idx = 1; ?>
	<?php foreach($organizations as $organization): ?>
		<tr>
			<td><?php echo $idx; ?></td>
			<td><?php echo $organization['org_name']; ?></td>
			<td><?php echo $organization['org_description'];?></td>
			<td><a href="javascript:show_org_edit('<?php echo $organization['id']; ?>',
						   '<?php echo 	$organization['org_name']; ?>',
						   '<?php echo $organization['org_description']; ?>'
						   )">edit</a></td>
			<td><a href="<?php echo href("/orgmanagement/{$organization['id']}/delete"); ?>">delete</a></td>
		</tr>
		
		<?php $idx++; ?>
	<?php endforeach;?>
	</table>
	<?php endif;?>
</div>
</div>
</center>

