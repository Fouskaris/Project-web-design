<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <title>Έλεγχος Σύνδεσης</title>
</head>
<body>
<?php
require 'connection.php'; 

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

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
       $_SESSION['Stud_id'] = $input_usr;
        $stmt = $conn->prepare("SELECT id, password FROM Students WHERE username = ?");
        $stmt->bind_param("s", $input_usr);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $stmt->bind_result($id, $db_pwd);
            $stmt->fetch();

            if ($input_pwd === $db_pwd) { 
                header("Location: StudentHomeScreen.php?id=$id");
                exit;
            } else {
                require 'WrongPassScr.php'; // Λάθος password
                exit;
            }
        } else {
            require 'WrongPassScr.php'; // Δεν υπάρχει αυτός ο χρήστης
            exit;
        }
         
    } elseif ($isProfessor) {
        $_SESSION['Prof_id'] = $input_usr;
        $stmt = $conn->prepare("SELECT id, password FROM Professors WHERE username = ?");
        $stmt->bind_param("s", $input_usr);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $stmt->bind_result($id, $db_pwd);
            $stmt->fetch();

            if ($input_pwd === $db_pwd) { 
                header("Location: ProfessorHomeScreen.php?id=$id");
                exit;
            } else {
                require 'WrongPassScr.php'; // Λάθος password
                exit;
            }
        } else {
            require 'WrongPassScr.php'; // Δεν υπάρχει αυτός ο χρήστης
            exit;
        }
    } elseif ($isSecretariat) {
        $_SESSION['Sec_id'] = $input_usr;
        $stmt = $conn->prepare("SELECT id, password FROM Secretariat WHERE username = ?");
        $stmt->bind_param("s", $input_usr);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $stmt->bind_result($id, $db_pwd);
            $stmt->fetch();

            if ($input_pwd === $db_pwd) { 
                header("Location: SecretariatHomeScreen.php?id=$id");
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
}
?>
</body>
</html>