<?= $this->extend('include/header.php') ?>

<?= $this->section('content') ?>
<style>
.table-sm td, .table-sm th {
    padding: 0 0.1rem !important;
}

.bootstrap-table .fixed-table-container .table.table-sm .th-inner {
    padding: 0.2rem;
    font-size: 13px;
}
tbody, td, tfoot, th, thead, tr {
    font-size: 14px;
}
body {
    margin: 0;
    line-height: 1.3;
   
}
input[type=checkbox], input[type=radio] {
   
    vertical-align: middle;
}
</style>
<div class="container">
  <div class="row">
    <div class="col-lg-12">
      <h4 class="text-center fw-bold">ATTENDANCE REPORT</h4>
        <!--  <div class="text-center star_wrapper">-->
        <!--        <hr class="top-Line"></hr><i class="fas fa-star fa-xs icons_rotate"></i><hr class="top-Line"></hr>-->
        <!--</div>-->
      
    </div>
  </div>
</div>

<div class="clearfix"></div>
<form action="<?php echo base_url('AttendanceReport/search_report'); ?>" method="post">

  <!-- main -->
  <div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-auto"><input type="text" id="from_date" value="<?= $from; ?>" name="from_date" class="form-control mb-2" placeholder="From:" onfocus="(this.type ='date')" style="width: 162px;"></div>
        <div class="col-auto"><input type="text" id="to_date" name="to_date" value="<?= $to; ?>" class="form-control mb-2" placeholder="To:" onfocus="(this.type ='date')" style="width: 162px;"></div>
        <div class="col-auto">
            <select name="reportType" class="form-control" required placeholder="Report Type">
              <option value="Login-Logout">Login-Logout</option>
              <option value="Breaks">Breaks</option>
              <option value="IP">IP</option>
              <option value="Report">Report</option>
            </select>
        </div>
        <div class="col-auto"><button type="submit" class="btn btn-primary">Show</button>
        </form>
        </div>
    </div>
        <?php
          $datewise_employee = array();
          if($employee){
          foreach ($employee as $emp) {
            
            
              $date = $emp['attendance_date'];
              $employee_id = $emp['name'];
              if (!isset($datewise_employee[$date])) {
                  $datewise_employee[$date] = array();
              }
              if (!isset($datewise_employee[$date][$employee_id])) {
                  $datewise_employee[$date][$employee_id] = array();
              }
              $datewise_employee[$date][$employee_id][] = $emp;
          }
          
        }
 if(!empty($datewise_employee) &&!empty($datewise_employee_leave) ){
  $finalDatewiseEmp=array_merge_recursive($datewise_employee,$datewise_employee_leave);
 }elseif(!empty($datewise_employee) ){
  $finalDatewiseEmp=$datewise_employee;
 }
            // echo "<pre>";
            // print_r($finalDatewiseEmp);
          // Calculate time intervals and organize the data by date and employee ID
          $table_data = array();
          if($finalDatewiseEmp){
          foreach ($finalDatewiseEmp as $date => $employees) {
              foreach ($employees as $employee_id => $emps) {
                  $login_time = null;
                  $logout_time = null;
                  $total_work_time = 0;
                  $break_time=null;
                  $restart_time=null;
                  $total_break_time=0;
                  foreach ($emps as $emp) {
                      if ($emp['log_type'] == '1') {
                          // If this is a login record, record the login time
                          $login_time = new datetime($emp['created_at']);
                      }elseif ($emp['log_type'] == '2') {
                        // If this is a restart record, record the logout time and calculate the work time
                        $break_time = new datetime($emp['created_at']);
                        
                    }
                      elseif ($emp['log_type'] == '4') {
                        // If this is a restart record, record the logout time and calculate the work time
                        $restart_time = new datetime($emp['created_at']);
                        if ($break_time && $restart_time) {
                            $tot_break_time = $break_time->diff($restart_time);
                            $breakparts = explode(" ", $tot_break_time->format("%a %h %i"));
                            // Convert each part to minutes
                           
                           //  echo "<pre>";
                           //  print_r($parts);
                            $total_break_minutes = 0;
                            foreach ($breakparts as $key=> $part) 
                           {
                          
                            // echo $key .'--'.$part.'--'.$part[$key]."<br>";
                               if ($key==0) {
                                 $total_break_minutes += intval($part) * 24 * 60;
                                 }elseif ($key==1) {
                                     $total_break_minutes += intval($part) * 60;
                                  }elseif ($key==2) {
                                     $total_break_minutes += intval($part);
                                 }
                             
                           }
                           $total_break_time +=round($total_break_minutes,2);
                          }  
                        $break_time=null;
                    } elseif ($emp['log_type'] == '3') {
                          // If this is a logout record, record the logout time and calculate the work time
                          $logout_time = new datetime($emp['created_at']);
                          if (($login_time && $logout_time )|| $total_break_time) {
                            //  echo (($logout_time - $login_time)/3600).'-----'.$total_break_time.'<br>';
                              $duration= $login_time->diff($logout_time);
                              // Split duration string into individual parts
                              $parts = explode(" ", $duration->format("%a %h %i"));
                             // Convert each part to minutes
                            
                            //  echo "<pre>";
                            //  print_r($parts);
                             $total_minutes = 0;
                             foreach ($parts as $key=> $part) 
                            {
                           
                             // echo $key .'--'.$part.'--'.$part[$key]."<br>";
                                if ($key==0) {
                                  $total_minutes += intval($part) * 24 * 60;
                                  }elseif ($key==1) {
                                      $total_minutes += intval($part) * 60;
                                   }elseif ($key==2) {
                                      $total_minutes += intval($part);
                                  }
                              
                            }
                            
                            $total_work_time +=round($total_minutes,2)-$total_break_time;
                            // echo $total_work_time.'<br>';
                            // echo $emp['employee_id'].'<br>';
                          }
                          // Reset the login and logout times for the next record
                          $login_time = null;
                          $logout_time = null;
                          $break_time=null;
                          $restart_time=null;
                      }
                      elseif ($emp['status'] == 'Approved') {
                         // If this is a Leave record, 
                        if($emp['dateDiff']>$emp['maxworktime']){
                           $total_work_time='Leave';
                        }else{
                          $total_work_time= intval((strtotime($emp['dateDiff'])-strtotime($emp['maxworktime']))/60)+60;
                          // strtotime($emp['dateDiff'])-(strtotime($emp['maxworktime']));
                      // echo $total_work_time;
                        }
                    }
                  }
                 if($total_work_time=='Leave'){
                    $total_work=$total_work_time;
                  }else{
                  $hours=floor(abs($total_work_time)/60);
                    $minutes = abs($total_work_time)%60;
                    $times = ($hours*60*60)+($minutes*60); // create a Unix timestamp from the hour and minute values

                    $time1 = date('h',strtotime($emp['maxworktime']));
                    $time2 =$times;
                    $time_diff = (($time2-(($time1*60*60)-3600))/60);
                    // echo (strtotime($time2)).'<br>';
                    if($time_diff<0){
                      $hrs=floor(abs($time_diff)/60);
                      $hr=$hrs<10?'-0'.$hrs:'-'.$hrs;
                      $mins = abs($time_diff)%60;
                      $min=$mins<10?'0'.$mins:$mins;
                    }else{
                      $hrs=floor(abs($time_diff)/60);
                      $hr=$hrs<10?'0'.$hrs:$hrs;
                      $mins = abs($time_diff)%60;
                      $min=$mins<10?'0'.$mins:$mins;
                    }
                    
                    $total_work = $hr.':'.$min; // format the timestamp as "hour:minute AM/PM"

                  }
                  $table_data[$employee_id][$date] = 
                  array(
                    'date' => $date,
                    'employee_id' => $emp['employee_id'],
                    'total_work_time' =>$total_work,
                );
                }
          }
        }
        
?>  
<?php if(!empty($table_data)){ ?>
<div class="">
<table class="table table-striped table-sm w-25"  id="table" data-toggle="table"  data-search="true" data-pagination="true" data-page-list="[10, 25, 50, 100, all]" data-show-export="true" data-icons-prefix="fa" data-icons="icons" data-buttons-class="primary"
data-fixed-columns="true" data-fixed-number=1  data-buttons-align="left" data-search-align="left" data-show-fullscreen="true">
  <thead>
    <tr>
      <th scope="col" data-checkbox="true"></th>
      <!--<th scope="col" data-width="2" data-width-unit="%" data-align="center">SN.</th>-->
      <th scope="col" data-formatter="Textlimit">Days</th>
      <?php $i=1;
    if($month){
      foreach ($month as $date): ?>
        <th scope="col" data-align="center"><div class="th-fixedwidth" style="display: inherit;" data-align="center"><?=  date('dD',strtotime($date)); ?></div></th>
            <?php ++$i; endforeach; }?>  
            <th data-align="center">Total</th>

            <!--<th  data-field="<?php echo "operate"; ?>" data-formatter="operateFormatter" data-events="operateEvents" data-align="center">View</th>-->
            <th data-visible="false" style="display:none"   data-field="<?php echo "db_id"; ?>">ID</th>     
 
  </tr>
  </thead>
  <script>

var from_date = <?php   if($month){echo json_encode(current($month));} ?>;
var to_date = <?php   if($month){ echo json_encode(end($month)); }?>;
        </script>
  <tbody>
        <?php 
        // echo "<pre>";
        // print_r($table_data);
        $i=1;
        foreach($table_data as $employee_id => $row): ?>
            <tr>
                <td></td>
            <!--<td><?= $i;?></td>-->
                <td><?= $employee_id ?></td>
                
                <?php  $val= array();
                 if($month){
                 foreach ($month as $date):
                 ?>
                
                    <td> <?php echo $row[$date]['total_work_time']; ?></td>
                    <?php  if($row[$date]['employee_id']!=''){
                    array_push($val,$row[$date]['employee_id']); } ?>
                    <?php endforeach; }?>
                    <!--<td></td>-->
                    <td ></td>
                    <td  style="display:none"  ><?= $val[0]?></td>
                  
                   
                </tr> 
                <?php ++$i;
              endforeach; ?>
              </tbody>
              
              </table>
              <?php }elseif($from!='' &&$to!='') {?>
              <table class="table table-striped table-sm w-25"  id="table" data-toggle="table"  data-search="true" data-pagination="true" data-page-list="[10, 25, 50, 100, all]" data-show-export="true" data-icons-prefix="fa" data-icons="icons" data-buttons-class="primary"
data-fixed-columns="true" data-fixed-number=1  data-buttons-align="left" data-search-align="left" data-show-fullscreen="true">
  <thead>
    <tr>
      <th scope="col" data-checkbox="true"></th>
      <!--<th scope="col" data-width="2" data-width-unit="%" data-align="center">SN.</th>-->
      <th scope="col" data-formatter="Textlimit">Days</th>
      <?php $i=1;
    if($month){
      foreach ($month as $date): ?>
        <th scope="col" data-align="center"><div class="th-fixedwidth" style="display: inherit;" data-align="center"><?=  date('dD',strtotime($date)); ?></div></th>
            <?php ++$i; endforeach; }?>  
            <th data-align="center">Total</th>

            <!--<th  data-field="<?php echo "operate"; ?>" data-formatter="operateFormatter" data-events="operateEvents" data-align="center">View</th>-->
            <th data-visible="false" style="display:none"   data-field="<?php echo "db_id"; ?>">ID</th>     
 
  </tr>
  </thead>
  <tbody>
           <?php  // echo "<br><h4  style='color:red;text-align: center;'>No Record Found<h4>"; ?>
           </tbody>
           </table>
           <?php   } ?>
</div>

</div>

<!-- Today Details Model -->
 <div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">
<div class="modal-header">
<h1 class="modal-title fs-5" id="detailsModalLabel"></h1>
<button type="button" class="btn-close uncheck" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
 <div class="modal-body">   
 </div>
<div class="modal-footer">
 <button type="button" class="btn btn-secondary uncheck" data-bs-dismiss="modal">Close</button>
<button type="button" class="btn btn-primary uncheck" data-bs-dismiss="modal">Ok</button>
</div>
</div>
</div>
</div>
 <!-- Today Details Model end-->

<div class="clearfix"></div>

<script>
//     function operateFormatter (value, row, index) {
//     return [
//         '<a class="like" href="javascript:void(0)" title="View">',
//         '<i class="fas fa-eye" ></i>',
//         '</a> ',
       
//     ].join('');
// }

// window.operateEvents = {
  
//     'click .like': function (e, value, row, index) {
//       // for(var i=1; i<months1.length; i++){
//     var arr = JSON.stringify(row)
//     const myObj = JSON.parse(arr);
//     //   $("#db_id_yearly").val(myObj["db_id"]);
 
//             var x = myObj["db_id"]; 
          
//             $.ajax({ 
//         type: 'GET', 
//         url: "<?php echo base_url(); ?>/AttendanceReport/fetch_emp_detail_with_datewise", 
//         data:{emp_id:x,
//         from:from_date,to:to_date},
//         success: function(data) { 
//           htmlData='';
//             var parse_data = JSON.parse(data); //parse encoded data
//                  $.each(parse_data, function(index, value) {
//                   console.log(value);
//                   title='<h5 style="color:blue;"><b>Detail Of '+value.name+':-</b></h5> '
//                   if(value.start){
//                     var dateString = value.start;
//                     var date = new Date(dateString);
//                     var yr = date.getFullYear();
//                     var mo = date.getMonth() + 1;
//                     var day = date.getDate();

//                     var hours = date.getHours();
//                     var hr = hours < 10 ? '0' + hours : hours;

//                     var minutes = date.getMinutes();
//                     var min = (minutes < 10) ? '0' + minutes : minutes;

//                     var seconds = date.getSeconds();
//                     var sec = (seconds < 10) ? '0' + seconds : seconds;
//                     if(mo<10){
//                       month="0"+mo;
//                     }else{
//                       month=mo;
//                     }
//                     if(day<10){
//                       days="0"+day;
//                     }else{
//                       days=day;
//                     }
//                     var newDateString = days + '-' + month  + '-' +yr ;
//                     var newTimeString = hr + ':' + min + ':' + sec;

//                      var fromtime=newTimeString ;
//                      var date=newDateString;
//                     htmlData += '<ul><li class="text-info">Leave Start: '+date+', '+fromtime;
                  
//                     }
                 
//                   if(value.end){
//                     var dateString = value.end;
//                     var date = new Date(dateString);
//                     var yr = date.getFullYear();
//                     var mo = date.getMonth() + 1;
//                     var day = date.getDate();

//                     var hours = date.getHours();
//                     var hr = hours < 10 ? '0' + hours : hours;

//                     var minutes = date.getMinutes();
//                     var min = (minutes < 10) ? '0' + minutes : minutes;

//                     var seconds = date.getSeconds();
//                     var sec = (seconds < 10) ? '0' + seconds : seconds;
//                     if(mo<10){
//                       month="0"+mo;
//                     }else{
//                       month=mo;
//                     }
//                     if(day<10){
//                       days="0"+day;
//                     }else{
//                       days=day;
//                     }
//                     var newDateString = days + '-' + month  + '-' +yr ;
//                     var newTimeString = hr + ':' + min + ':' + sec;

//                      var totime=newTimeString ;
//                      var date=newDateString;
//                     htmlData += '<li class="text-info">Leave End: '+date+', '+totime+'</li></ul>';
                  
//                     }
                 
//                   if(value.log_type=='1'){
//                     var dateString = value.created_at;
//                     var date = new Date(dateString);
//                     var yr = date.getFullYear();
//                     var mo = date.getMonth() + 1;
//                     var day = date.getDate();

//                     var hours = date.getHours();
//                     var hr = hours < 10 ? '0' + hours : hours;

//                     var minutes = date.getMinutes();
//                     var min = (minutes < 10) ? '0' + minutes : minutes;

//                     var seconds = date.getSeconds();
//                     var sec = (seconds < 10) ? '0' + seconds : seconds;
//                     if(mo<10){
//                       month="0"+mo;
//                     }else{
//                       month=mo;
//                     }
//                     if(day<10){
//                       days="0"+day;
//                     }else{
//                       days=day;
//                     }
//                     var newDateString = days + '-' + month  + '-' +yr ;
//                     var newTimeString = hr + ':' + min + ':' + sec;

//                      var logintime=newTimeString ;
//                      var date=newDateString;
//                     htmlData += '<ul><li style="color:green;">Login: '+date+', '+logintime+'</li></ul>';
                  
//                     }
//                     if(value.log_type=='2'){
//                     var dateString = value.created_at;
//                     var date = new Date(dateString);
//                     var yr = date.getFullYear();
//                     var mo = date.getMonth() + 1;
//                     var day = date.getDate();

//                     var hours = date.getHours();
//                     var hr = hours < 10 ? '0' + hours : hours;

//                     var minutes = date.getMinutes();
//                     var min = (minutes < 10) ? '0' + minutes : minutes;

//                     var seconds = date.getSeconds();
//                     var sec = (seconds < 10) ? '0' + seconds : seconds;
//                     if(mo<10){
//                       month="0"+mo;
//                     }else{
//                       month=mo;
//                     }
//                     if(day<10){
//                       days="0"+day;
//                     }else{
//                       days=day;
//                     }
//                     var newDateString = days + '-' + month  + '-' +yr ;
//                     var newTimeString = hr + ':' + min + ':' + sec;

//                      var breaktime=newTimeString ;
//                       htmlData += '<ul><li style="color:orange;">Break: '+newDateString+', '+breaktime+'</li></ul>';
                  
//                     }
//                     if(value.log_type=='4'){
//                     var dateString = value.created_at;
//                     var date = new Date(dateString);
//                     var yr = date.getFullYear();
//                     var mo = date.getMonth() + 1;
//                     var day = date.getDate();

//                     var hours = date.getHours();
//                     var hr = hours < 10 ? '0' + hours : hours;

//                     var minutes = date.getMinutes();
//                     var min = (minutes < 10) ? '0' + minutes : minutes;

//                     var seconds = date.getSeconds();
//                     var sec = (seconds < 10) ? '0' + seconds : seconds;
//                     if(mo<10){
//                       month="0"+mo;
//                     }else{
//                       month=mo;
//                     }
//                     if(day<10){
//                       days="0"+day;
//                     }else{
//                       days=day;
//                     }
//                     var newDateString = days + '-' + month  + '-' +yr ;
//                     var newTimeString = hr + ':' + min + ':' + sec;

//                      var restarttime=newTimeString ;
//                       htmlData += '<ul><li style="color:orange;">Restart: '+newDateString+', '+restarttime+'</li></ul>';
                  
//                     }
//                     if(value.log_type=='3'){
//                     var dateString = value.created_at;
//                     var date = new Date(dateString);
//                     var yr = date.getFullYear();
//                     var mo = date.getMonth() + 1;
//                     var day = date.getDate();

//                     var hours = date.getHours();
//                     var hr = hours < 10 ? '0' + hours : hours;

//                     var minutes = date.getMinutes();
//                     var min = (minutes < 10) ? '0' + minutes : minutes;

//                     var seconds = date.getSeconds();
//                     var sec = (seconds < 10) ? '0' + seconds : seconds;
//                     if(mo<10){
//                       month="0"+mo;
//                     }else{
//                       month=mo;
//                     }
//                     if(day<10){
//                       days="0"+day;
//                     }else{
//                       days=day;
//                     }
//                     var newDateString = days + '-' + month  + '-' +yr ;
//                     var newTimeString = hr + ':' + min + ':' + sec;

//                      var logouttime=newTimeString ;
//                       htmlData += '<ul><li style="color:red;">Logout: '+newDateString+', '+logouttime+'</li></ul>';
                  
//                     }
                    
//                     $('.modal-header').html(title);
//                     // $('.modal-header.modal-title').html(title);

//                     // $('.btn-close').modal('show');

//                     $('.modal-body').html(htmlData);
//                     $('#detailsModal').modal('show');
                  
//                   });  
               
//         }, 
//         error:function(err){ 
//           alert("error"+JSON.stringify(err)); 
//         } 
//     }) 
  
// // }
// },
// }
$('#table').on('check.bs.table', function (e,row, $element) {
 // alert(row.Category);
 var arr = JSON.stringify(row)
    const myObj = JSON.parse(arr);
    //   $("#db_id_yearly").val(myObj["db_id"]);
 
            var x = myObj["db_id"]; 
          
            $.ajax({ 
        type: 'GET', 
        url: "<?php echo base_url(); ?>/AttendanceReport/fetch_emp_detail_with_datewise", 
        data:{emp_id:x,
        from:from_date,to:to_date},
        success: function(data) { 
          htmlData='';
            var parse_data = JSON.parse(data); //parse encoded data
                 $.each(parse_data, function(index, value) {
                  
                  title='<h5 style="color:blue;"><b>Detail Of '+value.name+':-</b></h5>'
                  if(value.log_type=='1'){
                    var dateString = value.created_at;
                    var date = new Date(dateString);
                    var yr = date.getFullYear();
                    var mo = date.getMonth() + 1;
                    var day = date.getDate();

                    var hours = date.getHours();
                    var hr = hours < 10 ? '0' + hours : hours;

                    var minutes = date.getMinutes();
                    var min = (minutes < 10) ? '0' + minutes : minutes;

                    var seconds = date.getSeconds();
                    var sec = (seconds < 10) ? '0' + seconds : seconds;
                    if(mo<10){
                      month="0"+mo;
                    }else{
                      month=mo;
                    }
                    if(day<10){
                      days="0"+day;
                    }else{
                      days=day;
                    }
                    var newDateString = days + '-' + month  + '-' +yr ;
                    var newTimeString = hr + ':' + min + ':' + sec;

                     var logintime=newTimeString ;
                     var date=newDateString;
                    htmlData += '<ul><li style="color:green;">Login: '+date+', '+logintime+'</li></ul>';
                  
                    }
                    if(value.log_type=='2'){
                    var dateString = value.created_at;
                    var date = new Date(dateString);
                    var yr = date.getFullYear();
                    var mo = date.getMonth() + 1;
                    var day = date.getDate();

                    var hours = date.getHours();
                    var hr = hours < 10 ? '0' + hours : hours;

                    var minutes = date.getMinutes();
                    var min = (minutes < 10) ? '0' + minutes : minutes;

                    var seconds = date.getSeconds();
                    var sec = (seconds < 10) ? '0' + seconds : seconds;
                    if(mo<10){
                      month="0"+mo;
                    }else{
                      month=mo;
                    }
                    if(day<10){
                      days="0"+day;
                    }else{
                      days=day;
                    }
                    var newDateString = days + '-' + month  + '-' +yr ;
                    var newTimeString = hr + ':' + min + ':' + sec;

                     var breaktime=newTimeString ;
                      htmlData += '<ul><li style="color:orange;">Break: '+newDateString+', '+breaktime+'</li></ul>';
                  
                    }
                    if(value.log_type=='4'){
                    var dateString = value.created_at;
                    var date = new Date(dateString);
                    var yr = date.getFullYear();
                    var mo = date.getMonth() + 1;
                    var day = date.getDate();

                    var hours = date.getHours();
                    var hr = hours < 10 ? '0' + hours : hours;

                    var minutes = date.getMinutes();
                    var min = (minutes < 10) ? '0' + minutes : minutes;

                    var seconds = date.getSeconds();
                    var sec = (seconds < 10) ? '0' + seconds : seconds;
                    if(mo<10){
                      month="0"+mo;
                    }else{
                      month=mo;
                    }
                    if(day<10){
                      days="0"+day;
                    }else{
                      days=day;
                    }
                    var newDateString = days + '-' + month  + '-' +yr ;
                    var newTimeString = hr + ':' + min + ':' + sec;

                     var restarttime=newTimeString ;
                      htmlData += '<ul><li style="color:orange;">Restart: '+newDateString+', '+restarttime+'</li></ul>';
                  
                    }
                    if(value.log_type=='3'){
                    var dateString = value.created_at;
                    var date = new Date(dateString);
                    var yr = date.getFullYear();
                    var mo = date.getMonth() + 1;
                    var day = date.getDate();

                    var hours = date.getHours();
                    var hr = hours < 10 ? '0' + hours : hours;

                    var minutes = date.getMinutes();
                    var min = (minutes < 10) ? '0' + minutes : minutes;

                    var seconds = date.getSeconds();
                    var sec = (seconds < 10) ? '0' + seconds : seconds;
                    if(mo<10){
                      month="0"+mo;
                    }else{
                      month=mo;
                    }
                    if(day<10){
                      days="0"+day;
                    }else{
                      days=day;
                    }
                    var newDateString = days + '-' + month  + '-' +yr ;
                    var newTimeString = hr + ':' + min + ':' + sec;

                     var logouttime=newTimeString ;
                      htmlData += '<ul><li style="color:red;">Logout: '+newDateString+', '+logouttime+'</li></ul>';
                  
                    }
                    $('.modal-title').html(title);
                    $('.modal-body').html(htmlData);
                    $('#detailsModal').modal('show');
                  
                  });  
               
        }, 
        error:function(err){ 
          alert("error"+JSON.stringify(err)); 
        } 
    }) 
 

})
  $('.uncheck').click(function () {
      $('#table').bootstrapTable('uncheckAll')
    })
</script>
       
<?= $this->endSection(); ?>
