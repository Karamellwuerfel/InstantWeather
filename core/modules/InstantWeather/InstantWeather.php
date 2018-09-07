<?php

/*///////////////////////////////////////////////////////////////
/////InstantWeather Module v1.9 for phpvms by Philipp Dalheimer////
//////////////////////www.philippdalheimer.de//////////////////////
///+ DO NOT EDIT + FOR FREE USE + PHPVMS FORUM: MrDonutButter +////

Weather API from https://aviationweather.gov/adds/dataserver/metars/MetarExamples.php

///////////////////////////////////////////////////////////////*/

    define("TEMPERATURE", "c"); // USE f for FAHRENHEIT and c for CELSIUS
    define("VISIBILITY", "m");  // USE m for MILES and k for KILOMETERS

    // Don't change anything below!

    define("CELSIUS", "c");
    define("FAHRENHEIT", "f");
    define("KILOMETERS", "k");


	class InstantWeather extends CodonModule
	{

        private $metar;
        private $station_id;
        private $observation_time;
        private $wind_dir_degrees;
        private $temp_c;
        private $wind_speed_kt;
        private $visibility_statute_mi;
        private $dewpoint_c;
        private $elevation_m;
        private $altim_bar;
        private $temp_f;
        private $dewpoint_f;
        private $visibility_km;
        private $sk_cond;

        private $last_location;
        private $curr_location;

        /**
         * InstantWeather constructor.
         * @param $metar
         */
        public function __construct()
        {
            if(isset($_GET['icao']) && strlen($_GET['icao']) <= 4)
            {
                $last_location = PIREPData::getLastReports(Auth::$userinfo->pilotid, 1, PIREP_ACCEPTED);
                $curr_location = $_GET['icao'];
            }else{
                $last_location = PIREPData::getLastReports(Auth::$userinfo->pilotid, 1, PIREP_ACCEPTED);
                $curr_location = $last_location->arricao;
            }

            $url = 'https://www.aviationweather.gov/adds/dataserver_current/httpparam?dataSource=metars&requestType=retrieve&format=xml&stationString='.$curr_location.'&hoursBeforeNow=1.0';

            $xml = simplexml_load_file($url);

            $this->curr_location = $curr_location;
            $this->last_location = $last_location;

            $this->metar = $xml->data[0]->METAR->raw_text;
            $this->station_id = $xml->data[0]->METAR->station_id;
            $this->observation_time = $xml->data[0]->METAR->observation_time;
            $this->wind_dir_degrees = $xml->data[0]->METAR->wind_dir_degrees;
            $this->temp_c = $xml->data[0]->METAR->temp_c;
            $this->wind_speed_kt = $xml->data[0]->METAR->wind_speed_kt;
            $this->visibility_statute_mi = $xml->data[0]->METAR->visibility_statute_mi;
            $this->dewpoint_c = $xml->data[0]->METAR->dewpoint_c;
            $this->elevation_m = $xml->data[0]->METAR->elevation_m;
            $this->altim_bar = round(33.8639 * ($xml->data[0]->METAR->altim_in_hg), 0);

            $this->temp_f = ($this->temp_c * (9 / 5) ) + 32;
            $this->dewpoint_f = ($this->dewpoint_c * (9 / 5) ) + 32;

            $this->visibility_km = round($this->visibility_statute_mi * 0.621371, 2);

            $this->sk_cond = $xml->data->METAR->sky_condition;
        }

        /**
         * @return array|bool|unknown
         */
        private function getLastLocation()
        {
            return $this->last_location;
        }

        /**
         * @return mixed
         */
        private function getCurrLocation()
        {
            return $this->curr_location;
        }

        /**
         * @return SimpleXMLElement
         */
        private function getSkCond()
        {
            return $this->sk_cond;
        }

        /**
         * @return SimpleXMLElement
         */
        private function getMetar()
        {
            return $this->metar;
        }

        /**
         * @return SimpleXMLElement
         */
        private function getStationId()
        {
            return $this->station_id;
        }

        /**
         * @return SimpleXMLElement
         */
        private function getObservationTime()
        {
            return $this->observation_time;
        }

        /**
         * @return SimpleXMLElement
         */
        private function getWindDirDegrees()
        {
            return $this->wind_dir_degrees;
        }

        /**
         * @return SimpleXMLElement
         */
        private function getTempC()
        {
            return $this->temp_c;
        }

        /**
         * @return SimpleXMLElement
         */
        private function getWindSpeedKt()
        {
            return $this->wind_speed_kt;
        }

        /**
         * @return SimpleXMLElement
         */
        private function getVisibilityStatuteMi()
        {
            return $this->visibility_statute_mi;
        }

        /**
         * @return SimpleXMLElement
         */
        private function getDewpointC()
        {
            return $this->dewpoint_c;
        }

        /**
         * @return SimpleXMLElement
         */
        private function getElevationM()
        {
            return $this->elevation_m;
        }

        /**
         * @return float
         */
        private function getAltimBar()
        {
            return $this->altim_bar;
        }

        /**
         * @return float|int
         */
        private function getTempF()
        {
            return $this->temp_f;
        }

        /**
         * @return float|int
         */
        private function getDewpointF()
        {
            return $this->dewpoint_f;
        }

        /**
         * @return float
         */
        private function getVisibilityKm()
        {
            return $this->visibility_km;
        }

        public function chk_update(){
			
			$ver = 1.8; 
			$ver_actual = floatval(file_get_contents("https://www.dropbox.com/s/6cw52cf49idjz8t/InstantWeather_ver.txt?dl=1")); 

			if($ver_actual > $ver){
				echo ' | <a href="https://github.com/Karamellwuerfel/InstantWeather" target="_blank"><font color="red">new version '.$ver_actual.' available!</a></font>';
			}else{
				//nothing
			}
				
		}

		public function index(){

			$this->set('curr_location', $this->getCurrLocation());
			$this->set('last_location', $this->getLastLocation());
			$this->set('metar', $this->getMetar());
			$this->set('icao', $this->getStationId());
			$this->set('observation_time', $this->getObservationTime());
			$this->set('wind_dir_deg', $this->getWindDirDegrees());
			$this->set('wind_speed_kt', $this->getWindSpeedKt());
			$this->set('visibility_statute_mi', $this->getVisibilityStatuteMi());
			$this->set('elevation', $this->getElevationM());
			$this->set('altim_bar', $this->getAltimBar());

			if(TEMPERATURE == CELSIUS){
				$this->set('dewpoint', $this->getDewpointC());
				$this->set('temp', $this->getTempC());
				$this->set('temp_indicator', "&deg;C");
			}

			if(TEMPERATURE == FAHRENHEIT){
				$this->set('dewpoint', $this->getDewpointF());
				$this->set('temp', $this->getTempF());
				$this->set('temp_indicator', "&deg;F");
			}

			if(VISIBILITY == KILOMETERS){
				$this->set('visibility_decrypt', $this->getVisibilityKm() . " km");
			}else{
				$this->set('visibility_decrypt', $this->getVisibilityStatuteMi() . " miles");
			}

			$this->show('/instantweather/instantweather.php');
		}
			
		public function get_metar(){
			echo $this->getMetar();
		}
			
		public function sky_condition(){

            $sk_cond = $this->getSkCond();

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

        // MAINCONTROLLER FUNCTIONS

        public function metar(){
            echo $this->getMetar();
        }
        public function pressure(){
            echo $this->getAltimBar()." mbar";
        }
        public function wind_speed(){
            echo $this->getWindSpeedKt()." kts";
        }
        public function wind_degrees(){
            echo $this->getWindDirDegrees()."&deg;";
        }
        public function temperature(){
            if(TEMPERATURE == CELSIUS){
                echo $this->getTempC()." &deg;C";
            }

            if(TEMPERATURE == FAHRENHEIT){
                echo $this->getTempF()." &deg;F";
            }
        }
        public function dewpoint(){
            if(TEMPERATURE == CELSIUS){
                echo $this->getDewpointC()." &deg;C";
            }

            if(TEMPERATURE == FAHRENHEIT){
                echo $this->getDewpointF()." &deg;F";
            }
        }
        public function visibility(){
            if(VISIBILITY == KILOMETERS){
                echo $this->getVisibilityKm()." km";
            }else{
                echo $this->getVisibilityStatuteMi()." miles";
            }
        }
        public function skycondition(){
            $sk_cond = $this->getSkCond();

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


                    echo '<tr> <td class="fat">Sky condition level '.$i.'</td> <td>'.$skycover. ' ' . $cond->attributes()->{'cloud_base_ft_agl'}.' '. PHP_EOL .$skycover_uncrypt.'<br></td> </tr>';
                    $i++;
                }
            }
        }

	}
?>