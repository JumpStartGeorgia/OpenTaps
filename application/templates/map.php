<div id="map_and_menus" style="position: relative">

    <div id="map" style="height: 360px; width: 100%"></div>

    <div id="map-overlay" style="display: none"><?php echo strtoupper(l('map_active')) ?></div>

    <ul id="map-controls">

        <li id="map-minus"><a class="map-button" href="javascript:zoom_out();">-</a></li>
        <li id="map-plus"><a class="map-button" href="javascript:zoom_in();">+</a></li>

        <li id="map-filter">
            <a class="map-button" href="javascript:;"><img src="images/map/filter.png" width="13" height="11" alt="" /><?php echo l('map_projects') ?></a>
            <ul>
                <li class="first">
                    <a href="javascript:;" class="skip"><img src="images/map/projects/sewage_completed.png" width="27" height="27" alt="" /><?php echo l('map_project_sewage') ?></a>
                    <ul>
                        <li><a class="sub" href="javascript:toggle_projects('sewage', 'completed');"><img src="images/map/projects/sewage_completed.png" width="27" height="27" alt="" /><?php echo l('map_type_completed') ?></a></li>
                        <li><a class="sub" href="javascript:toggle_projects('sewage', 'current');"><img src="images/map/projects/sewage_current.png" width="27" height="27" alt="" /><?php echo l('map_type_current') ?></a></li>
                        <li><a class="sub" href="javascript:toggle_projects('sewage', 'scheduled');"><img src="images/map/projects/sewage_scheduled.png" width="27" height="27" alt="" /><?php echo l('map_type_scheduled') ?></a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:;" class="skip"><img src="images/map/projects/water_supply_completed.png" width="27" height="27" alt="" /><?php echo l('map_project_water_supply') ?></a>
                    <ul>
                        <li><a class="sub" href="javascript:toggle_projects('water_supply', 'completed');"><img src="images/map/projects/water_supply_completed.png" width="27" height="27" alt="" /><?php echo l('map_type_completed') ?></a></li>
                        <li><a class="sub" href="javascript:toggle_projects('water_supply', 'current');"><img src="images/map/projects/water_supply_current.png" width="27" height="27" alt="" /><?php echo l('map_type_current') ?></a></li>
                        <li><a class="sub" href="javascript:toggle_projects('water_supply', 'scheduled');"><img src="images/map/projects/water_supply_scheduled.png" width="27" height="27" alt="" /><?php echo l('map_type_scheduled') ?></a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:;" class="skip"><img src="images/map/projects/water_pollution_completed.png" width="27" height="27" alt="" /><?php echo l('map_project_water_pollution') ?></a>
                    <ul>
                        <li><a class="sub" href="javascript:toggle_projects('water_pollution', 'completed');"><img src="images/map/projects/water_pollution_completed.png" width="27" height="27" alt="" /><?php echo l('map_type_completed') ?></a></li>
                        <li><a class="sub" href="javascript:toggle_projects('water_pollution', 'current');"><img src="images/map/projects/water_pollution_current.png" width="27" height="27" alt="" /><?php echo l('map_type_current') ?></a></li>
                        <li><a class="sub" href="javascript:toggle_projects('water_pollution', 'scheduled');"><img src="images/map/projects/water_pollution_scheduled.png" width="27" height="27" alt="" /><?php echo l('map_type_scheduled') ?></a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:;" class="skip"><img src="images/map/projects/irrigation_completed.png" width="27" height="27" alt="" /><?php echo l('map_project_irrigation') ?></a>
                    <ul>
                        <li><a class="sub" href="javascript:toggle_projects('irrigation', 'completed');"><img src="images/map/projects/irrigation_completed.png" width="27" height="27" alt="" /><?php echo l('map_type_completed') ?></a></li>
                        <li><a class="sub" href="javascript:toggle_projects('irrigation', 'current');"><img src="images/map/projects/irrigation_current.png" width="27" height="27" alt="" /><?php echo l('map_type_current') ?></a></li>
                        <li><a class="sub" href="javascript:toggle_projects('irrigation', 'scheduled');"><img src="images/map/projects/irrigation_scheduled.png" width="27" height="27" alt="" /><?php echo l('map_type_scheduled') ?></a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:;" class="skip"><img src="images/map/projects/water_quality_completed.png" width="27" height="27" alt="" /><?php echo l('map_project_water_quality') ?></a>
                    <ul>
                        <li><a class="sub" href="javascript:toggle_projects('water_quality', 'completed');"><img src="images/map/projects/water_quality_completed.png" width="27" height="27" alt="" /><?php echo l('map_type_completed') ?></a></li>
                        <li><a class="sub" href="javascript:toggle_projects('water_quality', 'current');"><img src="images/map/projects/water_quality_current.png" width="27" height="27" alt="" /><?php echo l('map_type_current') ?></a></li>
                        <li><a class="sub" href="javascript:toggle_projects('water_quality', 'scheduled');"><img src="images/map/projects/water_quality_scheduled.png" width="27" height="27" alt="" /><?php echo l('map_type_scheduled') ?></a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:;" class="skip"><img src="images/map/projects/water_accidents_completed.png" width="27" height="27" alt="" /><?php echo l('map_project_water_accidents') ?></a>
                    <ul>
                        <li><a class="sub" href="javascript:toggle_projects('water_accidents', 'completed');"><img src="images/map/projects/water_accidents_completed.png" width="27" height="27" alt="" /><?php echo l('map_type_completed') ?></a></li>
                        <li><a class="sub" href="javascript:toggle_projects('water_accidents', 'current');"><img src="images/map/projects/water_accidents_current.png" width="27" height="27" alt="" /><?php echo l('map_type_current') ?></a></li>
                        <li><a class="sub" href="javascript:toggle_projects('water_accidents', 'scheduled');"><img src="images/map/projects/water_accidents_scheduled.png" width="27" height="27" alt="" /><?php echo l('map_type_scheduled') ?></a></li>
                    </ul>
                </li>
            </ul>
        </li>

        <li id="map-overlays">
            <a class="map-button"><img src="images/map/layer.png" width="13" height="11" alt="" /><?php echo l('map_overlays') ?></a>
            <ul>
                <li class="first"><a class="active" href="javascript:toggle_overlay('cities');toggle_overlay('urban');toggle_overlay('villages');"><img src="images/map/city.png" width="15" height="14" alt="" /><?php echo l('map_settlements') ?></a></li>
                <li><a href="javascript:toggle_overlay('hydro');"><img src="images/map/hydro.png" width="15" height="14" alt="" /><?php echo l('map_hydro') ?></a></li>
                <li><a class="active" href="javascript:toggle_overlay('water');"><img src="images/map/waters.png" width="15" height="14" alt="" /><?php echo l('map_water') ?></a></li>
                <li><a class="active" href="javascript:toggle_overlay('protected_areas');"><img src="images/map/protected_areas.png" width="15" height="14" alt="" /><?php echo l('map_protected_areas') ?></a></li>
                <li><a href="javascript:toggle_overlay('roads');"><img src="images/map/roads.png" width="15" height="14" alt="" /><?php echo l('map_roads') ?></a></li>
            </ul>
        </li>

    </ul>

</div>

<div class="group" style="height: 1.5em; display: block"></div>
