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
        $count = 0;

        if (isset($_POST['stud'])) $count++;
        if (isset($_POST['prof'])) $count++;
        if (isset($_POST['secr'])) $count++;

        if ($count >= 2) {
            require 'WrongPassScr.php';           
            }elseif($count==1){
                    if (isset($_POST['stud'])){
                        foreach($students as $student){
                            if(($student['id']===$input_usr)){
                            $foundstud=true;
                            if ($input_pwd===$student['id']){
                                $id= $student['id'];
                                header('Location:StudentHomeScreen.php?id='.$id);
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
                    }elseif (isset($_POST['prof'])){
                        //require; 
                    }else require 'WrongPassScr.php';  
                }
        
?>
</html>