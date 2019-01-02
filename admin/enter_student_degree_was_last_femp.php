<?php
$pageTitle=' إضافة درجات لطلاب';


session_start();
if(isset($_SESSION['emp']))

{



  //include "init.php";
  $empId=isset($_GET['emp_id'])&& is_numeric($_GET['emp_id'])?intval($_GET['emp_id']):0;
  	$examId=isset($_GET['exam_id'])&& is_numeric($_GET['exam_id'])?intval($_GET['exam_id']):0;
if(isset($_SESSION['emp'])){
if($_SESSION['emp_id']==$empId){
$noNavbar='emp_navbar';
$pageTitle=' إضافة درجات لطلاب';
include "init.php";

} else
{  $noNavbar="";
 include "init.php";
header("Location:first.php");
}
}
elseif (isset($_SESSION['username']) &&$_SESSION['username']=='admin') {
# code...

include_once "init.php";
}
  $connect = new connect();
	//فحص رقم الدفعة
	$examId=isset($_GET['exam_id'])&& is_numeric($_GET['exam_id'])?intval($_GET['exam_id']):0;
	$stmt=$con->prepare("SELECT * FROM exam WHERE Id=?  ");
	$stmt->execute(array($examId));
	$exam=$stmt->FetchAll();
		//$count=$stmt->rowCount();
	$deptname;
$batchname;
////////////////////////////////////////
$max=selectfrom('maximum_marks','exam','WHERE Id',$examId);
$max_degree=$max['maximum_marks'];
  $min=selectfrom('minimum_marks','exam','WHERE Id',$examId);
  $min_degree=$min['minimum_marks'];
			$dep=selectfrom('dept_id','exam','WHERE Id',$examId);
		$department=$dep['dept_id'];
    $d_name=selectfrom('name','department','WHERE Id',$department);
    $dept_name=$d_name["name"];


		$cour=selectfrom('course_id','exam','WHERE Id',$examId);
	$course=$cour['course_id'];
		$lev=selectfrom('level_id','exam','WHERE Id',$examId);
		$level=$lev['level_id'];
    $l_name=selectfrom('name','level','WHERE Id',$level);
    $level_name=$l_name["name"];

		$ter=selectfrom('term_id','exam','WHERE Id',$examId);
		$term=$ter['term_id'];
    $t_name=selectfrom('name','term','WHERE Id',$term);
    $term_name=$t_name["name"];
		$bat=selectfrom('batch_id','exam','WHERE Id',$examId);
		$batch=$bat['batch_id'];
    $b_name=selectfrom('name','batch','WHERE Id',$batch);
    $batch_name=$b_name["name"];
    $sub=selectfrom('subject_id,is_workable','exam','WHERE Id',$examId);
    $id_sub=$sub['subject_id'];
    if($sub['is_workable']==0){
      $sub2=selectfrom('name','subject','WHERE Id',$id_sub);
         $subject_name=$sub2['name'];
       }
       else{
         $sub2=selectfrom('name','subjectwork','WHERE Id',$id_sub);
            $subject_name=$sub2['name'];
       }
         $std_name=selectfrom('std_fname','student','WHERE level_id',"'.$level.'");
         $student_name=$std_name['std_fname'];
/////////////////////////////////////
//////////// new form and empty degrees faled
$empty_form = $connect->execute_query('select std_id ,std_fname,std_lname from student
where level_id='.$level.' and patch_id ='.$batch.'
and dept_id='.$department.'' );
$update_form = $connect->execute_query('SELECT std_id, std_fname, std_lname, exam_id,marks,remarks,is_failed
FROM (
student
JOIN examscore ON student.std_id = examscore.student_id
AND student.level_id = examscore.level_id
AND student.dept_id = examscore.dept_id
)
WHERE exam_id ='.$examId.'
AND term_id ='.$term.'


' );
$last_student = $connect->execute_query('SELECT std_id, std_fname, std_lname
FROM student
WHERE std_id NOT
IN (

SELECT std_id
FROM student, examscore
WHERE student.std_id = examscore.student_id
AND student.level_id = examscore.level_id
AND student.dept_id = examscore.dept_id
AND student.patch_id = examscore.batch_id
AND exam_id ='.$examId.'
AND term_id ='.$term.'
)
AND level_id ='.$level.'
AND dept_id ='.$department.'
AND patch_id ='.$batch.'
AND course_id ='.$course.'

' );

$count_avaliable = $update_form->num_rows;
$count_last_student = $last_student->num_rows;

//$stmt_test=$con->prepare("SELECT * FROM examscore WHERE exam_id=?  ");
//$stmt_test->execute(array($examId));
//$exam_found=$stmt_test->FetchAll();
//  $count=$stmt_test->rowCount();


?>


<div class="container">
  <div class="row">
    <div class="text-center">
  		<div class="panel panel-primary ">
  			<div class="panel-heading">


          <div class="row">
                <div class="col-sm-4 pull-right">
          <h2 class="text-center page-header">  <strong>
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; الــجــمهـــوريـة الـيـمـنـيـة
         <br>

               &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
               جامعة تعز
               <br>

               &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; كلية العلوم التطبيقية
             </strong> </h2>
          <p class="help-block" style="color:white;">العام الجامعي 2017</p>

          </div>
          <div class="col-sm-4 pull-right text-center ">
           <img id="imgStudent0" src="upload\13.jpg" class="img-rounded">
       </div>
          <div class="col-sm-4 pull-right text-center ">
              <div class="col-sm-6 pull-right text-right">
            <h4 class="text-right page-header ">

          <label class="label-control">  القسم </label>
           <br>  <label class="label-control"> التخصص  </label>
           <br>  <label class="label-control">  الترم</label>
            <br>   <label class="label-control">المقرر</label>
          </h4>
      </div>
      <div class="col-sm-6 pull-right text-center">
    <h4 class="text-right page-header "  >

   <label class="label-control"> <?php echo $dept_name?> </label>
   <br> <label class="label-control"> <?php echo $level_name ?></label>
   <br> <label class="label-control"> <?php echo $term_name ?></label>
    <br>  <label class="label-control"><?php echo $subject_name ?></label>
  </h4>
</div></div>


          </div></div>


<div class="panel-body wonder">

  <div id="exam_subject_degree_table"  class="table-responsive "></div>

              <div id=""  class="table-responsive fantastic">
             <br>
<?php



 if($count_last_student>=1 && ($count_avaliable>=1)){
                  ?>



                       <h1 class="text-center">الطلاب الذين لم تضاف لهم درجات </h1>

                              <form class="form-horizontal " id="add_degree_exam_last_student_form" role="form"  data-toggle="validator">
                       <table dir="rtl"  id="example2"class="table table-hover  table-bordered table-responsive ">
                           <thead>
                           <tr>
                               <th class="text-center">أسم الطالب </th>

                             <th  class="text-center">الدرجة</th>
                       <th  class="text-center">ملاحظات</th>
                                   </tr>
                               </thead>
                             <tbody>
                           <input type="hidden" id="min" name="min_degree" value="<?php echo $min_degree?>" ></input>
                             <input type="hidden" id="max" name="max_degree" value="<?php echo $max_degree?>" ></input>
                               <input type="hidden" name="exam_id" value= "<?php echo $examId ?>" id="exam_id">
                                	<input type="hidden" name="department" value= "<?php echo $department ?>" id="department">
                              	<input type="hidden" name="course" value= "<?php echo $course ?>" id="course">
                          	<input type="hidden" name="level" value= "<?php echo $level ?>" id="level">
                              	<input type="hidden" name="term" value= "<?php echo $term ?>" id="term">
                                      <input type="hidden" name="batch" value= "<?php echo $batch ?>" id="batch">

                                    <<?php
                                    echo '  <input type="hidden" name="operation1" value= "Add_last_student" >';



                 while($row = mysqli_fetch_object($last_student))
                   {
                   $student_fname_last=$row->std_fname;
                  $student_lname_last=$row->std_lname;
                      $student_id_last=$row->std_id;

                 echo  ' <tr>

                   <input type="hidden" id="std_last_id" name="std_last_ID[]" value="'.$student_id_last.'"  readonly="true"></input>

                     <td><label class="label-control">'. $student_fname_last.'  '. $student_lname_last.' </lable></td>

              <td ><input  type="number" name="marks_last[]"  id="marks_last"
                      max="'.$max_degree.'" class="form-control"     onkeyup="test_degree(this,'.$min_degree.',0)"> </td>
                        <td ><input type="text" name="notes_last[]" class="form-control alert-info " value="طالب ملتحق لم يتم إاضفة درجة له بهذا الاختبار" style="width:100%;color:red;"></td>


               </tr>';
               }



                 echo '  </tbody>
                     </table>
                     <br>
                   <div class="text-center col-sm-12 ">
                       <input type="submit" id="action_exam_degree_last" name="action_exam_degree_last"
                       class="btn-lg btn btn-primary " value="إضافة" >


                     </form>';
                                   }
                                     ?>

<br>

     </div>   </div>  </div> </div>








   <hr>


                  <!--h1 class=" text-center ">
                            <a id="exam_collapse_btn" data-target="#Examcollapse" data-toggle="collapse"
                          href="#Examcollaps" class="  ">
                                <i class="btn fa fa-th fa-5x"></i> إضافة درجات لطلاب
                            </a>
                        </h1>

                        <div id="degreecollapse" class=" " style="height: 0px;">
                            <div class="panel-body">
                            <table dir="rtl" class="table table-hover table-bordered">
                              <thead>
                                <tr>
                                  <th class="text-right">أسم الطالب </th>
                                  <th  class="text-right">الدرجة</th>
                                    <th  class="text-right">ملاحظات</th>
                                </tr>
                              </thead>
                              <tbody>
                              <tr>


                                   <td><a href="#" id="" name=""><?php// echo $student_name ?><a></td>
                                    <td><input type="text" class="form-control"/></td>
                                      <td><input type="text" class="form-control"/></td>


                              </tr>

                              </tbody>
                            </table-->

  </div>
</div>


<?php

include  $tpl.'footer.php';
}
?>
<script>
var department=document.getElementById('department').value;
var course=document.getElementById('course').value;
	var level=document.getElementById('level').value;
 var term=document.getElementById('term').value;
  var batch=document.getElementById('batch').value;
var exam=document.getElementById('exam_id').value;
var mark=document.getElementById('marks2');
var min=document.getElementById('min').value;
var a=document.getElementById('max').value;
var test=1;
max=parseFloat(a);

//  alert("$mi_Marks");
    //alert(mark);
//test_degree_onload();

function test_degree(x,$mi_Marks,$old_Marks) {
  var temp= x.value;
var old_value=parseFloat($old_Marks);
//alert(old_value);
  //if(x.value > max){alert( x.value);}
    if( x.value < $mi_Marks ){
   x.style.background = "#ebccd1";
  //  x.style.bordercolor="#d6e9c6"
    x.style.color="#a94442";
   //x.addclass('alert-danger');
    }
    else{

    //  alert(x.value);
    if(x.value <=max){
    //  alert("min");
  x.style.background = "#dff0d8";
  x.style.color ="#3c763d";

}
else {
  //test=0;
  alert("العدد غير مسموح به لانه تعدئ الدرجة العظمئ للمادة");

    x.value=old_value;
//return false;
//alert(test);

}
  //color: #3c763d;
  //  background-color: #dff0d8;
  //  border-color: #d6e9c6
}
}



$('#example').DataTable( {
   dom: 'Bfrtip',
   buttons: [
       'copy', 'csv', 'excel', 'pdf', 'print'
   ]
} );
$('#example2').DataTable( {
   dom: 'Bfrtip',
   buttons: [
       'copy', 'csv', 'excel', 'pdf', 'print'
   ]
} );



//load_exam_subject_degrees();

</script>
