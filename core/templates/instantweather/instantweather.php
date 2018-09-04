<?php $copyright = file_get_contents("https://www.dropbox.com/s/6oxwm3m13sbrdra/InstantWeather_copyr.txt?dl=1");  ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,700" rel="stylesheet">

<!--///////////////////////////////////////////////////////////////
/////InstantWeather Module v1.8 for phpvms by Philipp Dalheimer////
//////////////////////www.philippdalheimer.de//////////////////////
///+ DO NOT EDIT + FOR FREE USE + PHPVMS FORUM: MrDonutButter +////

Weather API from https://aviationweather.gov/adds/dataserver/metars/MetarExamples.php

///////////////////////////////////////////////////////////////-->

<div id="data" style="padding: 30px;">

	<div class="container">
	
	<br>
	
		<?php 
		
			if(!$last_location->arricao){
				echo "<h3 class=\"h3\" style=\"font-weight: 300;\">Oh... What? You're at home! We only know the weather on airports!</h3>";
			}elseif(!$metar){
				echo "<h3 class=\"h3\" style=\"font-weight: 300;\">Sorry... The server needs a moment! Please try it again in a minute. <i class=\"fa fa-frown-o\"></i></h3>";
			}else{ ?>
				
				<h3 class="h3" style="font-weight: 300;">Howdy! You're in <?php echo $icao;?></h3>
				<br />
				<table style="width:100% !important;">
				  <tr>
					<td class="fat">METAR</td>
					<td><?php echo $metar;?></td>
				  </tr>
				  <tr>
					<td class="fat">Pressure (altimeter)</td>
					<td><?php echo $altim_bar . " mbar";?></td>
				  </tr>
				  <tr>
					<td class="fat">Wind</td>
					<td><?php echo $wind_dir_deg;?>&deg; with <?php echo $wind_speed_kt;?> kts</td>
				  </tr>
				  <tr>
					<td class="fat">Temperature</td>
					<td><?php echo $temp;?> <?php echo ' '. $temp_indicator;?></td>
				  </tr>
				  <tr>
					<td class="fat">Dewpoint</td>
					<td><?php echo $dewpoint;?> <?php echo ' '. $temp_indicator;?></td>
				  </tr>
				  <tr>
					<td class="fat">Horizontal visibility</td>
					<td><?php echo $visibility_decrypt;?></td>
				  </tr>
				  
				  <?php MainController::Run('InstantWeather', 'sky_condition', ''); ?>
					
				</table>
				<br>
				<small style="color:#a3a3a3;">Updated <?php echo $observation_time;?>  |  InstantWeather Module v1.8 <?php echo $copyright; ?> <?php MainController::Run('InstantWeather', 'chk_update', ''); ?>
					<br>
					<br>
					How do I <a href="https://en.wikipedia.org/wiki/METAR#Example_METAR_codes" target="_blank"> read METAR </a> and how do I <a href="https://en.wikipedia.org/wiki/METAR#Cloud_reporting" target="_blank">read sky condition</a> ?
				</small>

		<?php } ?>
		
		
	</div>
<div>

<style>
	
	.fat{
		font-weight: 700;
		width: 25%;
	}
	
	.h3{
		font-family: 'Roboto', sans-serif;
		background: none;
		padding-left: 0px;
		padding-bottom: 0px;
		margin-top: 10px;
		color: #565656;
	}
	
	.container{
		font-family: 'Roboto', sans-serif;
		font-size: 14px;
	}
	
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




























