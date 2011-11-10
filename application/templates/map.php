<div id="map_and_menus" style="position: relative">

    <div id="map"></div>

    <div id="map-overlay"><?php echo strtoupper(l('map_active')) ?></div>

    <div id="tooltip"><span></span></div>

    <ul id="map-controls">

        <li id="map-minus"><a class="map-button" href="javascript:zoom_out();">-</a></li>
        <li id="map-plus"><a class="map-button" href="javascript:zoom_in();">+</a></li>

        <li id="map-filter">
            <a id="control-projects" class="map-button" href="javascript:;"><img src="images/map/filter.png" width="13" height="11" alt="" /><?php echo l('map_projects') ?></a>
            <ul><?php
$idx = 0;
$types = array('sewage', 'water_supply', 'water_pollution', 'irrigation', 'water_quality', 'water_accidents');
$statuses = array('completed', 'current', 'scheduled');
foreach ($types AS $type):
    //$check_type = json_decode(file_get_contents(URL . "map-data/projects/{$type}?lang=" . LANG));
    //if (empty($check_type))
    //continue;
   ?>
                <li<?php $idx == 0 AND print ' class="first"' ?>>
                    <a id="control-<?php echo $type ?>" href="javascript:;" class="skip"><img src="images/map/projects/<?php echo $type ?>_completed.png" width="27" height="27" alt="" /><?php echo l('map_project_' . $type) ?></a>
                    <ul><?php
                foreach ($statuses AS $status):
                    //$check_type_status = json_decode(file_get_contents(URL . "map-data/projects/{$type}/{$status}?lang=" . LANG));
                    //if (empty($check_type_status))
                    //continue;
                    echo '<li><a id="control-' . $type . '-' . $status . '" class="sub" href="javascript:toggle_projects(\'' . $type . '\', \'' . $status . '\');"><img src="images/map/projects/' . $type . '_' . $status . '.png" width="27" height="27" alt="" />' . l('map_type_' . $status) . '</a></li>';
                endforeach;
   ?></ul>
                </li>
                    <?php
                    $idx++;
                endforeach;
                ?>
            </ul>
        </li>

        <li id="map-overlays">
            <a class="map-button"><img src="images/map/layer.png" width="13" height="11" alt="" /><?php echo l('map_overlays') ?></a>
            <ul>
                <li class="first"><a id="overlay-cities" class="active" href="javascript:toggle_overlay('cities');toggle_overlay('urban');toggle_overlay('villages');"><img src="images/map/city.png" width="15" height="14" alt="" /><?php echo l('map_settlements') ?></a></li>
                <li><a id="overlay-hydro" href="javascript:toggle_overlay('hydro');"><img src="images/map/hydro.png" width="15" height="14" alt="" /><?php echo l('map_hydro') ?></a></li>
                <li><a id="overlay-water" href="javascript:toggle_overlay('water');"><img src="images/map/waters.png" width="15" height="14" alt="" /><?php echo l('map_water') ?></a></li>
                <li><a id="overlay-protected_areas" class="active" href="javascript:toggle_overlay('protected_areas');"><img src="images/map/protected_areas.png" width="15" height="14" alt="" /><?php echo l('map_protected_areas') ?></a></li>
                <li><a id="overlay-roads" href="javascript:toggle_overlay('roads');"><img src="images/map/roads.png" width="15" height="14" alt="" /><?php echo l('map_roads') ?></a></li>
            </ul>
        </li>

    </ul>

</div>

<div class="group" style="height: 1.5em; display: block"></div>
