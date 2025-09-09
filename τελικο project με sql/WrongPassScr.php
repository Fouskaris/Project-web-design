<html>
<head>
    <title>Σύστημα Υποστήριξης Διπλωματικών Εργασιών Πανεπιστημίου Πατρών</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <img src="upatrasLogo.jpg" alt="Centered Image" style="display: block; margin: 50px auto; width: 20em; max-width: 80%;">
    <hr style="border: 1px solid black; width: 50%; max-width: 90%;">
<style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background-color: #f9f9f9;
    }

    .form .btn {
        display: flex;
        justify-content: center;
        flex-direction: row;
        margin-top: 1em;
    }

    .button1 {
        padding: 0.6em 1.2em;
        margin: auto;
        min-width: 120px;
        border-radius: 5px;
        border: none;
        outline: none;
        transition: .4s ease-in-out;
        background-color: #252525;
        color: white;
        font-size: 1em;
        cursor: pointer;
    }

    .button1:hover {
        background-color: black;
        color: white;
    }

    .form {
        display: flex;
        flex-direction: column;
        gap: 10px;
        padding: 1.5em;
        background-color: white;
        border-radius: 10px;
        max-width: 400px;
        margin: 20px auto;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    #heading, #heading1 {
        text-align: center;
        color: black;
        font-size: 1em;
    }

    #heading1 {
        font-size: 1.8em;
        color: red;
    }

    /* Responsiveness */
    @media (max-width: 600px) {
        img {
            width: 70%;
        }

        .form {
            width: 90%;
            padding: 1em;
        }

        .button1 {
            width: 100%;
            font-size: 1em;
        }

        #heading1 {
            font-size: 1.5em;
        }
    }
</style>
</head>
<body>
    <form class="form" method="POST" action="loginScr.php">
        <p id="heading1">Παρουσιάστηκε σφάλμα</p>
        <p id="heading">Λάθος συμπλήρωση φόρμας ή λάθος κωδικός</p>    
        <div class="btn">
            <button class="button1" type="submit">Σύνδεση</button>
        </div>
    </form>
</body>
</html>
