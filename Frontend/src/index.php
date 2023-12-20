<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weer</title>
    <script src="https://unpkg.com/feather-icons"></script>
</head>

<body>

    <div class="container">
        <div class="weather-side">
            <div class="weather-gradient"></div>
            <div class="date-container">
                <h2 class="date-dayname"><?= date("l") ?></h2><span class="date-day"><?= date("d M Y") ?></span><i class="location-icon" data-feather="map-pin"></i><span class="location" id="location">----</span>
            </div>
            <div class="weather-container"><i class="weather-icon" id="feather"></i>
                <h1 class="weather-temp" id="temp">--°C</h1>
                <h3 class="weather-desc" id="condition">-----</h3>
            </div>
        </div>
        <div class="info-side">
            <div class="today-info-container">
                <div class="today-info">
                    <div class="precipitation"> <span class="title">PRECIPITATION</span><span class="value" id="precip">-mm</span>
                        <div class="clear"></div>
                    </div>
                    <div class="humidity"> <span class="title">HUMIDITY</span><span class="value" id="humid">--%</span>
                        <div class="clear"></div>
                    </div>
                    <div class="wind"> <span class="title">WIND</span><span class="value" id="wind">-km/h</span>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
            <div class="week-container">
                <ul class="week-list">
                    <li class="active"><i class="day-icon" data-feather="sun"></i><span class="day-name"><?= date("D", strtotime("+1 day")) ?></span><span class="day-temp" id="forecast1">--°C</span></li>
                    <li><i class="day-icon" data-feather="cloud"></i><span class="day-name"><?= date("D", strtotime("+2 days")) ?></span><span class="day-temp" id="forecast2">--°C</span></li>
                    <li><i class="day-icon" data-feather="cloud-snow"></i><span class="day-name"><?= date("D", strtotime("+3 days")) ?></span><span class="day-temp" id="forecast3">--°C</span></li>
                    <div class="clear"></div>
                </ul>
            </div>
            <div class="location-container">
                <button class="location-button" style="width:220px" onclick="getWeather()"> <i data-feather="refresh-cw"></i><span>Get Weather Data</span></button>
            </div>
        </div>
    </div>

    <script>
        feather.replace()
        var city = "<?= isset($_GET["location"])?$_GET["location"]:"Rotterdam" ?>";

        function getWeather() {
            fetch(`http://localhost:8089/api/weer.php?plaats=${city}`)
                .then(response => response.json())
                .then(data => displayWeatherData(data))
                .catch(error => {
            document.getElementById('condition').innerHTML = `ERROR`;
                    console.error('Error:', error)
                });
        }

        function displayWeatherData(data) {
            document.getElementById('precip').innerHTML = `${data.current.precip_mm}mm`;
            document.getElementById('humid').innerHTML = `${data.current.humidity}%`;
            document.getElementById('wind').innerHTML = `${data.current.wind_kph}km/h`;
            document.getElementById('location').innerHTML = `${data.location.name}`;
            document.getElementById('temp').innerHTML = `${data.current.temp_c}°C`;
            document.getElementById('condition').innerHTML = `${data.current.condition.text}`;
            document.getElementById('forecast1').innerHTML = `${data.current.temp_c}°C`;
            document.getElementById('forecast2').innerHTML = `${Math.floor(data.forecast.forecastday[1].day.avgtemp_c)}°C`;
            document.getElementById('forecast3').innerHTML = `${Math.floor(data.forecast.forecastday[2].day.avgtemp_c)}°C`;
            switch (data.current.condition.text) {
                case "Light rain":
                case "Moderate rain":
                    document.getElementById('feather').setAttribute("data-feather", "cloud-rain");

                    break;

                default:
                    document.getElementById('feather').setAttribute("data-feather", "sun");
                    break;
            }
            feather.replace()
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css?family=Montserrat:400,700,900&display=swap');

        :root {
            --gradient: linear-gradient(135deg, #72EDF2 10%, #5151E5 100%);
        }

        * {
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            line-height: 1.25em;
        }

        .clear {
            clear: both;
        }

        body {
            margin: 0;
            width: 100%;
            height: 100vh;
            font-family: 'Montserrat', sans-serif;
            background-color: #343d4b;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
        }

        .container {
            border-radius: 25px;
            -webkit-box-shadow: 0 0 70px -10px rgba(0, 0, 0, 0.2);
            box-shadow: 0 0 70px -10px rgba(0, 0, 0, 0.2);
            background-color: #222831;
            color: #ffffff;
            height: 400px;
        }

        .weather-side {
            position: relative;
            height: 100%;
            border-radius: 25px;
            background-image: url("https://images.unsplash.com/photo-1559963110-71b394e7494d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=675&q=80");
            width: 300px;
            -webkit-box-shadow: 0 0 20px -10px rgba(0, 0, 0, 0.2);
            box-shadow: 0 0 20px -10px rgba(0, 0, 0, 0.2);
            -webkit-transition: -webkit-transform 300ms ease;
            transition: -webkit-transform 300ms ease;
            -o-transition: transform 300ms ease;
            transition: transform 300ms ease;
            transition: transform 300ms ease, -webkit-transform 300ms ease;
            -webkit-transform: translateZ(0) scale(1.02) perspective(1000px);
            transform: translateZ(0) scale(1.02) perspective(1000px);
            float: left;
        }

        .weather-side:hover {
            -webkit-transform: scale(1.1) perspective(1500px) rotateY(10deg);
            transform: scale(1.1) perspective(1500px) rotateY(10deg);
        }

        .weather-gradient {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            background-image: var(--gradient);
            border-radius: 25px;
            opacity: 0.8;
        }

        .date-container {
            position: absolute;
            top: 25px;
            left: 25px;
        }

        .date-dayname {
            margin: 0;
        }

        .date-day {
            display: block;
        }

        .location {
            display: inline-block;
            margin-top: 10px;
        }

        .location-icon {
            display: inline-block;
            height: 0.8em;
            width: auto;
            margin-right: 5px;
        }

        .weather-container {
            position: absolute;
            bottom: 25px;
            left: 25px;
        }

        .weather-icon.feather {
            height: 60px;
            width: auto;
        }

        .weather-temp {
            margin: 0;
            font-weight: 700;
            font-size: 4em;
        }

        .weather-desc {
            margin: 0;
        }

        .info-side {
            position: relative;
            float: left;
            height: 100%;
            padding-top: 25px;
        }

        .today-info {
            padding: 15px;
            margin: 0 25px 25px 25px;
            /* 	box-shadow: 0 0 50px -5px rgba(0, 0, 0, 0.25); */
            border-radius: 10px;
        }

        .today-info>div:not(:last-child) {
            margin: 0 0 10px 0;
        }

        .today-info>div .title {
            float: left;
            font-weight: 700;
        }

        .today-info>div .value {
            float: right;
        }

        .week-list {
            list-style-type: none;
            padding: 0;
            margin: 10px 50px;
            -webkit-box-shadow: 0 0 50px -5px rgba(0, 0, 0, 0.25);
            box-shadow: 0 0 50px -5px rgba(0, 0, 0, 0.25);
            border-radius: 10px;
        }

        .week-list>li {
            float: left;
            padding: 15px;
            cursor: pointer;
            -webkit-transition: 200ms ease;
            -o-transition: 200ms ease;
            transition: 200ms ease;
            border-radius: 10px;
        }

        .week-list>li:hover {
            -webkit-transform: scale(1.1);
            -ms-transform: scale(1.1);
            transform: scale(1.1);
            background: #fff;
            color: #222831;
            -webkit-box-shadow: 0 0 40px -5px rgba(0, 0, 0, 0.2);
            box-shadow: 0 0 40px -5px rgba(0, 0, 0, 0.2)
        }

        .week-list>li.active {
            background: #fff;
            color: #222831;
            border-radius: 10px;
        }

        .week-list>li .day-name {
            display: block;
            margin: 10px 0 0 0;
            text-align: center;
        }

        .week-list>li .day-icon {
            display: block;
            height: 30px;
            width: auto;
            margin: 0 auto;
        }

        .week-list>li .day-temp {
            display: block;
            text-align: center;
            margin: 10px 0 0 0;
            font-weight: 700;
        }

        .location-container {
            padding: 25px 35px;
        }

        .location-button {
            outline: none;
            width: 100%;
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            border: none;
            border-radius: 25px;
            padding: 10px;
            font-family: 'Montserrat', sans-serif;
            background-image: var(--gradient);
            color: #ffffff;
            font-weight: 700;
            -webkit-box-shadow: 0 0 30px -5px rgba(0, 0, 0, 0.25);
            box-shadow: 0 0 30px -5px rgba(0, 0, 0, 0.25);
            cursor: pointer;
            -webkit-transition: -webkit-transform 200ms ease;
            transition: -webkit-transform 200ms ease;
            -o-transition: transform 200ms ease;
            transition: transform 200ms ease;
            transition: transform 200ms ease, -webkit-transform 200ms ease;
        }

        .location-button:hover {
            -webkit-transform: scale(0.95);
            -ms-transform: scale(0.95);
            transform: scale(0.95);
        }

        .location-button .feather {
            height: 1em;
            width: auto;
            margin-right: 5px;
        }
    </style>
</body>

</html>