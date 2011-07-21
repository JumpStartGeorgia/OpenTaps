<center>
<div>
<script type="text/javascript">
	function show_don_edit(id,don_name,don_desc){
		document.getElementById('don_form').style.display = "none";
		document.getElementById('editdon_form').getElementsByTagName('input')[0].value = id;
		document.getElementById('editdon_form').getElementsByTagName('input')[1].value = don_name;
		document.getElementById('editdon_form').getElementsByTagName('textarea')[0].value = don_desc;
		document.getElementById('edit_don').style.display = "block";
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
<div>Donors</a></div>
<div id="adddon_tot" style="border:1px solid #000;width:400px;">
	<div id="add_don" style="background-color:#CCC;cursor:default;" onclick="showhide('don_form','editdon_form')"><font size="2pt">Add Donor</font></div>
	<div id="don_form" style="overflow:hidden;display:none;">
	<br />
		<form action="" method="POST">
		Donor name:<input type="text" name="don_name"/>
		<p align="top">Donor description:</p><textarea style="resize:none;" name="don_desc" rows="4" cols="50"></textarea><br />
		<input type="submit" value="Add"/>
		</form>
		<br />
	</div>
</div>

<div id="edit_don" style="border:1px solid #000;width:400px;display:none;">
	<div style="background-color:#CCC;cursor:default;" onclick="showhide('editdon_form','don_form')"><font size="2pt">Edit Donor</font></div>
	<div id="editdon_form" style="overflow:hidden;">
	<br />
		<form action="" method="POST">
		<input type="hidden" name="don_id"/>
		Donor name:<input type="text" name="don_name"/>
		<p align="top">Donor description:</p><textarea style="resize:none;" name="don_desc" rows="4" cols="50"></textarea><br />
		<input type="submit" value="Edit"/>
		</form>
		<br />
	</div>
</div>

<div style="border:0px solid #000;width:500px;height:auto;">

	<?php if(empty($donors)):?>
		<h2>No donors</h2>
	<?php else: ?>
	<table>
	<tr>
		<td>N.</td>
		<td>Name</td>
		<td>Description</td>
	</tr>
	<?php $idx = 1; ?>
	<?php foreach($donors as $donor): ?>
		<tr>
			<td><?php echo $idx; ?></td>
			<td><?php echo $donor['don_name']; ?></td>
			<td><?php echo $donor['don_description'];?></td>
			<td><a href="javascript:show_don_edit('<?php echo $donor['id']; ?>',
						   '<?php echo 	$donor['don_name']; ?>',
						   '<?php echo $donor['don_description']; ?>'
						   )">edit</a></td>
			<td><a href="<?php echo href("/donmanagement/{$donor['id']}/delete"); ?>">delete</a></td>
		</tr>
		
		<?php $idx++; ?>
	<?php endforeach;?>
	</table>
	<?php endif;?>
</div>
</div>
</center>

