<?php
$action = href("admin/regions/update/" . $region['unique'], TRUE);
?>
<form action='<? echo $action; ?>' method='post'>
    <label for='pname'>Name: </label>
    <br />
    <input name='p_name' id='pname' type='text' value="<?php echo $region['name']; ?>"/>
    <br /><br />

    <label for='preg_info'>Region Info: </label>
    <br />
    <textarea name='p_reg_info' id='preg_info' cols='30' rows='3'><?php echo $region['region_info']; ?></textarea>
    <br />

    <label for='preg_projects_info'>Region Projects info: </label>
    <br />
    <textarea name='p_reg_projects_info' id='preg_projects_info' cols='30' rows='3'><?php echo $region['projects_info']; ?></textarea>
    <br />



    <label for='longitude'>Longitude: </label>
    <br />
    <input name='longitude' id='longitude' type='text' value="<?php echo $region['longitude']; ?>"/>
    <br /><br />

    <label for='latitude'>Latitude: </label>
    <br />
    <input name='latitude' id='latitude' type='text' value="<?php echo $region['latitude']; ?>"/>
    <br /><br />



    <label for='pcity'>City: </label>
    <br />
    <input name='p_city' id='pcity' type='text' value="<?php echo $region['city']; ?>"/>
    <br /><br />

    <label for='pcities'>Cities: </label>
    <br />
    <input name='p_cities' id='pcities' type='text' />
    <br /><br />

    <label for='ptowns'>Towns: </label>
    <br />
    <input name='p_towns' id='ptowns' type='text' />
    <br /><br />

    <label for='ppopulation'>Population: </label>
    <br />
    <input name='p_population' id='ppopulation' type='text' value="<?php echo $region['population']; ?>"/>
    <br /><br />

    <label for='psquares'>Square Meters: </label>
    <br />
    <input name='p_squares' id='psquares' type='text' value="<?php echo $region['square_meters']; ?>" />
    <br /><br />

    <label for='psettlements'>Settlement: </label>
    <br />
    <input name='p_settlement' id='psettlement' type='text' value="<?php echo $region['settlement']; ?>" />
    <br /><br />

    <label for='pvillages'>Villages </label>
    <br />
    <input name='p_villages' id='pvillages' type='text' value="<?php echo $region['villages']; ?>"/>
    <br /><br />

    <label for='pdisrtricts'>Districts </label>
    <br />
    <input name='p_districts' id='pdistricts' type='text' value="<?php echo $region['districts']; ?>" />
    <br /><br />


    <!-- <label for='ptags'>Tags: (hold down Ctrl to select multiple)</label>
  	    <br />
     <select name='p_tags[]' id='ptags' multiple='multiple'>
    <?php
    foreach ($all_tags as $tag)
    {
        ?>
      	            <option value="<?php echo $tag['id'] ?>"><?php echo $tag['name'] ?></option>
        <?php
    }
    ?>
  	    </select>-->

    <label for='pwatersupply'>Water Supply: </label>
    <br />
    <input name='p_watersupply' id='pwatersupply' value="<?php empty($water_supply[0]['text']) OR print $water_supply[0]['text']; ?>" type='text' />
    <br /><br />



    <h3>Region Data</h3>
    <div id="data_fields_container" style="padding-left: 55px;">
        <?php foreach ($data as $idx => $d):
            $bg = ($idx & 1) ? 'url(' . href() . 'images/bg.jpg) repeat' : 'white'; ?>
            <div class='group' style='background: <?php echo $bg; ?>'>
                <label style='cursor: pointer'>
      	    			Title: <br />
                    <input name='data_key[]' value="<?php empty($d['key']) OR print $d['key'] ?>" type='text' />
                </label><br /><br />
                <label style='cursor: pointer'>
    				Sort: <br />
                    <input name='data_sort[]' value="<?php empty($d['sort']) OR print $d['sort']; ?>" type='text' style='width: 40px' />
                </label>
                <input type='hidden' class="data_unique_container" name='sidebar[]' value='<?php (!empty($d['sidebar']) AND $d['sidebar'] == 1) AND print "checked"; ?>' />
                <label style='margin-left: 25px; cursor: pointer;' onmouseup="check_sidebar($(this))">
                    <input type='checkbox' <?php (!empty($d['sidebar']) AND $d['sidebar'] == 1) AND print 'checked="checked"'; ?> /> Sidebar
                </label><br /><br />
                <label style='cursor: pointer'>
      	    			Text: <br />
                    <textarea class='mceEditor' name='data_value[]' cols='55' rows='5'><?php empty($d['value']) OR print $d['value'] ?></textarea>
                </label>
                <a style='color: red; cursor: pointer; font-size: 13px;' onclick='$(this).parent().slideUp(function(){ $(this).remove(); })'>
    	    			- Remove data
                </a>
                <br /><hr style='margin-left: -27px' />
            </div>
        <?php endforeach; ?>
    </div>
    <a style="color: #4CBEFF; cursor: pointer; font-size: 13px;" id="add_data_field">+Add data</a><br /><br />



    <input type='submit' style='width:90px;' value='Submit' onclick='return document.getElementById("ptitle").value != ""' />
    <br /><br />
</form>

<a href="<?php echo href("admin/regions", TRUE); ?>">Back</a>
<br />
<a onclick='return confirm("Are you sure?");' href="<?php echo href("admin/regions/" . $region['unique'] . "/delete", TRUE); ?>" >
  	    Delete this record
</a>
