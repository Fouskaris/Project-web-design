<!DOCTYPE html>
<html>
<?php
        $input_usr = $_POST['Usr'];
        $input_pwd = $_POST['Pass'];
        $jsonString= file_get_contents("export.json");
        $data= json_decode($jsonString,true);
        $students = $data['students']; 
        $foundstud = false;
        $data2= json_decode($jsonString,true);
        $professors= $data2['professors'];
        $foundprof=false;
        if (isset($_POST['stud']) && isset($_POST['prof'])) {
            require 'WrongPassScr.php';
        }else{
            if (isset($_POST['stud'])){
                foreach($students as $student){
                    if(($student['id']===$input_usr)){
                        $foundstud=true;
                        if ($input_pwd===$student['id']){
                            require 'StudentHomeScreen.php';
                        }
                        else {
                            require 'WrongPassScr.php';
                        }
                    }
                }
            }elseif (isset($_POST['prof'])){
                foreach($professors as $professor){
                    if(($professor['id']===$input_usr)){
                        $foundprof=true;
                        if ($input_pwd===$professor['id']){
                            require 'ProfessorHomeScreen.php';
                        }
                        else {
                            require 'WrongPassScr.php';
                        }
                    }
                }
            }else  require 'WrongPassScr.php';  
        }
        
?>
</html>