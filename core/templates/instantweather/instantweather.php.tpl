<!--///////////////////////////////////////////////////////////////
/////InstantWeather Module v1.1 for phpvms by Philipp Dalheimer////
//////////////////////www.philippdalheimer.de//////////////////////
///+ DO NOT EDIT + FOR FREE USE + PHPVMS FORUM: MrDonutButter +////

Weather API from https://aviationweather.gov/adds/dataserver/metars/MetarExamples.php

///////////////////////////////////////////////////////////////-->

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div id="data" style="padding: 30px;">

	<h2 style="padding-bottom: 10px;">InstantWeather Module v1.1</h2>
	<br>
	<div class="container">
	
		<?php 
		
			if(!$last_location){
				echo "<h3 style=\"font-weight: 200;\">Oh... What? You're at home! We only know the weather on airports!</h3>";
			}elseif(!$metar){
				echo "<h3 style=\"font-weight: 200;\">Sorry... The server needs a moment! Please try it again in a minute. <i class=\"fa fa-frown-o\"></i></h3>";
			}else{ ?>
				
				<h3 style="font-weight: 200;">Howdy! You're in <?php echo $icao;?> (<?php echo $elevation;?> ft).</h3>
				<br />
				<table style="width:100% !important;">
				  <tr>
					<td><b>METAR</b></td>
					<td><?php echo $metar;?></td>
				  </tr>
				  <tr>
					<td><b>Wind</b></td>
					<td><?php echo $wind_dir_deg;?>° with <?php echo $wind_speed_kt;?> kts</td>
				  </tr>
				  <tr>
					<td><b>Temperature</b></td>
					<td><?php echo $temp_c;?> °C</td>
				  </tr>
				  <tr>
					<td><b>Dewpoint</b></td>
					<td><?php echo $dewpoint;?> °C</td>
				  </tr>
				  <tr>
					<td><b>Horizontal visibility</b></td>
					<td><?php echo $visibility_statute_mi;?> statute miles</td>
				  </tr>
				  
				  <?php MainController::Run('InstantWeather', 'sky_condition', ''); ?>
					
				</table>
				<br>
				<small style="color:#a3a3a3;">Updated <?php echo $observation_time;?>  |  module by <a href="http://philippdalheimer.de/" target="_blank">Philipp Dalheimer</a><?php MainController::Run('InstantWeather', 'chk_update', ''); ?></small>

		<?php } ?>
		
	</div>
<div>

<style>
	
	
	table {
    border-collapse: collapse;
    width: 30%;
	}

	th, td {
		padding: 8px;
		text-align: left;
		border-bottom: 1px solid #ddd;
	}

	tr:hover{background-color:#e5e5e5}
	
</style>




























