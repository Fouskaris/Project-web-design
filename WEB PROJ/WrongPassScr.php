<html>
<head>
    <title>Σύστημα Υποστήριξης Διπλωματικών Εργασιών Πανεπηστιμίου Πατρών</title>
    <img src="upatrasLogo.jpg" alt="Centered Image" style="display: block; margin:  50px auto; width: 20em;">
    <hr style="border: 1px solid black; width: 50%;">
<style>
    .form .btn {
  display: flex;
  justify-content: center;
  flex-direction: row;
  margin-top: 1em;
}

.button1 {
  padding: 0.5em;
  margin:auto;
  width:10%;
  border-radius: 5px;
  border: none;
  outline: none;
  transition: .4s ease-in-out;
  background-color: #252525;
  color: white;
}

.button1:hover {
  background-color: black;
  color: white;
}
.form {
  display: flex;
  flex-direction: column;
  gap: 10px;
  padding-left: 2em;
  padding-right: 2em;
  padding-bottom: 0.4em;
  background-color: white;
  border-radius: 10px;
  
}


#heading, #heading1 {
  text-align: center;
  color: black;
  font-size: 1em;
}

#heading1{
    font-size: 2em;
    color:red;
}

</style>
</head>
<body>
    <form class="form" method="POST" action="loginScr.php">
        <p id="heading1">Παρουσιάστηκε σφάλμα</p>
        <p id="heading">Λάθος συμπλήρωση φόρμας ή λάθος κωδικός</p>    
        <div class="btn">
        <button class="button1" type="submit">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Σύνδεση&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
        </div>
    </form>
</body>

</html>