<div id="map_and_menus" style="position: relative">

    <div id="map" style="height: 360px; width: 100%"></div>

    <div id="map-overlay"><?php echo strtoupper(l('map_active')) ?></div>

    <a id="map-minus-button" class="map-button" href="javascript:zoom_out();">-</a>
    <a id="map-plus-button" class="map-button" href="javascript:zoom_in();">+</a>

    <a id="map-overlays-button" class="map-button" href="javascript:;"><img src="images/map/layer.png" width="13" height="11" alt="" /> Overlays</a>
    <a id="map-filter-button" class="map-button" href="javascript:;"><img src="images/map/filter.png" width="13" height="11" alt="" /> Filter</a>

    <div id="map-overlays" class="map-drop-menu">
        <ul>
            <li class="first"><a class="active" href="javascript:toggle_layer(layers.cities);"><img src="images/map/city.png" width="15" height="14" alt="" />Cities</a></li>
            <li><a class="active" href="javascript:toggle_layer(layers.hydro);"><img src="images/map/hydro.png" width="15" height="14" alt="" />Hydro</a></li>
            <li><a class="active" href="javascript:toggle_layer(layers.water);"><img src="images/map/waters.png" width="15" height="14" alt="" />Water</a></li>
            <li><a class="active" href="javascript:toggle_layer(layers.protected_areas);"><img src="images/map/protected_areas.png" width="15" height="14" alt="" />Protected Areas</a></li>
        </ul>
    </div>

    <div id="map-filter" class="map-drop-menu">
        <ul>
            <li class="first">
                <a href="javascript:;" class="skip"><img src="images/map/projects/sewage_completed.png" width="27" height="27" alt="" />Sewage</a>
                <ul>
                    <li><a class="sub" href="javascript:toggle_projects('sewage', 'completed');"><img src="images/map/projects/sewage_completed.png" width="27" height="27" alt="" />Completed</a></li>
                    <li><a class="sub" href="javascript:toggle_projects('sewage', 'current');"><img src="images/map/projects/sewage_current.png" width="27" height="27" alt="" />Current</a></li>
                    <li><a class="sub" href="javascript:toggle_projects('sewage', 'scheduled');"><img src="images/map/projects/sewage_scheduled.png" width="27" height="27" alt="" />Scheduled</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="skip"><img src="images/map/projects/water_supply_completed.png" width="27" height="27" alt="" />Water Supply</a>
                <ul>
                    <li><a class="sub" href="javascript:toggle_projects('water_supply', 'completed');"><img src="images/map/projects/water_supply_completed.png" width="27" height="27" alt="" />Completed</a></li>
                    <li><a class="sub" href="javascript:toggle_projects('water_supply', 'current');"><img src="images/map/projects/water_supply_current.png" width="27" height="27" alt="" />Current</a></li>
                    <li><a class="sub" href="javascript:toggle_projects('water_supply', 'scheduled');"><img src="images/map/projects/water_supply_scheduled.png" width="27" height="27" alt="" />Scheduled</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="skip"><img src="images/map/projects/water_pollution_completed.png" width="27" height="27" alt="" />Water Pollution</a>
                <ul>
                    <li><a class="sub" href="javascript:toggle_projects('water_pollution', 'completed');"><img src="images/map/projects/water_pollution_completed.png" width="27" height="27" alt="" />Completed</a></li>
                    <li><a class="sub" href="javascript:toggle_projects('water_pollution', 'current');"><img src="images/map/projects/water_pollution_current.png" width="27" height="27" alt="" />Current</a></li>
                    <li><a class="sub" href="javascript:toggle_projects('water_pollution', 'scheduled');"><img src="images/map/projects/water_pollution_scheduled.png" width="27" height="27" alt="" />Scheduled</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="skip"><img src="images/map/projects/irrigation_completed.png" width="27" height="27" alt="" />Irrigation</a>
                <ul>
                    <li><a class="sub" href="javascript:toggle_projects('irrigation', 'completed');"><img src="images/map/projects/irrigation_completed.png" width="27" height="27" alt="" />Completed</a></li>
                    <li><a class="sub" href="javascript:toggle_projects('irrigation', 'current');"><img src="images/map/projects/irrigation_current.png" width="27" height="27" alt="" />Current</a></li>
                    <li><a class="sub" href="javascript:toggle_projects('irrigation', 'scheduled');"><img src="images/map/projects/irrigation_scheduled.png" width="27" height="27" alt="" />Scheduled</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="skip"><img src="images/map/projects/water_quality_completed.png" width="27" height="27" alt="" />Water Quality</a>
                <ul>
                    <li><a class="sub" href="javascript:toggle_projects('water_quality', 'completed');"><img src="images/map/projects/water_quality_completed.png" width="27" height="27" alt="" />Completed</a></li>
                    <li><a class="sub" href="javascript:toggle_projects('water_quality', 'current');"><img src="images/map/projects/water_quality_current.png" width="27" height="27" alt="" />Current</a></li>
                    <li><a class="sub" href="javascript:toggle_projects('water_quality', 'scheduled');"><img src="images/map/projects/water_quality_scheduled.png" width="27" height="27" alt="" />Scheduled</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="skip"><img src="images/map/projects/water_accidents_completed.png" width="27" height="27" alt="" />Water Accidents</a>
                <ul>
                    <li><a class="sub" href="javascript:toggle_projects('water_accidents', 'completed');"><img src="images/map/projects/water_accidents_completed.png" width="27" height="27" alt="" />Completed</a></li>
                    <li><a class="sub" href="javascript:toggle_projects('water_accidents', 'current');"><img src="images/map/projects/water_accidents_current.png" width="27" height="27" alt="" />Current</a></li>
                    <li><a class="sub" href="javascript:toggle_projects('water_accidents', 'scheduled');"><img src="images/map/projects/water_accidents_scheduled.png" width="27" height="27" alt="" />Scheduled</a></li>
                </ul>
            </li>
        </ul>
    </div>

</div>

<div class="group" style="height: 1.5em; display: block"></div>
