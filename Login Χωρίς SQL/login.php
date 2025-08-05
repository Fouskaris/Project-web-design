<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Read input from form
$input_usr = $_POST['Usr'] ?? null;
$input_pwd = $_POST['Pass'] ?? null;

// Load JSON data
$jsonString = file_get_contents("export.json");
$data = json_decode($jsonString, true);

$students = $data['students'] ?? [];
$professors = $data['professors'] ?? [];

$count = 0;
if (isset($_POST['stud'])) $count++;
if (isset($_POST['prof'])) $count++;
if (isset($_POST['secr'])) $count++;

// Invalid if more than one role selected
if ($count >= 2) {
    require 'WrongPassScr.php';
    exit;
}

// Proceed if exactly one role selected
if ($count === 1) {
    if (isset($_POST['stud'])) {
        foreach ($students as $student) {
            if ($student['id'] === $input_usr) {
                if ($input_pwd === $student['id']) {
                    $_SESSION['id'] = $student['id'];
                    $_SESSION['name'] = $student['name']; // Optional
                    header('Location: StudentHomeScreen.php');
                    exit;
                } else {
                    require 'WrongPassScr.php';
                    exit;
                }
            }
        }
    }

    if (isset($_POST['prof'])) {
        foreach ($professors as $professor) {
            if ($professor['id'] === $input_usr) {
                if ($input_pwd === $professor['id']) {
                    $_SESSION['id'] = $professor['id'];
                    $_SESSION['name'] = $professor['name']; // Optional
                    header('Location: ProfessorHomeScreen.php');
                    exit;
                } else {
                    require 'WrongPassScr.php';
                    exit;
                }
            }
        }
    }

    if (isset($_POST['secr'])) {
        if ($input_pwd === $input_usr) {
            $_SESSION['id'] = $input_usr;
            header('Location: SecretariatHomeScreen.php');
            exit;
        } else {
            require 'WrongPassScr.php';
            exit;
        }
    }

    // If no user matched
    require 'WrongPassScr.php';
    exit;
}
?>
