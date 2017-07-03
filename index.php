<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Local Weather application</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">

    <!-- Font Awesome -->
    <script src="https://use.fontawesome.com/14c79cd15d.js"></script>

    <!-- Weather icons -->
    <link href="css/weather-icons.min.css" rel="stylesheet">

    <!-- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>

    <!-- CSS -->
    <link rel="stylesheet" media="screen" href="css/styles.css">

    <!-- Animate CSS -->
    <link rel="stylesheet" href="css/animate.css">
  </head>
  <body>
    <div id="loadingMessage" style="display:none">
      <i class="fa fa-spinner fa-pulse fa-4x"></i><br><br>
      <span class="sr-only">Loading...</span>
      <span>Loading...</span>
    </div>
    <div class="container-fluid">
      <div class="row content">
        <div class="col-md-4 offset-sm-4 col-xs-10 offset-xs-1">

          <div class="row">
            <div class="col-xs-12 col-md-12 text-right">
              <div id="country"></div>
            </div>
          </div>
          <div class="row">
            <div class="col-4">
              <div id="weather-main-icon" class="text-center"></div>
            </div>
            <div class="col-8">
              <div id="city"></div>
            </div>
          </div>

          <div class="row" id="temperature">
            <div class="col-2 text-left">
              <div id="temp-icon" class="text-center"><i class="wi wi-thermometer-internal"></i></div>
            </div>
            <div class="col-4 text-center">
              <div class="temperature" id="temperatureFahrenheit"></div>
              <div class="temperature" id="temperatureCelsius"></div>
            </div>
            <div class="col-2 text-center">
              <div id="daytime-icon"><i class="wi wi-time-3"></i></div>
            </div>
            <div class="col-4 text-center">
              <div id="daytime-value"></div>
            </div>
          </div>

          <div class="row" id="pressureAndHumidity">
            <div class="col-2 text-center">
              <div id="barometer-icon"><i class="wi wi-barometer"></i></div>
            </div>
            <div class="col-4 text-center pressure-container">
              <div class="pressure" id="pressure-value"></div>
            </div>
            <div class="col-2 text-center">
              <div id="humidity-icon"><i class="wi wi-humidity"></i></div>
            </div>
            <div class="col-4 text-center">
              <div class="humidity" id="humidity-value"></div>
            </div>
          </div>

          <div class="row" id="sunriseAndSunset">
            <div class="col-2 text-center">
              <div id="sunrise-icon"><i class="wi wi-sunrise"></i></div>
            </div>
            <div class="col-4 text-center">
              <div class="sunrise-time" id="sunrise-time"></div>
            </div>
            <div class="col-2 text-center">
              <div id="sunset-icon"><i class="wi wi-sunset"></i></div>
            </div>
            <div class="col-4 text-center">
              <div class="sunset-time" id="sunset-time"></div>
            </div>
          </div>



        </div>
      </div>
    </div>
  </body>

<script>
$(document).ready(function(){
  $('#loadingMessage').show();
  $('.content').hide();
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
        //Get and set daytime
          function addZero(number){
            if (number < 10){
              return "0"+number;
            }
            return number;
          }
          var daytime = new Date(weatherJSON.dt*1000);
          $('#daytime-value').html(addZero(daytime.getHours())+":"+addZero(daytime.getMinutes()));

          $('#humidity-value').html(weatherJSON.main.humidity+" %");
          $('#pressure-value').html(weatherJSON.main.pressure+" Pa");

        //Get and set sunrise and sunset time
          var sunrise = new Date(weatherJSON.sys.sunrise*1000);
          var sunset = new Date(weatherJSON.sys.sunset*1000);

          $('#sunrise-time').html(addZero(sunrise.getHours())+":"+addZero(sunrise.getMinutes()));
          $('#sunset-time').html(addZero(sunset.getHours())+":"+addZero(sunset.getMinutes()));

          $('#loadingMessage').hide().addClass('animated fadeOut');
          $('.content').show().addClass('animated fadeInDownBig');
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
