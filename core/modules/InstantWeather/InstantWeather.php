<?php

	class InstantWeather extends CodonModule
	{
		
		
		
		public function chk_update(){
			
			$ver = 1.5; 
			$ver_actual = floatval(file_get_contents("https://www.dropbox.com/s/6cw52cf49idjz8t/InstantWeather_ver.txt?dl=1")); 
			
			if($ver_actual > $ver){
				echo ' | <a href="https://github.com/Karamellwuerfel/InstantWeather" target="_blank"><font color="red">new version '.$ver_actual.' available!</a></font>';
			}else{
				//nothing
			}
				
		}
			
		
		public function index(){
			
			$TEMPERATURE = "f"; // USE f for FAHRENHEIT and c for CELSIUS
			$VISIBILITY = "k"; // USE m for MILES and k for KILOMETERS
			
			// Don't change anything below!
			
			$celsius = "c";
			$fahrenheit = "f";
			$kilometers = "k";
			
			$bids = SchedulesData::getAllBids();  
			
			
			$last_location = PIREPData::getLastReports(Auth::$userinfo->pilotid, 1, PIREP_ACCEPTED);
			$curr_location = $last_location->arricao;
			$url = 'https://www.aviationweather.gov/adds/dataserver_current/httpparam?dataSource=metars&requestType=retrieve&format=xml&stationString='.$curr_location.'&hoursBeforeNow=1.0';
			$xml = simplexml_load_file($url);

			$metar = $xml->data[0]->METAR->raw_text;
			$station_id = $xml->data[0]->METAR->station_id;
			$observation_time = $xml->data[0]->METAR->observation_time;
			$wind_dir_degrees = $xml->data[0]->METAR->wind_dir_degrees;
			$temp_c = $xml->data[0]->METAR->temp_c;
			$wind_speed_kt = $xml->data[0]->METAR->wind_speed_kt;
			$visibility_statute_mi = $xml->data[0]->METAR->visibility_statute_mi;
			$dewpoint_c = $xml->data[0]->METAR->dewpoint_c;
			$elevation_m = $xml->data[0]->METAR->elevation_m;
			$altim_in_hg = $xml->data[0]->METAR->altim_in_hg;
			
			$temp_f = ($temp_c * (9 / 5) ) + 32;
			$dewpoint_f = ($dewpoint_c * (9 / 5) ) + 32;
			
			$visibility_km = round($visibility_statute_mi * 0.621371, 2);
	
			$this->set('curr_location', $curr_location);
			$this->set('last_location', $last_location);
			$this->set('metar', $metar);
			$this->set('icao', $station_id);
			$this->set('observation_time', $observation_time);
			$this->set('wind_dir_deg', $wind_dir_degrees);
			$this->set('wind_speed_kt', $wind_speed_kt);
			$this->set('visibility_statute_mi', $visibility_statute_mi);
			$this->set('elevation', $elevation_m);
			$this->set('altim_in_hg', $altim_in_hg);
	
			if($TEMPERATURE == $celsius){
				$this->set('dewpoint', $dewpoint_c);
				$this->set('temp', $temp_c);
				$this->set('temp_indicator', "&deg;C");
			}
			
			if($TEMPERATURE == $fahrenheit){
				$this->set('dewpoint', $dewpoint_f);
				$this->set('temp', $temp_f);
				$this->set('temp_indicator', "&deg;F");
			}
			
			if($VISIBILITY == $kilometers){
				$this->set('visibility_decrypt', $visibility_km . " km");
			}else{
				$this->set('visibility_decrypt', $visibility_statute_mi . " miles");
			}
	
	
			$this->show('/instantweather/instantweather.php');
			
		}
			
		public function get_metar(){
			
			$last_location = PIREPData::getLastReports(Auth::$userinfo->pilotid, 1, PIREP_ACCEPTED);
			$curr_location = $last_location->arricao;
			
			$url = 'https://www.aviationweather.gov/adds/dataserver_current/httpparam?dataSource=metars&requestType=retrieve&format=xml&stationString='.$curr_location.'&hoursBeforeNow=1.0';
			$xml = simplexml_load_file($url);

			$metar = $xml->data[0]->METAR->raw_text;
			
			echo $metar;
		}
			
		public function sky_condition(){
			
			$last_location = PIREPData::getLastReports(Auth::$userinfo->pilotid, 1, PIREP_ACCEPTED);
			$curr_location = $last_location->arricao;
			
			$url = 'https://www.aviationweather.gov/adds/dataserver_current/httpparam?dataSource=metars&requestType=retrieve&format=xml&stationString='.$curr_location.'&hoursBeforeNow=1.0';
			$xml = simplexml_load_file($url);
			
			$sk_cond = $xml->data->METAR->sky_condition;
			$i = 1;
			
			if(!$sk_cond){
				echo '<tr> <td><b>Sky condition level '.$i.'</b></td> <td><i>There\'s no actual sky condition or there were an issue.</i></td> </tr>';
			}else{
				foreach ($sk_cond as $cond) {
					$skycover = $cond->attributes()->{'sky_cover'};
					$skycover_uncrypt = "";
					switch($skycover){
						
						case "SKC": $skycover_uncrypt = "ft (Sky clear)";
						break;
						
						case "CLR": $skycover_uncrypt = "ft (No clouds below 12,000 ft)";
						break;
						
						case "NSC": $skycover_uncrypt = "ft (No significant cloud)";
						break;
						
						case "FEW": $skycover_uncrypt = "ft ";
						break;
						
						case "SCT": $skycover_uncrypt = "ft (Scattered)";
						break;
						
						case "BKN": $skycover_uncrypt = "ft (Broken)";
						break;
						
						case "OVC": $skycover_uncrypt = "ft (Overcast)";
						break;
						
						case "VV": $skycover_uncrypt = "ft (Clouds cannot be seen because of fog or heavy precipitation)";
						break;
						
						case "CAVOK": $skycover_uncrypt = "(Ceiling and visibility okay)";
						break;
					
					}
					
					
					echo '<tr> <td class="fat">Sky condition level '.$i.'</td> <td>'.$skycover. ' ' . $cond->attributes()->{'cloud_base_ft_agl'}.' '. PHP_EOL .$skycover_uncrypt.'</td> </tr>';
					$i++;
				}
			}
			
		}
	}
?>