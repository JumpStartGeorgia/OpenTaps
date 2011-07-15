<center>
<div>
<script type="text/javascript">
	function show_org_edit(id,org_name,org_desc){
		document.getElementById("add_org").innerHTML = "<font size='2pt'>Edit Organization<a style='margin-left:130px;' href=''>switch to add mode</a></font>";
		document.getElementById("org_form").getElementsByTagName("input")[1].value = "Edit";
		document.getElementById("org_form").style.display = "block";
		document.getElementsByName("org_name")[0].value = org_name;
		document.getElementsByTagName("textarea")[0].value = org_desc;
		var hid_inp = document.createElement("input");
		hid_inp.setAttribute("type","hidden");
		hid_inp.setAttribute("value",id);
		hid_inp.setAttribute("name","org_id");
		document.getElementById("org_form").getElementsByTagName("form")[0].insertBefore(hid_inp,document.getElementById("org_form").getElementsByTagName("form")[0].firstChild);
	}
</script>
<div>Organizations</a></div>
<div style="border:1px solid #000;width:400px;">
	<div id="add_org" style="background-color:#CCC;cursor:default;"><font size="2pt">Add Organization</font></div>
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

<div style="border:0px solid #000;width:500px;height:auto;overflow:auto;">
	<table border="0px" style="font-size:9pt;">
	<tr><td><center></div></center></td><td><center>Organization</center></td><td><center>Description</center></td></tr>
	<?php list_organizations(); ?>
	</table>
</div>
</div>
</center>

<script type="text/javascript">
	document.getElementById("add_org").onclick = function(){
		if(document.getElementById("org_form").style.display == "none")
		document.getElementById("org_form").style.display = "block";
		else document.getElementById("org_form").style.display = "none";
	};
</script>
