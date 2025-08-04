<?php
$prof_id=isset($_POST["id"])?$_POST["id"]: 0;
$subj_id=isset($_POST["subj_id"])?$_POST["subj_id"]: '';
$subj_name=isset($_POST["name"])?$_POST["name"]:"";
$subj_des=isset($_POST["description"])?$_POST["description"]:"";
$stud_info=isset($_POST["student"])?$_POST["student"]:"";
$jsonString = file_get_contents("export.json");
$data = json_decode($jsonString, true);
$professors = $data['professors'];
foreach ($professors as $professor) {
    if ($professor['id'] == $prof_id) {
        $prof_surname= $professor['surname'];
    }}
$students= &$data['students'];
$jsonString2 = file_get_contents("dipl.json");
$data2 = json_decode($jsonString2, true);
$subjects = &$data2['subjects'];
date_default_timezone_set('Europe/Athens');
$today = date("d-m-Y");
if($stud_info){
    foreach ($students as &$student) {
    $fullName=$student['name'].' '.$student['surname'];
    if ($student['student_number'] == $stud_info){
        $student_number=$stud_info;
        $message = "O κύριος $prof_surname σας ανέθεσε το θέμα:$subj_name. ";
        $new_id=uniqid();
        $newNotifStud=[
            'id'=> $new_id,
            'message'=> $message,
            'date'=> $today,
            'by'=> $prof_id,
            'to'=> $student_number,
            'seen'=> "no",
            "type"=> "text"
        ];
        $student['notifications'][] = $newNotifStud;
        echo $message;
        break;
    }elseif($fullName == $stud_info) {
        $student_number=$student['student_number'];
         $message = "O κύριος $prof_surname σας ανέθεσε το θέμα:$subj_name. ";
        $new_id=uniqid();
        $newNotifStud=[
            'id'=> $new_id,
            'message'=> $message,
            'date'=> $today,
            'by'=> $prof_id,
            'to'=> $student_number,
            'seen'=> "no",
            "type"=> "text"
        ];
        $student['notifications'][] = $newNotifStud;
        echo $message;
        break;
    }
}
}
foreach($subjects as &$subject){
    if($subject['id']== $subj_id){
        $subject['name'] = $subj_name;
        $subject['description'] = $subj_des;
        $subject['status'] = 'Ενεργή';
        $subject['assignment_date'] = $today;
        if($stud_info){$subject['student_number']= $student_number;}
        echo $subject['name'];
        break;
    }
}
file_put_contents("export.json", json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
file_put_contents("dipl.json", json_encode($data2, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

?>