<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <title>Έλεγχος Σύνδεσης</title>
</head>
<body>
<?php
require 'connection.php'; // περιέχει σύνδεση $conn

// Έλεγχος αν στάλθηκαν δεδομένα από τη φόρμα
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input_usr = $_POST['Usr'] ?? '';
    $input_pwd = $_POST['Pass'] ?? '';

    $isStudent = isset($_POST['stud']);
    $isProfessor = isset($_POST['prof']);
    $isSecretariat = isset($_POST['secr']);

    // Έλεγχος για πολλαπλές επιλογές ρόλων
    if (($isStudent + $isProfessor + $isSecretariat) != 1) {
        require 'WrongPassScr.php';
        exit;
    }

    // Έλεγχος κενού username/password
    if (empty($input_usr) || empty($input_pwd)) {
        require 'WrongPassScr.php';
        exit;
    }

    // Καθορισμός στοιχείων ανά ρόλο
    if ($isStudent) {
        $table = 'Students';
        $redirect = 'StudentHomeScreen.php';
    } elseif ($isProfessor) {
        $table = 'Professors';
        $redirect = 'ProfessorHomeScreen.php';
    } elseif ($isSecretariat) {
        $table = 'Secretariat';
        $redirect = 'SecretariatHomeScreen.php';
    }

    // Εκτέλεση ερωτήματος με prepared statement
    $stmt = $conn->prepare("SELECT id, password FROM $table WHERE username = ?");
    $stmt->bind_param("s", $input_usr);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($id, $db_pwd);
        $stmt->fetch();

        if ($input_pwd === $db_pwd) { // Μπορείς να αλλάξεις αυτό με password_verify αν είναι hashed
            header("Location: $redirect?id=$id");
            exit;
        } else {
            require 'WrongPassScr.php'; // Λάθος password
            exit;
        }
    } else {
        require 'WrongPassScr.php'; // Δεν υπάρχει αυτός ο χρήστης
        exit;
    }
}
?>
</body>
</html>
