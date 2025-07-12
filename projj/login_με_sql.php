<!DOCTYPE html>
<html>
<?php

require 'connection.php'; 

    $input_usr = $_POST['Usr'];
    $input_pwd = $_POST['Pass'];
    $jsonString= file_get_contents("export.json");
    $data= json_decode($jsonString,true);
    $students = $data['students']; 
    $foundstud = false;
    $data2= json_decode($jsonString,true);
    $professors= $data2['professors'];
    $foundprof=false;
    $count = 0;

    // Έλεγχος αν στάλθηκαν τα δεδομένα από τη φόρμα
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (isset($_POST['stud'])) $count++;
        if (isset($_POST['prof'])) $count++;
        if (isset($_POST['secr'])) $count++;


        if ($count >= 2) {
            require 'WrongPassScr.php';           
            }elseif($count==1){
                if (isset($_POST['stud'])){
                    // Έλεγχος ότι δεν είναι κενά
                    if (!empty($input_usr) && !empty($input_pwd)) {
                        $sql = "SELECT password FROM Students WHERE username = $input_usr";
                        if($sql=$input_pwd){
                            header('Location:StudentHomeScreen.php?id='.$id);
                            }
                        else {
                            require 'WrongPassScr.php';
                            }
                        }else {
                            require 'WrongPassScr.php';
                            }
                    }elseif (isset($_POST['prof'])){
                   
                if (!empty($input_usr) && !empty($input_pwd)) {
                    $sql = "SELECT password FROM Professors WHERE username = $input_usr";
                    if($sql=$input_pwd){
                        header('Location:ProfessorHomeScreen.php?id='.$id);
                        }
                    else {
                        require 'WrongPassScr.php';
                        }
                    }
                else {
                    require 'WrongPassScr.php';
                    }    
                }
            }
    }    
?>
</html>