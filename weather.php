<?php 
<?php 
$error = '';
$weather_enq = ''; // Initialize $weather_enq to avoid "Undefined variable" notice

if (isset($_GET['submit'])) {
    if (empty($_GET['city'])) {
        $error = "Sorry: Please enter your city name";
    } else {
        $location = $_GET['city'];
        $apiKey = '65a87bad5f8226436765d11e239a51bf';
        $apiUrl = "https://api.openweathermap.org/data/2.5/weather?q={$location}&appid={$apiKey}";
        $response = file_get_contents($apiUrl);
        $weatherData = json_decode($response, true);
        
        if ($weatherData['cod'] == 200) {
            $weather_cont = "<b>City name:</b> " . $weatherData['name'] . " (" . $weatherData['sys']['country'] . ")";
            $temp_celsius = $weatherData['main']['temp'] - 273.15; // Convert temperature from Kelvin to Celsius
            $weather_temp = "<b>The temperature is:</b> " . intval($temp_celsius) . '<b>&deg;C</b>';
            $weather_atm = "<b>Atmospheric pressure:</b> " . $weatherData['main']['pressure'] . " hPa";
            $weather_enq = "<b>Weather Condition:</b> " . $weatherData['weather'][0]['description'];
            $weather_speed = "<b>Wind Speed:</b> " . $weatherData['wind']['speed'] . " meter/sec";
            $weather_cloud = "<b>Cloudiness:</b> " . $weatherData['clouds']['all'] . "%";
            date_default_timezone_set('Asia/Kolkata');
            $weather_sun = $weatherData['sys']['sunrise'];
            $weather_suns = $weatherData['sys']['sunset'];
            $weather_sunrise = "<b>Sunrise:</b> " . date('l, jS F Y h:i:s A', $weather_sun);
            $weather_sunset = "<b>Sunset:</b> " . date('l, jS F Y h:i:s A', $weather_suns);
        } else {
            $error = "City not found. Please enter a valid city name";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather App in PHP for Beginners</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background-image: url('https://images.pexels.com/photos/10997477/pexels-photo-10997477.jpeg?auto=compress&cs=tinysrgb&w=600&lazy=load');
            background-size: cover;
            background-position: center;
            height: 100vh; 
            margin: 0; 
            padding: 0;
            font-family: Arial, sans-serif;
        }
    </style>
</head>
<body>
    <h2 class="text-center text-primary mt-5">Weather App</h2>
    <div class="container w-50">
        <form action="" method="GET">
            <label for="city" class="form-label">City</label>
            <input type="text" name="city" class="form-control" id="city" placeholder="Enter your city" value="<?php if(isset($_GET['city'])) echo $_GET['city']; ?>"> <br>
            <input type="submit" class="btn btn-success" name="submit" value="Search">
        </form>
    </div>
    <div class="container mt-3">
        <?php if($error !== ''): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error; ?>
            </div>
        <?php elseif($weather_enq !== ''): ?>
            <div class="alert alert-success text-center" role="alert">
                <p><?php echo $weather_cont; ?></p>
                <p><?php echo $weather_enq; ?></p>
                <p><?php echo $weather_temp; ?></p>
                <p><?php echo $weather_atm; ?></p>
                <p><?php echo $weather_speed; ?></p>
                <p><?php echo $weather_cloud; ?></p>
                <p><?php echo $weather_sunrise; ?></p>
                <p><?php echo $weather_sunset; ?></p>
            </div>
        <?php endif; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>
