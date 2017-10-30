<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Local Weather application</title>

    <link rel="shortcut icon" href="https://www.dcmf.hu/favicon.jpg" type="image/x-icon"/> 

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">

    <!-- Font Awesome -->
    <script src="https://use.fontawesome.com/14c79cd15d.js"></script>

    <!-- Weather icons -->
    <link href="css/weather-icons.min.css" rel="stylesheet">

    <!-- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <!-- Tether.io -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/css/tether.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.js"></script>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="css/styles.css">

    <!-- Animate CSS -->
    <link rel="stylesheet" href="css/animate.css">
  </head>
  <body>

    <div class="container-fluid" id="loadingMessage">
      <h1><i class="fa fa-spinner fa-pulse fa-2x"></i>
</h1>
      <span class="sr-only">Loading...</span>
      <h3>Loading...</h3>
    </div>
    
    <div class="container-fluid">
      <div class="row content" style="display:none">
        <div class="col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3">

          <div class="row">
            <div class="col-xs-12 col-md-12 text-right">
              <div id="country"></div>
            </div>
          </div>
          <div class="row city-container">
            <div class="col-4">
              <div id="weather-main-icon" class="text-center"></div>
            </div>
            <div class="col-8">
              <div id="city" class="text-right"></div>
            </div>
          </div>

          <div class="row" id="temperature">
            <div class="col-2 text-left">
              <div id="temp-icon" class="text-center"><i class="wi wi-thermometer"></i></div>
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
    <footer class="copyright">Written and coded by <a href="https://www.dcmf.hu"><img class="dcmf-logo" src="images/dcmf-letters.png" alt="David's Code ManuFactory logo"/></a>
    </footer>
  </body>

  <script src="js/scripts.js"></script>

</html>
