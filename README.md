# InstantWeather
[![Badges](http://img.shields.io/:Version-1.8-fe7d37.svg)](https://github.com/Karamellwuerfel/InstantWeather)

http://forum.phpvms.net/topic/24355-simple-instantweather-module/

Hey guys! I've made a Weather module that shows you real time and 

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

2. Change the variable value in line 24 to "c" for celsius or "f" for fahrenheit

Example:

```PHP
$TEMPERATURE = "c"; // shows the temperature in celsius
```

```PHP
$TEMPERATURE = "f"; // shows the temperature in fahrenheit
```

---

You can change the displayed value indicator of the visibility now (with Update v1.6).
To change between MILES and KILOMETERS do the following:

1. Go to the file "core/modules/InstantWeather/InstantWeather.php"

2. Change the variable value in line 25 to "m" for miles or "k" for kilometers

Example:

```PHP
$VISIBILITY = "m"; // shows the visibility in miles
```

```PHP
$VISIBILITY = "k"; // shows the visibility in kilometers
```

### MANUALLY SET ICAO

1. To set manually an icao (airport) you have to add a get request via php. Do it like this:
   Add at the end of the InstantWeather URL "?icao=ICAO_HERE" like this example: http://phpvms.philippdalheimer.de/index.php/instantweather?icao=edfh