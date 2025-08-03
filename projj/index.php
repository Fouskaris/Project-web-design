<html>
  <head>
  <title>Σύστημα Υποστήριξης Διπλωματικών Εργασιών Πανεπηστιμίου Πατρών</title>
    <img src="upatrasLogo.jpg" alt="Centered Image" style="display: block; margin:  50px auto; width: 40em;">
    <style>
      
.button1 {
  padding: 0.5em;
  margin:2em auto;
  display:block;
  width: 50%;
  border-radius: 5px;
  border: none;
  outline: none;
  transition: .4s ease-in-out;
  background-color: #252525;
  color: white;
  font-size: 2em;
}

.button1:hover {
  background-color: black;
  color: white;
}
    </style>
  </head>
<body>
    <form class="form" method="POST" action="loginScr.php">
        <div class="btn">
        <button class="button1">Σύνδεση στο Σύστημα Υποστήριξης Διπλωματικών Εργασιών</button>
        </div>       
    </form>
</body>
<?php
/*
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