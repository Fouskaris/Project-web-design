<!DOCTYPE html>
<html lang="el">
<head>
  <meta charset="UTF-8">
  <title>Σύστημα Υποστήριξης Διπλωματικών Εργασιών Πανεπιστημίου Πατρών</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      text-align: center;
    }

    img {
      display: block;
      margin: 50px auto;
      width: 40em;
      max-width: 90%;
      height: auto;
    }

    .button1 {
      padding: 0.7em;
      margin: 2em auto;
      display: block;
      width: 60%;
      max-width: 500px;
      border-radius: 8px;
      border: none;
      outline: none;
      transition: .3s ease-in-out;
      background-color: #252525;
      color: white;
      font-size: 1.5em;
      text-align: center;
      cursor: pointer;
    }

    .button1:hover {
      background-color: black;
      color: white;
    }

    /* Responsive για κινητά */
    @media (max-width: 768px) {
      .button1 {
        width: 90%;
        font-size: 1.2em;
      }
    }
  </style>
</head>
<body>
  <img src="upatrasLogo.jpg" alt="Centered Image">

  <form class="form" method="POST" action="loginScr.php">
    <div class="btn">
      <button class="button1">Σύνδεση στο Σύστημα Υποστήριξης Διπλωματικών Εργασιών</button>
    </div>       
  </form>
</body>

<?php /*
$jsonFile = 'export.json';
$jsonData = file_get_contents($jsonFile);

$data = json_decode($jsonData, true);

if (isset($data['professors']) && is_array($data['professors'])) {
    foreach ($data['professors'] as &$professor) {
        if (!isset($professor['notifications'])) {
            $professor['notifications'] = []; 
        }
    }

    file_put_contents($jsonFile, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    echo "Notifications success";
} else {
    echo "fail";
}*/
?>

</html>
