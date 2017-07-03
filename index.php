<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Local Weather application</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">

    <!-- Weather icons -->
    <link href="css/weather-icons.min.css" rel="stylesheet">

    <!-- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>

    <!-- CSS -->
    <link rel="stylesheet" media="screen" href="css/styles.css">
  </head>
  <body>
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-4 offset-sm-4 col-xs-10 offset-xs-1">

          <div class="row">
            <div class="col-xs-12 col-md-12 text-right">
              <div id="country"></div>
              <div id="city"></div>
            </div>
          </div>

          <div class="row">
            <div class="col-2 text-left">
              <div id="temp-icon" class="text-center"><i class="wi wi-thermometer-internal"></i></div>
            </div>
            <div class="col-4 text-center">
              <div class="temperature" id="temperatureFahrenheit"></div>
              <div class="temperature" id="temperatureCelsius"></div>
            </div>
            <div class="col-6 text-center">
              <div id="weather-main-icon" class="text-center"></div>
            </div>
          </div>

          <div class="row">
            <div class="col-2 text-center">
              <div id="temp-min-icon"><i class="wi wi-thermometer-exterior"></i></div>
            </div>
            <div class="col-4 text-center">
              <div class="temperature" id="temp-min-value"></div>
            </div>
            <div class="col-2 text-center">
              <div id="temp-max-icon"><i class="wi wi-thermometer"></i></div>
            </div>
            <div class="col-4 text-center">
              <div class="temperature" id="temp-max-value"></div>
            </div>
          </div>


          <div class="row">
            <div class="col-2 text-center">
              <div id="barometer-icon"><i class="wi wi-barometer"></i></div>
            </div>
            <div class="col-4 text-center">
              <div class="pressure" id="pressure-value"></div>
            </div>
            <div class="col-2 text-center">
              <div id="humidity-icon"><i class="wi wi-humidity"></i></div>
            </div>
            <div class="col-4 text-center">
              <div class="humidity" id="humidity-value"></div>
            </div>
          </div>

          <div class="row">
            <div class="col-2 text-center">
              <div id="sunrise-icon"><i class="wi wi-sunrise"></i></div>
            </div>
            <div class="col-4 text-center">
              <div class="sunrise-time" id="pressure-value"></div>
            </div>
            <div class="col-2 text-center">
              <div id="sunset-icon"><i class="wi wi-sunset"></i></div>
            </div>
            <div class="col-4 text-center">
              <div class="sunset-time" id="humidity-value"></div>
            </div>
          </div>



        </div>
      </div>
    </div>
  </body>

<script>
$(document).ready(function(){
  var city, lat, lon;

  //GET THE COORDINATED BY IP ADDRESS
  $.ajax({
    url: 'http://ip-api.com/json',
    type: 'get',
    dataType: 'json',
    success: function(ipJSON){
      city = ipJSON['city'];
      lat = ipJSON['lat'];
      lon = ipJSON['lon'];

      $.ajax({
        url: 'http://api.openweathermap.org/data/2.5/weather?lat='+lat+'&lon='+lon+'&appid=09a226cc5591be341cb1a725108c4689',
        type: 'get',
        dataType: 'json',
        success: function(weatherJSON){

        //Determine location
          $('#country').html(ipJSON.country);
          $('#city').html(weatherJSON.name);

        //Determine the temperature
          var kelvinValue = weatherJSON.main.temp;
          var kelvin = 273.15;
          var celsiusValue = kelvinValue - kelvin;

          $('#temperatureFahrenheit').html(celsiusValue.toFixed(1)+"<i class='wi wi-celsius'></i>");

          var fahrenheitValue = (celsiusValue)*9/5+32;
          $('#temperatureCelsius').html(fahrenheitValue.toFixed(1)+"<i class='wi wi-fahrenheit'></i>").hide();


        //Determine the min temperature
          var tempMinCelsiusValue = weatherJSON.main.temp_min - kelvin;
          $('#temp-min-value').html(tempMinCelsiusValue.toFixed(1)+"<i class='wi wi-celsius'></i>");

        //Determine the max temperature
          var tempMaxCelsiusValue = weatherJSON.main.temp_max -kelvin;
          $('#temp-max-value').html(tempMaxCelsiusValue.toFixed(1)+"<i class='wi wi-celsius'></i>");

        //Changing main weather icon
          var weatherIcon;
          var weatherId = weatherJSON.weather[0]['id'];
          var weatherIdGroup = Math.floor(weatherId/100);

          switch (true){
            case (weatherId > 199 && weatherId < 233):
                  weatherIcon = "<i class='wi wi-thunderstorm'></i>";
                  $('body').css('background-image', 'url(images/cloud-cloudy.jpg)');
                  break;
            case (weatherId > 299 && weatherId < 323):
                  weatherIcon = "<i class='wi wi-showers'></i>";
                  break;
            case (weatherId > 499 && weatherId < 533):
                  weatherIcon = "<i class='wi wi-rain'></i>";
                  $('body').css('background-image', 'url(images/rainy.jpg)');
                  break;
            case (weatherId > 599 && weatherId < 623):
                  weatherIcon = "<i class='wi wi-snow'></i>";
                  $('body').css('background-image', 'url(images/snow.jpg)');
                  break;
            case (weatherId === 800):
                  weatherIcon = "<i class='wi wi-day-sunny'></i>";
                  if (celsiusValue > 35) {
                    $('body').css('background-image', 'url(images/desert.jpg)');
                  } else {
                    $('body').css('background-image', 'url(images/cold-sunny.jpg)');
                  }
                  break;
            case (weatherId > 800 && weatherId < 805):
                  weatherIcon = "<i class='wi wi-cloud'></i>";
                  $('body').css('background-image', 'url(images/warm-cloudy.jpg)');
                  break;
            default:
                    weatherIcon = "?";
          }
          $('#weather-main-icon').html(weatherIcon);
          $('#humidity-value').html(weatherJSON.main.humidity+" %");
          $('#pressure-value').html(weatherJSON.main.pressure+" Pa");

        }
      });
    }
  });
  //Changing the F to C
  $('.temperature').on('click', function(){
    $('.temperature').toggle();
  });



});
</script>
</html>
