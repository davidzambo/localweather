$('#loadingMessage').show();
$('.content').hide();

var navigator = window.navigator;
var localTemperature = {};

function geoNotAllowed(){
	$('#loadingMessage').html('<h1 class="text-center">Geolocation is not available in your browser.</h1>');
}


function setWeather(weather){
	localTemperature = {
		kelvin : weather.main.temp,
		celsius : parseInt((weather.main.temp - 273.15)*100)/100,
		fahrenheit : parseInt(((weather.main.temp-273.15)*9/5+32)*100)/100
	}

	let weatherIcon,
			weatherId = weather.weather[0].id;

  $('#city').html(weather.name);
	$('#temperatureFahrenheit').html(localTemperature.celsius+"<i class='primary-degree wi wi-celsius'></i><i class='secondary-degree wi wi-fahrenheit'></i>");
  $('#temperatureCelsius').html(localTemperature.fahrenheit+"<i class='primary-degree wi wi-fahrenheit'></i><i class='secondary-degree wi wi-celsius'>").hide();

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
      case (weatherId > 699 && weatherId < 782):
            weatherIcon = "<i class='wi wi-fog'></i>";
            $('body').css('background-image', 'url(images/foggy.jpg)');
            break;

      case (weatherId === 800):
            weatherIcon = "<i class='wi wi-day-sunny'></i>";
            if (localTemperature.celsius > 35) {
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
            weatherIcon = "<i class='wi wi-na'></i>";
            $('body').css('background-color', 'white');
   }

  $('#weather-main-icon').html(weatherIcon);

  //Get and set daytime
  var daytime = new Date(weather.dt*1000);
  $('#daytime-value').html(nice(daytime.getHours())+":"+nice(daytime.getMinutes()));

  $('#humidity-value').html(weather.main.humidity+" %");
  $('#pressure-value').html(weather.main.pressure+" Pa");

  //Get and set sunrise and sunset time
  var sunrise = new Date(weather.sys.sunrise*1000);
  var sunset = new Date(weather.sys.sunset*1000);

  $('#sunrise-time').html(nice(sunrise.getHours())+":"+nice(sunrise.getMinutes()));
  $('#sunset-time').html(nice(sunset.getHours())+":"+nice(sunset.getMinutes()));

  //Set night background-image
  if (daytime > sunset){
    $('body').css('background-image', 'url(images/night.jpg)');
  }

  $('#loadingMessage').hide().addClass('animated fadeOut');
  $('.content').show().addClass('animated fadeInDownBig');
	
}


function getWeather(obj){
	$.ajax({
    url: 'https://api.openweathermap.org/data/2.5/weather?lat='+obj.latitude+'&lon='+obj.longitude+'&appid=09a226cc5591be341cb1a725108c4689',
    type: 'get',
    dataType: 'json',
    success: function(response){
    	setWeather(response);
    }
	});
}


function getLocation(callback){
	navigator.geolocation.getCurrentPosition(function(position){
		let coords = position.coords;
		if (typeof callback === 'function'){
			callback(coords);
		} else {
			alert('Callback is not a function');
		}
	}, geoNotAllowed);
}


function nice(number){
  if (number < 10){
    return "0"+number;
  }
  return number;
}

//Changing the F to C
$('.temperature').on('click', function(){
  $('.temperature').toggle().addClass('animated flipInX');
});


try{
	getLocation(getWeather);
} catch (e){
	alert(e);
}