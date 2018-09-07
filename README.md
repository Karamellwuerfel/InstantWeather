# InstantWeather
[![Badges](http://img.shields.io/:Version-1.9-fe7d37.svg)](https://github.com/Karamellwuerfel/InstantWeather)

http://forum.phpvms.net/topic/24355-simple-instantweather-module/

Hey guys! I've made a weather module that shows you real time and 

instant weather informations of the current airport where the logged in pilot is.

DEMO VIDEO: [(www.youtube.com/watch?v=Cx0HCaW-a5I)]

# INSTALLATION

1. Copy the "core/modules/InstantWeather"-folder into your "core/modules"-folder of your va

2. Copy the "core/templates/instantweather"-folder into your "core/templates"-folder of your va

3. To show the modulein the navigation:&lt;li&gt;&lt;a href="&lt;?php echo url('/instantweather'); ?&gt;"&gt;InstantWeather&lt;/a&gt;&lt;/li&gt;


(Tested on PHPVMS Version simpilot 5.5.2)

# OPTIMIZATION

You can change the displayed value indicator of the temperature now (with Update v1.3).
To change between FAHRENHEIT and CELSIUS do the following:

1. Go to the file "core/modules/InstantWeather/InstantWeather.php"

2. Change the variable value in line 12 to "c" for celsius or "f" for fahrenheit

Example:

```PHP
define("TEMPERATURE", "c"); // shows temperature in CELSIUS
```

```PHP
define("TEMPERATURE", "f"); // shows temperature in FAHRENHEIT
```

---

You can change the displayed value indicator of the visibility now (with Update v1.6).
To change between MILES and KILOMETERS do the following:

1. Go to the file "core/modules/InstantWeather/InstantWeather.php"

2. Change the variable value in line 13 to "m" for miles or "k" for kilometers

Example:

```PHP
define("VISIBILITY", "m"); // shows visibility in MILES
```

```PHP
define("VISIBILITY", "k"); // shows visibility in KILOMETERS
```

### MANUALLY SET ICAO

1. To set manually an icao (airport) you have to add a get request via php. Do it like this:
   Add at the end of the InstantWeather URL "?icao=ICAO_HERE" like this example: http://phpvms.philippdalheimer.de/index.php/instantweather?icao=edfh
   
### USE INFORMATION ON OTHER PAGES (v 1.9)
Use MainController::Run to display all different information of the table on other pages.
Available functions:
```PHP
<?php MainController::Run('InstantWeather', 'metar'); ?>        // example: EDDS 070920Z 26004KT 230V300 9999 FEW012 SCT025 BKN068 18/16 Q1015 NOSIG
<?php MainController::Run('InstantWeather', 'pressure'); ?>     // example: 982 mbar
<?php MainController::Run('InstantWeather', 'wind_speed'); ?>   // example: 4 kts
<?php MainController::Run('InstantWeather', 'wind_degrees'); ?> // example: 260°
<?php MainController::Run('InstantWeather', 'temperature'); ?>  // example: 18.0 °C
<?php MainController::Run('InstantWeather', 'dewpoint'); ?>     // example: 16.0 °C
<?php MainController::Run('InstantWeather', 'visibility'); ?>   // example: 6.21 mile

<?php MainController::Run('InstantWeather', 'skycondition'); ?> 
/* example: Sky condition level 1 FEW 1200 ft 
            Sky condition level 2 SCT 2500 ft (Scattered)
            Sky condition level 3 BKN 6800 ft (Broken)
*/
```

