<center>
<div>
<script type="text/javascript">
	function show_don_edit(id,don_name,don_desc){
		document.getElementById("add_don").innerHTML = "<font size='2pt'>Edit Donor<a style='margin-left:130px;' href=''>switch to add mode</a></font>";
		document.getElementById("don_form").getElementsByTagName("input")[1].value = "Edit";
		document.getElementById("don_form").style.display = "block";
		document.getElementsByName("don_name")[0].value = don_name;
		document.getElementsByTagName("textarea")[0].value = don_desc;
		var hid_inp = document.createElement("input");
		hid_inp.setAttribute("type","hidden");
		hid_inp.setAttribute("value",id);
		hid_inp.setAttribute("name","don_id");
		document.getElementById("don_form").getElementsByTagName("form")[0].insertBefore(hid_inp,document.getElementById("don_form").getElementsByTagName("form")[0].firstChild);
	}
</script>
<div>Donors</a></div>
<div style="border:1px solid #000;width:400px;">
	<div id="add_don" style="background-color:#CCC;cursor:default;"><font size="2pt">Add Donor</font></div>
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

<div style="border:0px solid #000;width:500px;height:auto;">

	<?php list_donors("admin"); ?>
	
</div>
</div>
</center>

<script type="text/javascript">
	document.getElementById("add_don").onclick = function(){
		if(document.getElementById("don_form").style.display == "none")
		document.getElementById("don_form").style.display = "block";
		else document.getElementById("don_form").style.display = "none";
	};
</script>
