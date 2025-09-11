<?php
session_start();
if (!isset($_SESSION['Prof_id'])) {
    header('Location: loginScr.php');
    exit;
}
$id = $_SESSION['Prof_id'];

function safe_json_read($path) {
    if (!file_exists($path)) return [];
    $s = file_get_contents($path);
    $d = json_decode($s, true);
    return $d ?: [];
}
function safe_json_write($path, $data) {
    file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), LOCK_EX);
}

$jsonString = file_get_contents("export.json");
$data = json_decode($jsonString, true);
$professors = $data['professors'] ?? [];
$last_name = '';
foreach ($professors as $professor) {
  if ($professor['id'] == $id) {
    $last_name = $professor['surname'];
    break;
  }
}

$dipl = safe_json_read("dipl.json");
$subjects = $dipl['subjects'] ?? [];
$invites = $dipl['invites'] ?? [];
$notes = $dipl['notes'] ?? [];
$grades = $dipl['grades'] ?? [];
$announcements = $dipl['announcements'] ?? [];
$cancellations = $dipl['cancellations'] ?? [];

?><!DOCTYPE html>
<html lang="el">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Σύστημα Υποστήριξης Διπλωματικών - Διαχείριση</title>
  <style>
    body { margin:0; font-family: Arial, sans-serif; }
    .top-menu { background-color: whitesmoke; color:black; display:flex; align-items:center; padding:10px 20px; position:fixed; top:0; width:100%; box-sizing:border-box; }
    .menu-title { font-size:30px; }
    .button { margin-left:auto; padding:8px 16px; height:40px; width:250px; border:none; background:white; border-radius:20px; cursor:pointer; }
    .title{ margin:auto; text-align:center; margin-top:5em; }
    table{ border-collapse:collapse; width:80%; margin:auto; margin-top:2em; }
    th, td{ border:1px solid #000; padding:10px; text-align:left; vertical-align:top; }
    th{ background:#f2f2f2; }
    .listButton{ background:white; color:rgba(36,190,49,0.81); border:none; cursor:pointer; padding:6px 10px; border-radius:6px; }
    .listButton:hover{ color:rgba(22,127,31,0.81); }
    .tabletitle{ margin:auto; margin-top:5em; text-align:center; }
    .tabletitle2{ margin:auto; margin-top:5em; text-align:center; }
    .inp{ border:1px solid #ccc; font-size:1em; padding:6px; width:300px; border-radius:6px; }
    textarea.inp{ height:80px; resize:vertical; }
    .small{font-size:0.9em; color:#444;}
    .note{ background:#f8f8f8; padding:8px; margin:6px 0; border-radius:6px; }
  </style>
</head>
<body>
  <div class="top-menu">
    <img src="upatrasLogo.jpg" alt="UPAT" style="display:block; margin:0px; width:10em;">
    <div class="menu-title">Σύστημα Υποστήριξης Διπλωματικών Εργασιών</div>
  </div>

  <h1 class="title">Διαχείρηση Κατάστασης Διπλωματικών</h1>

<?php
$found = false;
foreach ($subjects as $subject) {
    if (($subject['status'] != 'Περατωμένη') && ($subject['professor_id'] == $id)) { $found = true; break; }
}
if ($found) {
    echo "<table><tr><th>Θέμα</th><th>Φοιτητής</th><th>Κατάσταση / Ενέργειες</th><th>Ενέργεια</th></tr>";
    foreach ($subjects as $subject) {
        if (($subject['professor_id'] == $id) && ($subject['status'] != "Περατωμένη")) {
            $subj_id = $subject['id'];
            echo "<tr>";
            echo "<td>".htmlspecialchars($subject['name'])."</td>";
            echo "<td>";
            if (empty($subject['student_number']) || $subject['student_number']==0) echo "Δεν έχει ανατεθεί";
            else echo "AM: ".htmlspecialchars($subject['student_number']);
            echo "</td>";

            echo "<td><form action='changeStatus.php' method='post'>";
            echo "<input type='hidden' name='id' value='".htmlspecialchars($subj_id, ENT_QUOTES, 'UTF-8')."'>";
            echo "<input type='hidden' name='prof_id' value='".htmlspecialchars($id, ENT_QUOTES, 'UTF-8')."'>";

            if ($subject["status"] == "Διαθέσιμη") {
                echo "<label><input type='radio' name='choice' value='Διαθέσιμη' checked> Διαθέσιμη</label><br>";
                echo "<label><input type='radio' name='choice' value='Ενεργή'> Ενεργή</label><br>";
                echo "<label><input type='radio' name='choice' value='Υπό Εξέταση'> Υπό Εξέταση</label><br>";
            } elseif ($subject["status"] == "Ενεργή") {
                echo "<label><input type='radio' name='choice' value='Ενεργή' checked> Ενεργή</label><br>";
                echo "<label><input type='radio' name='choice' value='Υπό Εξέταση'> Υπό Εξέταση</label><br>";
                $exDate = $subject['assignment_date'] ?? null;
                if ($exDate) {
                    $todayDate = new DateTime(date("Y-m-d"));
                    try { $exDateObj = new DateTime($exDate); } catch (Exception $e) { $exDateObj = null; }
                    if ($exDateObj) {
                        $interval = $exDateObj->diff($todayDate);
                        $totalDays = $interval->days;
                        if ($totalDays > 731) {
                            echo "<p class='small' style='color:red'>Πέρασαν >2 έτη από ανάθεση ({$totalDays} μέρες)</p>";
                            echo "<label><input type='radio' name='choice' value='Ακύρωση'> Ακύρωση</label><br>";
                        }
                    }
                }
            } elseif ($subject["status"] == "Υπό Εξέταση") {
                echo "<label><input type='radio' name='choice' value='Διαθέσιμη'> Διαθέσιμη</label><br>";
                echo "<label><input type='radio' name='choice' value='Ενεργή'> Ενεργή</label><br>";
                echo "<label><input type='radio' name='choice' value='Υπό Εξέταση' checked> Υπό Εξέταση</label><br>";
            }
            echo "</td>";

            echo "<td style='width:220px;'>";
            echo "<button class='listButton' type='submit' title='Αποθήκευση κατάστασης'>Εφαρμογή</button>";
            echo "</form><br>";
            echo "<details><summary class='small'>Προσκλήσεις / Μέλη τριμελούς</summary>";
            $foundInv = false;
            foreach ($invites as $inv) {
                if ($inv['subj_id'] == $subj_id) {
                    $foundInv = true;
                    $status = $inv['status'] ?? 'pending';
                    $inv_date = $inv['invitation_date'] ?? '-';
                    $resp_date = $inv['response_date'] ?? '-';
                    $prof_name = $inv['professor_surname'] ?? ($inv['professor_id'] ?? ''); 
                    echo "<div class='small'>Καθηγ.: ".htmlspecialchars($prof_name).
                         " — Κατάσταση: ".htmlspecialchars($status).
                         " — Πρόσκληση: ".htmlspecialchars($inv_date).
                         " — Απάντηση: ".htmlspecialchars($resp_date)."</div>";
                }
            }
            if (!$foundInv) echo "<div class='small'>Δεν υπάρχουν προσκλήσεις</div>";
            echo "</details>";
            if (($subject['professor_id'] ?? null) == $id && !empty($subject['student_number']) && $subject['student_number'] != 0) {
                echo "<form action='cancel_assignment.php' method='POST' style='margin-top:6px;'>
                        <input type='hidden' name='subj_id' value='".htmlspecialchars($subj_id, ENT_QUOTES, 'UTF-8')."'>
                        <input type='hidden' name='prof_id' value='".htmlspecialchars($id, ENT_QUOTES, 'UTF-8')."'>
                        <div class='small'>Ακύρωση ανάθεσης: Αριθμός ΓΣ <input class='inp' name='gs_num' required style='width:80px;'> Έτος <input class='inp' name='gs_year' required style='width:80px;'></div>
                        <input type='hidden' name='reason' value='από Διδάσκοντα'>
                        <button class='listButton' type='submit'>Ακύρωση ανάθεσης (Επιβλέπων)</button>
                      </form>";
            }

            echo "</td>";
            echo "</tr>";
        }
    }
    echo "</table>";
} else {
    echo "<h2 class='title'>Δεν υπάρχουν μη περατωμένα μαθήματα</h2>";
}

echo "<h1 class='title'>Ανάθεση και Αλλαγή Διπλωματικών</h1>";
$found = false;
foreach ($subjects as $subject) {
    if (($subject['status'] == 'Διαθέσιμη') && ($subject['professor_id'] == $id)) { $found = true; break; }
}
if ($found) {
    echo "<table><tr><th>Θέμα</th><th>Περιγραφή</th><th>Ανάθεση</th><th>Ενέργεια</th></tr>";
    foreach ($subjects as $subject) {
        if (($subject['status'] == 'Διαθέσιμη') && ($subject['professor_id'] == $id)) {
            echo "<tr><form action='change_assign.php' method='POST'>";
            echo "<td><textarea class='inp' name='name' style='width:100%;'>".htmlspecialchars($subject['name'], ENT_QUOTES, 'UTF-8')."</textarea></td>";
            echo "<td><textarea class='inp' name='description' style='width:100%;'>".htmlspecialchars($subject['description'] ?? '', ENT_QUOTES, 'UTF-8')."</textarea></td>";
            echo "<input type='hidden' name='subj_id' value='".htmlspecialchars($subject['id'], ENT_QUOTES, 'UTF-8')."'>";
            echo "<input type='hidden' name='id' value='".htmlspecialchars($id, ENT_QUOTES, 'UTF-8')."'>";
            echo "<td><input class='inp' style='width:150px;' type='text' name='student' placeholder='Όνομα ή ΑΜ Φοιτητή'></td>";
            echo "<td><button class='listButton' type='submit'>Υποβολή</button></td>";
            echo "</form></tr>";
        }
    }
    echo "</table>";
} else {
    echo "<h2 class='title'>Δεν υπάρχουν μαθήματα για ανάθεση ή αλλαγή</h2>";
}
echo "<h1 class='title'>Βαθμολόγηση Διπλωματικών</h1>";
$found = false;
foreach ($subjects as $subject) {
    if (($subject['status'] == 'Υπό Εξέταση') && ($subject['professor_id'] == $id || true)) { $found = true; break; } // εμφανίζεται αν επιβλέπων ή μέλος (γι'απλό)
}
if ($found) {
    echo "<table style='margin-bottom:1em;'><tr><th>Θέμα</th><th>Φοιτητής</th><th>Δραστηριότητες</th><th>Ενέργεια</th></tr>";
    foreach ($subjects as $subject) {
        if ($subject["status"] == "Υπό Εξέταση") {
            $subj_id = $subject['id'];
            echo "<tr>";
            echo "<td>".htmlspecialchars($subject['name'], ENT_QUOTES, 'UTF-8')."</td>";
            echo "<td>AM: ".htmlspecialchars($subject['student_number'] ?? '-')."</td>";
            echo "<td>";
            if (!empty($subject['draft_file'])) {
                echo "<div class='small'>Πρόχειρο: <a href='uploads/".htmlspecialchars($subject['draft_file'])."' target='_blank'>Προβολή</a></div>";
            } else {
                echo "<div class='small'>Δεν υπάρχει πρόχειρο κείμενο.</div>";
            }
            if (!empty($subject['presentation_date']) && !empty($subject['presentation_room']) && !empty($subject['presentation_time'])) {
                echo "<div class='small'>Στοιχεία παρουσίασης: ".htmlspecialchars($subject['presentation_date'])." ".htmlspecialchars($subject['presentation_time'])." , Δωμάτιο: ".htmlspecialchars($subject['presentation_room'])."</div>";
                echo "<form action='generate_announcement.php' method='POST' style='margin-top:6px;'>
                        <input type='hidden' name='subj_id' value='".htmlspecialchars($subj_id, ENT_QUOTES, 'UTF-8')."'>
                        <button class='listButton' type='submit'>Παραγωγή Ανακοίνωσης</button>
                      </form>";
            } else {
                echo "<div class='small'>Ο φοιτητής δεν συμπλήρωσε πλήρως τα στοιχεία παρουσίασης για ανακοίνωση.</div>";
            }

            echo "<div style='margin-top:8px;'><strong class='small'>Βαθμοί τριμελούς:</strong>";
            $foundGrades = false;
            foreach ($grades as $g) {
                if ($g['subj_id'] == $subj_id) {
                    $foundGrades = true;
                    $prof_surname = $g['professor_surname'] ?? $g['professor_id'];
                    $gval = $g['grade'];
                    echo "<div class='note'>".htmlspecialchars($prof_surname)." — Βαθμός: ".htmlspecialchars($gval)."</div>";
                }
            }
            if (!$foundGrades) echo "<div class='small'>Δεν υπάρχουν καταχωρημένοι βαθμοί.</div>";
            echo "</div>";

            echo "</td>";

            echo "<td>";
            echo "<form action='grade_subj.php' method='POST'>
                    <input type='hidden' name='subj_id' value='".htmlspecialchars($subj_id, ENT_QUOTES, 'UTF-8')."'>
                    <input type='hidden' name='prof_id' value='".htmlspecialchars($id, ENT_QUOTES, 'UTF-8')."'>
                    <div class='small'>Βαθμός (1-10): <input class='inp' style='width:90px;' type='number' name='student_grade' min='1' max='10' step='0.5' required></div>
                    <div class='small'>Προαιρετικό σχόλιο: <input class='inp' name='comment' style='width:150px;'></div>
                    <button class='listButton' type='submit' style='margin-top:6px;'>Υποβολή Βαθμού</button>
                  </form>";
            echo "</td>";

            echo "</tr>";
        }
    }
    echo "</table>";
} else {
    echo "<h2 class='title'>Δεν υπάρχουν μαθήματα για βαθμολόγηση</h2>";
}

?>

</body>
</html>
