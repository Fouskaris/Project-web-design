<!DOCTYPE html>
<html lang="el">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Σύστημα Υποστήριξης Διπλωματικών Εργασιών Πανεπιστημίου Πατρών</title>

  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      text-align: center;
      background-color: #f9f9f9;
    }

    img {
      display: block;
      margin: 30px auto;
      width: 20em;
      max-width: 90%;
      height: auto;
    }

    hr {
      border: 1px solid black;
      width: 50%;
      max-width: 90%;
      margin: auto;
    }

    .form {
      display: flex;
      flex-direction: column;
      gap: 10px;
      padding: 1em;
      margin: 1em auto;
      background-color: white;
      border-radius: 10px;
      max-width: 450px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      align-items: center;
    }

    #heading {
      text-align: center;
      margin: 1.5em 0;
      color: black;
      font-size: 1.7em;
    }

    .field {
      width: 17em;
      max-width: 90%;
      height: 2.3em;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.5em;
      border-radius: 25px;
      padding: 0.5em;
      border: none;
      outline: none;
      background-color: white;
      box-shadow: inset 2px 5px 10px rgb(5, 5, 5);
    }

    .input-icon {
      height: 1.3em;
      width: 1.3em;
      fill: black;
    }

    .input-field {
      background: none;
      border: none;
      outline: none;
      width: 100%;
      color: black;
      font-size: 1em;
    }

    .form .btn {
      display: flex;
      justify-content: center;
      margin-top: 1.5em;
      width: 100%;
    }

    .button1 {
      padding: 0.6em;
      margin: auto;
      width: 50%;
      max-width: 200px;
      border-radius: 5px;
      border: none;
      outline: none;
      transition: .3s ease-in-out;
      background-color: #252525;
      color: white;
      font-size: 1em;
      cursor: pointer;
    }

    .button1:hover {
      background-color: black;
      color: white;
    }

    .checkbox-wrapper-16 {
      margin: 1em;
    }

    .checkbox-wrapper-16 .checkbox-input {
      clip: rect(0 0 0 0);
      -webkit-clip-path: inset(100%);
      clip-path: inset(100%);
      height: 1px;
      overflow: hidden;
      position: absolute;
      white-space: nowrap;
      width: 1px;
    }

    .checkbox-wrapper-16 .checkbox-input:checked + .checkbox-tile {
      border-color: #2260ff;
      color: #2260ff;
    }

    .checkbox-wrapper-16 .checkbox-tile {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      width: 6rem;
      min-height: 6rem;
      border-radius: 0.5rem;
      border: 2px solid #b5bfd9;
      background-color: #fff;
      box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
      transition: 0.15s ease;
      cursor: pointer;
    }

    .checkbox-wrapper-16 .checkbox-icon svg {
      width: 2.5rem;
      height: 2.5rem;
    }

    .checkbox-wrapper-16 .checkbox-label {
      color: #707070;
      text-align: center;
      margin-top: 0.5em;
      font-size: 0.9em;
    }

    @media (max-width: 768px) {
      #heading {
        font-size: 1.5em;
      }

      .field {
        width: 90%;
        height: 2.2em;
      }

      .button1 {
        width: 80%;
        font-size: 1.05em;
      }

      .checkbox-wrapper-16 .checkbox-tile {
        width: 5.5rem;
        min-height: 5.5rem;
      }

      .checkbox-wrapper-16 .checkbox-icon svg {
        width: 2.2rem;
        height: 2.2rem;
      }

      .checkbox-wrapper-16 .checkbox-label {
        font-size: 0.85em;
      }

      .form {
        width: 95%;
      }
    }
  </style>
</head>

<body>
  <img src="upatrasLogo.jpg" alt="Λογότυπο Πανεπιστημίου Πατρών">
  <hr>

  <form class="form" method="POST" action="loginMysql.php">
    <p id="heading">Σύνδεση</p>

    <div class="field">
      <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
        <path d="M304 128a80 80 0 1 0 -160 0 80 80 0 1 0 160 0zM96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM49.3 464l349.5 0c-8.9-63.3-63.3-112-129-112l-91.4 0c-65.7 0-120.1 48.7-129 112zM0 482.3C0 383.8 79.8 304 178.3 304l91.4 0C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7L29.7 512C13.3 512 0 498.7 0 482.3z"/>
      </svg>
      <input autocomplete="off" name="Usr" placeholder="Όνομα Χρήστη" class="input-field" type="text" required>
    </div>

    <div class="field">
      <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
        <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
      </svg>
      <input placeholder="Κωδικός" name="Pass" class="input-field" type="password" required>
    </div> 

    <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 1em; margin: 1em auto;">
      <!-- Καθηγητής -->
      <div class="checkbox-wrapper-16">
        <label class="checkbox-wrapper">
          <input class="checkbox-input" name="prof" value="1" type="checkbox">
          <span class="checkbox-tile">
            <span class="checkbox-icon">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
              </svg>
            </span>
            <span class="checkbox-label">Καθηγητής</span>
          </span>
        </label>
      </div>

      <!-- Φοιτητής -->
      <div class="checkbox-wrapper-16">
        <label class="checkbox-wrapper">
          <input class="checkbox-input" name="stud" value="1" type="checkbox">
          <span class="checkbox-tile">
            <span class="checkbox-icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-backpack3" viewBox="0 0 16 16">
                <path d="M4.04 7.43a4 4 0 0 1 7.92 0 .5.5 0 1 1-.99.14 3 3 0 0 0-5.94 0 .5.5 0 1 1-.99-.14M4 9.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5zm1 .5v3h6v-3h-1v.5a.5.5 0 0 1-1 0V10z"/>
                <path d="M6 2.341V2a2 2 0 1 1 4 0v.341c.465.165.904.385 1.308.653l.416-1.247a1 1 0 0 1 1.748-.284l.77 1.027a1 1 0 0 1 .15.917l-.803 2.407C13.854 6.49 14 7.229 14 8v5.5a2.5 2.5 0 0 1-2.5 2.5h-7A2.5 2.5 0 0 1 2 13.5V8c0-.771.146-1.509.41-2.186l-.802-2.407a1 1 0 0 1 .15-.917l.77-1.027a1 1 0 0 1 1.748.284l.416 1.247A6 6 0 0 1 6 2.34ZM7 2v.083a6 6 0 0 1 2 0V2a1 1 0 1 0-2 0m5.941 2.595.502-1.505-.77-1.027-.532 1.595q.447.427.8.937M3.86 3.658l-.532-1.595-.77 1.027.502 1.505q.352-.51.8-.937M8 3a5 5 0 0 0-5 5v5.5A1.5 1.5 0 0 0 4.5 15h7a1.5 1.5 0 0 0 1.5-1.5V8a5 5 0 0 0-5-5"/>
              </svg>
            </span>
            <span class="checkbox-label">Φοιτητής</span>
          </span>
        </label>
      </div>

      <!-- Γραμματεία -->
      <div class="checkbox-wrapper-16">
        <label class="checkbox-wrapper">
          <input class="checkbox-input" name="secr" value="1" type="checkbox">
          <span class="checkbox-tile">
            <span class="checkbox-icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                <path d="M8 1a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H9a1 1 0 0 1-1-1zm1 13.5a.5.5 0 1 0 1 0 .5.5 0 0 0-1 0m2 0a.5.5 0 1 0 1 0 .5.5 0 0 0-1 0M9.5 1a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1zM9 3.5a.5.5 0 0 0 .5.5h5a.5.5 0 0 0 0-1h-5a.5.5 0 0 0-.5.5M1.5 2A1.5 1.5 0 0 0 0 3.5v7A1.5 1.5 0 0 0 1.5 12H6v2h-.5a.5.5 0 0 0 0 1H7v-4H1.5a.5.5 0 0 1-.5-.5v-7a.5.5 0 0 1 .5-.5H7V2z"/>
              </svg>
            </span>
            <span class="checkbox-label">Γραμματεία</span>
          </span>
        </label>
      </div>
    </div>

    <div class="btn">
      <button class="button1" type="submit">Σύνδεση</button>
    </div>
  </form>

  <a href="https://helpdesk.upnet.gr/" style="display:block; margin:1em auto; color:#0645ad;">Επικοινωνία με Helpdesk για πρόβλημα σύνδεσης</a>
</body>
</html>
