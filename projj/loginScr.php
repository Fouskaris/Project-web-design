<?php
session_start();
if ((isset($_SESSION['Stud_id']))||(isset($_SESSION['Prof_id']))) {
    header('Location: StudentHomeScreen.php'); 
    exit;
}
?>
<html>
  <head>
  <title>Σύστημα Υποστήριξης Διπλωματικών Εργασιών Πανεπηστιμίου Πατρών</title>
    <img src="upatrasLogo.jpg" alt="Centered Image" style="display: block; margin:  50px auto; width: 20em;">
<hr style="border: 1px solid black; width: 50%;">
    <style>
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


#heading {
  text-align: center;
  margin: 2em;
  color: black;
  font-size: 2em;
}

.field {
  margin:auto;
  width: 20em;
  height:2em;
  align-items: center;
  justify-content: center;
  gap: 0.5em;
  border-radius: 25px;
  padding: 0.6em;
  border: none;
  outline: none;
  color: white;
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
  width: 70%;
  color: black;
}

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


.button3 {
  margin:auto;
  margin-bottom: 3em;
  width:10%;
  padding: 0.5em;
  border-radius: 5px;
  border: none;
  outline: none;
  transition: .4s ease-in-out;
  background-color: #252525;
  color: white;
}
.button3:hover {
  background-color: red;
  color: white;
}
.error{
  color:red;
}
.checkbox-wrapper-16 *,
  .checkbox-wrapper-16 *:after,
  .checkbox-wrapper-16 *:before {
  box-sizing: border-box;
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
  box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
  color: #2260ff;
}

.checkbox-wrapper-16 .checkbox-input:checked + .checkbox-tile:before {
  transform: scale(1);
  opacity: 1;
  background-color: #2260ff;
  border-color: #2260ff;
}

.checkbox-wrapper-16 .checkbox-input:checked + .checkbox-tile .checkbox-icon,
  .checkbox-wrapper-16 .checkbox-input:checked + .checkbox-tile .checkbox-label {
  color: #2260ff;
}

.checkbox-wrapper-16 .checkbox-input:focus + .checkbox-tile {
  border-color: #2260ff;
  box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1), 0 0 0 4px #b5c9fc;
}

.checkbox-wrapper-16 .checkbox-input:focus + .checkbox-tile:before {
  transform: scale(1);
  opacity: 1;
}

.checkbox-wrapper-16 .checkbox-tile {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  width: 7rem;
  min-height: 7rem;
  border-radius: 0.5rem;
  border: 2px solid #b5bfd9;
  background-color: #fff;
  box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
  transition: 0.15s ease;
  cursor: pointer;
  position: relative;
}

.checkbox-wrapper-16 .checkbox-tile:before {
  content: "";
  position: absolute;
  display: block;
  width: 1.25rem;
  height: 1.25rem;
  border: 2px solid #b5bfd9;
  background-color: #fff;
  border-radius: 50%;
  top: 0.25rem;
  left: 0.25rem;
  opacity: 0;
  transform: scale(0);
  transition: 0.25s ease;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='://www.w3.org/2000/svg' width='192' height='192' fill='%23FFFFFF' viewBox='0 0 256 256'%3E%3Crect width='256' height='256' fill='none'%3E%3C/rect%3E%3Cpolyline points='216 72.005 104 184 48 128.005' fill='none' stroke='%23FFFFFF' stroke-linecap='round' stroke-linejoin='round' stroke-width='32'%3E%3C/polyline%3E%3C/svg%3E");
  background-size: 12px;
  background-repeat: no-repeat;
  background-position: 50% 50%;
}

.checkbox-wrapper-16 .checkbox-tile:hover {
  border-color: #2260ff;
}

.checkbox-wrapper-16 .checkbox-tile:hover:before {
  transform: scale(1);
  opacity: 1;
}

.checkbox-wrapper-16 .checkbox-icon {
  transition: 0.375s ease;
  color: #494949;
}

.checkbox-wrapper-16 .checkbox-icon svg {
  width: 3rem;
  height: 3rem;
}

.checkbox-wrapper-16 .checkbox-label {
  color: #707070;
  transition: 0.375s ease;
  text-align: center;
}
    </style>
  </head>
  
<body>

    <form class="form" method="POST" action="login.php">
        <p id="heading">Σύνδεση</p>
        <div class="field">
        <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
          <path d="M304 128a80 80 0 1 0 -160 0 80 80 0 1 0 160 0zM96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM49.3 464l349.5 0c-8.9-63.3-63.3-112-129-112l-91.4 0c-65.7 0-120.1 48.7-129 112zM0 482.3C0 383.8 79.8 304 178.3 304l91.4 0C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7L29.7 512C13.3 512 0 498.7 0 482.3z"/></svg>
        <input autocomplete="off" name="Usr" placeholder="Όνομα Χρήστη" class="input-field" type="text" required>
        </div>
        <div class="field">
        <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
        <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"></path>
        </svg>
        <input placeholder="Κωδικός" name="Pass" class="input-field" type="password" required>
        </div> 
        <div style="display: flex; margin: auto;">
          <div class="checkbox-wrapper-16" >
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
          <div class="checkbox-wrapper-16">
            <label class="checkbox-wrapper">
              <input class="checkbox-input"  name="stud" value="1" type="checkbox">
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
          <div class="checkbox-wrapper-16">
            <label class="checkbox-wrapper">
              <input class="checkbox-input"  name="secr" value="1" type="checkbox">
              <span class="checkbox-tile">
                <span class="checkbox-icon">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pc-display" viewBox="0 0 16 16">
                  <path d="M8 1a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H9a1 1 0 0 1-1-1zm1 13.5a.5.5 0 1 0 1 0 .5.5 0 0 0-1 0m2 0a.5.5 0 1 0 1 0 .5.5 0 0 0-1 0M9.5 1a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1zM9 3.5a.5.5 0 0 0 .5.5h5a.5.5 0 0 0 0-1h-5a.5.5 0 0 0-.5.5M1.5 2A1.5 1.5 0 0 0 0 3.5v7A1.5 1.5 0 0 0 1.5 12H6v2h-.5a.5.5 0 0 0 0 1H7v-4H1.5a.5.5 0 0 1-.5-.5v-7a.5.5 0 0 1 .5-.5H7V2z"/>
                  </svg>
                </span>
                <span class="checkbox-label">Γραματεία</span>
              </span>
            </label>
          </div>
        </div>
        <div class="btn">
        <button class="button1" type="submit">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Σύνδεση&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
        </div>
    </form>
    <a href="https://helpdesk.upnet.gr/" text-allign:center>Επικοινωνία με Helpdesk για πρόβλημα σύνδεσης</a>
</body>
</html>