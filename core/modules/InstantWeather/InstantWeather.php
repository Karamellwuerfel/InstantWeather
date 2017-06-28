<!--///////////////////////////////////////////////////////////////
/////InstantWeather Module v1.1 for phpvms by Philipp Dalheimer////
//////////////////////www.philippdalheimer.de//////////////////////
///+ DO NOT EDIT + FOR FREE USE + PHPVMS FORUM: MrDonutButter +////
///////////////////////////////////////////////////////////////-->

<?php
class InstantWeather extends CodonModule
{
	
	
	public function chk_update()
		{
			$ver = 1.1; 
			$ver_actual = floatval(file_get_contents("http://philippdalheimer.de/phpvms-demo-1/lib/skins/future/instantweather_ver.txt")); 
			
			if($ver_actual > $ver){
				echo ' | <a href="http://philippdalheimer.de/phpvms-demo-1/" target="_blank"><font color="red">new version '.$ver_actual.' available!</a>';
			}else{
				//nothing
			}
			
		}
		
	
	public function index() 
	   {

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
	
			$this->set('curr_location', $curr_location);
			$this->set('last_location', $last_location);
			$this->set('metar', $metar);
			$this->set('icao', $station_id);
			$this->set('observation_time', $observation_time);
			$this->set('wind_dir_deg', $wind_dir_degrees);
			$this->set('temp_c', $temp_c);
			$this->set('wind_speed_kt', $wind_speed_kt);
			$this->set('visibility_statute_mi', $visibility_statute_mi);
			$this->set('dewpoint', $dewpoint_c);
			$this->set('elevation', $elevation_m);
	
            $this->show('/instantweather/instantweather.php');
        }
		
	public function get_metar()
		{
			$last_location = PIREPData::getLastReports(Auth::$userinfo->pilotid, 1, PIREP_ACCEPTED);
			$curr_location = $last_location->arricao;
			
			$url = 'https://www.aviationweather.gov/adds/dataserver_current/httpparam?dataSource=metars&requestType=retrieve&format=xml&stationString='.$curr_location.'&hoursBeforeNow=1.0';
			$xml = simplexml_load_file($url);

			$metar = $xml->data[0]->METAR->raw_text;
			
			echo $metar;
		}
		
	public function sky_condition()
		{
			
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
						
						case "SKC": $skycover_uncrypt = "(Sky clear)";
						break;
						
						case "CLR": $skycover_uncrypt = "(No clouds below 12,000 ft)";
						break;
						
						case "NSC": $skycover_uncrypt = "(No significant cloud)";
						break;
						
						case "FEW": $skycover_uncrypt = "";
						break;
						
						case "SCT": $skycover_uncrypt = "(Scattered)";
						break;
						
						case "BKN": $skycover_uncrypt = "(Broken)";
						break;
						
						case "OVC": $skycover_uncrypt = "(Overcast)";
						break;
						
						case "VV": $skycover_uncrypt = "(Clouds cannot be seen because of fog or heavy precipitation)";
						break;
					
					}
					
					
					echo '<tr> <td><b>Sky condition level '.$i.'</b></td> <td>'.$skycover. ' ' . $cond->attributes()->{'cloud_base_ft_agl'}.' ft'. PHP_EOL .$skycover_uncrypt.'</td> </tr>';
					$i++;
			}
			}
			
		}
}
?>