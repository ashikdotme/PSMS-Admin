<?php require_once('header.php');

$class_id = $_GET['class'];

$stm = $pdo->prepare("SELECT * FROM exam_marks WHERE class_id=? ORDER BY exam_id");
$stm->execute(array($class_id));
$getMarks = $stm->fetchAll(PDO::FETCH_ASSOC);
echo "<pre>";
print_r($getMarks);
echo "</pre>";


$arrayByExam = [];
$studentInfo = [];
$i=0;
$a=0;

$p=0;
$newStList = [];

foreach($getMarks as $marks){
    $arrayByExam[$i]['subject_id'] = $marks['subject_id']; 
    $arrayByExam[$i]['exam_id'] = $marks['exam_id']; 
    $arrayByExam[$i]['student_data'] = json_decode($marks['student_data'],true); 
    $j=0;
    foreach($arrayByExam[$i]['student_data'] as $stArray){
        
        $studentInfo[$a][$j]['student_id'] = $stArray['id'];
        $studentInfo[$a][$j]['student_name'] = $stArray['name'];

        $studentInfo[$a][$j]['subject_id'] =  $marks['subject_id'];
        $studentInfo[$a][$j]['subject_name'] =  getSubjectName($marks['subject_id']);
        $studentInfo[$a][$j]['subject_marks'] = $stArray['marks'];
        $studentInfo[$a][$j]['exam_id'] =  $marks['exam_id'];
        $studentInfo[$a][$j]['exam_name'] =  getExamName($marks['exam_id']);

        $newStList[$p]['student_id'] =  $studentInfo[$a][$j]['student_id'];
        $newStList[$p]['student_name'] = $studentInfo[$a][$j]['student_name'];
        $newStList[$p]['subject_id'] = $studentInfo[$a][$j]['subject_id'];
        $newStList[$p]['subject_name'] = $studentInfo[$a][$j]['subject_name'];
        $newStList[$p]['subject_marks'] = $studentInfo[$a][$j]['subject_marks'];
        $newStList[$p]['exam_id'] = $studentInfo[$a][$j]['exam_id'];

        // $newStList[$p]['student_details']['id'] = $studentInfo[$a][$j]['student_id'];
        // $newStList[$p]['student_details']['student_name'] = $studentInfo[$a][$j]['student_name'];
        // $newStList[$p]['student_details']['subjects']['id'] =  $studentInfo[$a][$j]['subject_id'];
        // $newStList[$p]['student_details']['subjects']['subject_name'] =  $studentInfo[$a][$j]['subject_name'];

        $j++;
        $p++;
    }
 


    // $studentInfo[$a]['student_name'] = '';
    // $studentInfo[$a]['student_id'] = ''; 
    



    $i++; 
    $a++; 
}







echo "<pre>";
print_r($arrayByExam);
echo "</pre>";

echo "<pre>";
print_r($studentInfo);
echo "</pre>";

echo "<pre>";
print_r($newStList);
echo "</pre>";
$newList = [];
$c=0;
foreach($newStList as $list){
    $newList[$list['student_id']][] = $list;
    
    
}
 

echo "<pre>";
print_r($newList);
echo "</pre>";

 
?>
<div class="page-header">
  <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white mr-2">
      <i class="mdi mdi-account"></i>                 
    </span>
    Student Marks Summary
  </h3> 
</div>
<div class="row">
 
<div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body"> 
            Class Name:  <?php echo getClassName($_GET['class'],'class_name') ;?>
            <br>
            <br>
            <table class="table table-bordered">
                <tr>
                    <th>#</th>
                    <th>Student Name</th>
                    <th>1st Exam Marks</th>
                    <th>2nd Exam Marks</th>
                    <th>Final Exam Marks</th> 
                </tr>
                <tr>
                    <td>1</td>
                    <td>Ashik</td>
                    <td>
                        Bangla: 77 <br>
                        English: 88 <br>
                        Math: 66
                    </td>
                    <td>
                        Bangla: 77 <br>
                        English: 88 <br>
                        Math: 66
                    </td>
                    <td>
                        Bangla: 77 <br>
                        English: 88 <br>
                        Math: 66 <br>
                        Total: 444 <br>
                        Position: 1
                    </td>
                </tr>



                <tr>
                    <td>1</td>
                    <td>Ashik</td>
                    <td>
                        Bangla: 77 <br>
                        English: 88 <br>
                        Math: 66
                    </td>
                    <td>
                        Bangla: 77 <br>
                        English: 88 <br>
                        Math: 66
                    </td>
                    <td>
                        Bangla: 77 <br>
                        English: 88 <br>
                        Math: 66 <br>
                        Total: 444 <br>
                        Position: 1
                    </td>
                </tr>


            </table>
        </div>
    </div>
</div> 
 
</div>

<?php require_once('footer.php'); ?>