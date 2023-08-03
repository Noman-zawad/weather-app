<?php


$url = "https://api.openweathermap.org/data/2.5/forecast?id=524901&appid=b85c73a205ea8927234a1a985ab54b7f&units=metric";


$contents = file_get_contents($url);

if($contents ===false ){
    echo"faild to fetch";
}else{
    
    $weather_data = json_decode($contents);
}


// Assuming you have the weather data in $weather_data variable
// $weather_data = ... (API response from OpenWeatherMap)

// Group the weather data by date
        $groupedData = array();
    foreach ($weather_data->list as $item) {
        $date = date('Y-m-d', $item->dt);
        if (!isset($groupedData[$date])) {
            $groupedData[$date] = array();
        }
        $groupedData[$date][] = $item;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather App</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <!-- Add your CSS styling here -->
</head>
<body class="container d-flex justify-content-center flex-column align-items-center">
    <?php
    // Iterate over the grouped data for each day
    foreach ($groupedData as $date => $dayData) {
        echo '<div class="weather-card">';
        echo '<h2>' . $date . '</h2>';
        echo '<div class="row">';
        foreach ($dayData as $item) {
            $time = date('H:i:s', $item->dt);
            $weather = $item->weather[0]->description;
            $temp = $item->main->temp;
            $feels_like = $item->main->feels_like;
            $weather_icon = $item->weather[0]->icon; // Weather icon code

            echo '<div class="col-md-4">';
            echo '<div class="hourly-data">';
            echo '<h3>' . $time . '</h3>';
            echo '<img class="weather-icon" src="http://openweathermap.org/img/wn/' . $weather_icon . '.png" alt="Weather Icon">';
            echo '<p>' . $weather . '</p>';
            echo '<p>Temperature: ' . $temp . '°C</p>';
            echo '<p>Feels Like: ' . $feels_like . '°C</p>';
            echo '</div>';
            echo '</div>';
        }
        echo '</div>'; // End of row
        echo '</div>'; // End of weather-card
    }
    ?>
</body>
</html>
