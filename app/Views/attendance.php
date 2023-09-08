<?= $this->extend('include/header.php') ?>

<?= $this->section('content') ?>
<div class="container">
    <div class="row">
        <div class="col-lg-12 my-2 ">
            <div class="text-center mb-2"><img src="<?php echo base_url('public/images/welcome_mark-final2.gif'); ?>"   class="img-fluid" style="width: 600px;" class="text-center"></div>
            <h5 class="text-center fw-bold">Welcome</h5>

            <h5 class="text-center fw-bold text-danger"><?= trim($session->get('username')," ");?>,</h5>
            <div class="text-center star_wrapper">
                <h4 class="fw-bold">ATTENDANCE</h4>
                <hr class="top-Line"></hr><i class="fas fa-star fa-xs icons_rotate forlunch" ></i><hr class="top-Line"></hr>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="container">
    <form action="<?= base_url('Attendance/add') ?>" method="POST">
        <?php if ($session->getFlashdata('error')) : ?>
            <div class="alert alert-danger rounded-0 hidemsg justify-content-center">
                <?= $session->getFlashdata('error') ?>
            </div>
        <?php endif; ?>
        <?php if ($session->getFlashdata('success')) : ?>
            <div class="alert alert-success rounded-0 hidemsg justify-content-center">
                <?= $session->getFlashdata('success') ?>
            </div>
        <?php endif; ?>
        <!--eye btn-->
        <div class="row justify-content-center">
           <div class="col-md-1">
               <div class="input-group justify-content-center">
                  <button type="button" class="btn btn-Success mb-1"  data-bs-toggle="modal" data-bs-target="#detailsModal"><i class="fas fa-eye"></i></button>
               </div>
            </div> 
        </div> 
        <!--eye btn-->
        <!--login btn-->
        <div class="row justify-content-center">
            <div class="col-md-2 col-sm-6">
                <div class="input-group mb-3 justify-content-center">
                    <button type="button" class="btn btn-primary me-1 notes_w" data-bs-toggle="modal" data-bs-target="#loginNotesModal"><i class="fas fa-info-circle"></i></button>
                    <button class="btn btn-primary atte_btn_w" name="log_in"><i class="fas fa-user"></i> Login</button>
                </div>
            </div>
        </div>
       <!--login btn end-->

        <?php //echo $loginCount . '->Login------>Logout' . $logoutCount . "<br>";
       //echo $breakCount . '->break------>Restart' . $RestartCount . "<br>";
         // echo $prevLoginCount . '->prevLogin------>prevLogout' . $prevLogoutCount . "<br>";
       //echo $status;
        if ($breakCount == 0 || $breakCount == $RestartCount || ($loginCount > $logoutCount && $status!=2)) { ?>
            <div class="row justify-content-center">
                <div class="col-md-4 col-sm-6">
                    <div class="input-group mb-3 justify-content-center">
                        <button type="button" class=" btn btn-warning me-1 notes_w" data-bs-toggle="modal" data-bs-target="#breakNotesModal"><i class="fas fa-info-circle"></i></button>
                        <button class="btn btn-warning atte_btn_w" name="break" id="break"><i class="fas fa-arrow-alt-circle-right"></i> Break</button>
                        </div>
                </div>
            </div>
            <?php } else {
            if ($breakCount > $RestartCount && ($loginCount > $logoutCount || $status==2 )) { ?>
                <div class="row justify-content-center">
                    <div class="col-md-4 col-sm-6">
                        <div class="input-group mb-3 justify-content-center">
                            <button type="button" class="btn btn-warning me-1" data-bs-toggle="modal" data-bs-target="#restartNotesModal"><i class="fas fa-info-circle"></i></button>
                            <button class="btn btn-warning" name="restart" id="restart"><i class="fas fa-arrow-alt-circle-right"></i> Restart</button>
                    
                        </div>
                    </div>
                </div>
        <?php
            }
        } ?>
        <div class="row justify-content-center">
            <div class="col-md-2 col-sm-6">
                <div class="input-group mb-3 justify-content-center">
                    <button type="button" class=" btn btn-danger me-1 notes_w" data-bs-toggle="modal" data-bs-target="#logoutNotesModal"><i class="fas fa-info-circle"></i></button>
                     <?php // if ($prevLoginCount> $prevLogoutCount) { ?>
                    <!--<button class="btn btn-danger"  disabled name="log_out"><i class="fas fa-user"></i> Logout</button>-->
                    <?php //}else{ ?>
                        <button class="btn btn-danger atte_btn_w" name="log_out"><i class="fas fa-user"></i> Logout</button>
                        <?php //} ?>
                </div>
            </div>
        </div>
    </form>
</div>

<!--leave and Report-->
<div class="row justify-content-center">
    <div class="col-md-2 col-sm-2">
       <div class="input-group mb-3 justify-content-center">
            <button type="button" class="btn btn-info me-1 notes_w" id="vLeave"><i class="fas fa-eye"></i></button>

            <button type="button" class="btn btn-info atte_btn_w" data-bs-toggle="modal" data-bs-target="#leaveModal"><i class="fas fa-user"></i>  Leave</button>
        </div>
    </div>

    <div class="col-md-2 col-sm-2">
        <div class="input-group mb-2 justify-content-center">
            <button type="button" class="btn btn-info me-1 notes_w" data-bs-toggle="modal" data-bs-target="#templateModal"><i class="fas fa-info-circle"></i></button>
            <!--<button type="button" class="btn btn-info me-1 notes_w" data-bs-toggle="modal" data-bs-target="#templateModal"><i class="fas fa-info-circle"></i></button>-->
           <button type="button" class="btn btn-info atte_btn_w" data-bs-toggle="modal" data-bs-target="<?php if($template){echo "#ReporttempModal";}else{ echo "#ReportModal";} ?>"><i class="fas fa-user"></i> Report</button>
            <!--<button type="button" class="btn btn-info me-1 notes_w" data-bs-toggle="modal" data-bs-target="#templateViewModal"><i class="fas fa-eye"></i></button>-->
        </div>
    </div>
</div>
<!-- -leave and report end-->
<!-- Today Details Model -->
<?php
$now = (new \CodeIgniter\I18n\Time("now", "GMT+5:30", "de_DE"));
           
?>
 <div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">
<div class="modal-header">
<h1 class="modal-title fs-5" id="detailsModalLabel"><h5 style="color:blue;"><b>Today's Detail (<?php echo date('d-m-Y',strtotime($now));; ?>)</b></h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
 <div class="modal-body">
 <div class="input-group sm-3">
 <ol>
           <?php 
           if($EmpAttDet){
            foreach($EmpAttDet as $attDet){
                $date=date('h:i A',strtotime($attDet['created_at']));
  ?>
            
                    <?php if($attDet['log_type']==1){ echo   "<li style='color:green;'>Login: ".$date."</li>"; } ?>
                    
                      <?php if($attDet['log_type']==2 && $attDet['lunch_break']==0){   echo "<li style='color:orange;'>Break: ".$date."</li>"; } ?>
                    
                    <?php  if($attDet['log_type']==4 && $attDet['lunch_break']==0){    echo "<li style='color:orange;'>Restart: ".$date."</li>"; } ?>
                  
                    <?php    if($attDet['log_type']==3){   echo "<li style='color:red;'>Logout: ".$date."</li>"; } ?>
                       
                <?php
             
            }
            } ?>
                 </ol>
                </div>      
 </div>
<div class="modal-footer">
 <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
<button type="button" class="btn btn-primary" data-bs-dismiss="modal">Ok</button>
</div>
</div>
</div>
</div>
 <!-- Today Details Model end-->
 <!-- -Login Note-->
<div class="modal fade" id="loginNotesModal" tabindex="-1" aria-labelledby="notesModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="notesModalLabel">Add Login Notes</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('Attendance/noteAttendanceAdd'); ?>" method="post">

                    <div class="input-group mb-3">
                        <input type="datetime-local" name="datetime" class="form-control" required>
                        <input type="hidden" class="form-control" aria-label="log_type" name="log_type" value='1'>

                    </div>
                    <input type="text" class="form-control" placeholder="Add Notes" aria-label="Addnotes" name="Addnotes" aria-describedby="Addnotes" required>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" name="loginNote" class="btn btn-primary">Send For Approval</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- -login Note end-->
<!-- -Break Note-->
<div class="modal fade" id="breakNotesModal" tabindex="-1" aria-labelledby="notesModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="notesModalLabel">Add Break Notes</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('Attendance/noteAttendanceAdd'); ?>" method="post">

                    <div class="input-group mb-3">
                        <input type="datetime-local" name="datetime" class="form-control" required>
                        <input type="hidden" class="form-control" aria-label="log_type" name="log_type" value='2'>

                    </div>
                    <input type="text" class="form-control" placeholder="Add Notes" aria-label="Addnotes" name="Addnotes" aria-describedby="Addnotes" required>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" name="breakNote" class="btn btn-primary">Send For Approval</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- -break Note end-->
<!-- -Restart Note-->
<div class="modal fade" id="restartNotesModal" tabindex="-1" aria-labelledby="notesModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="notesModalLabel">Add Restart Notes</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('Attendance/noteAttendanceAdd'); ?>" method="post">

                    <div class="input-group mb-3">
                        <input type="datetime-local" name="datetime"  class="form-control" required>
                        <input type="hidden" class="form-control" aria-label="log_type" name="log_type" value='4'>

                    </div>
                    <input type="text" class="form-control" placeholder="Add Notes" aria-label="Addnotes" name="Addnotes" aria-describedby="Addnotes" required>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" name="restartNote" class="btn btn-primary">Send For Approval</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- -Restart Note end-->
<!-- -Logout Note-->
<div class="modal fade" id="logoutNotesModal" tabindex="-1" aria-labelledby="notesModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="notesModalLabel">Add Logout Notes</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('Attendance/noteAttendanceAdd'); ?>" method="post">

                    <div class="input-group mb-3">
                        <input type="datetime-local" name="datetime"  class="form-control" required>
                        <input type="hidden" class="form-control" aria-label="log_type" name="log_type" value='3'>

                    </div>
                    <input type="text" class="form-control" placeholder="Add Notes" aria-label="Addnotes" name="Addnotes" aria-describedby="Addnotes" required>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" name="logoutNote" class="btn btn-primary">Send For Approval</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- -logout Note end-->
<!-- Apply Leave Model -->
<div class="modal fade" id="leaveModal" tabindex="-1" aria-labelledby="notesModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">
<div class="modal-header">
<h1 class="modal-title fs-5" >Apply For Leave</h1>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
<form method="post">
<input type="hidden" id="save_id" name="save_id" >

<div class="mb-3">
<div class="input-group">
  <span class="input-group-text " id="from">From:</span>
  <input type="datetime-local" name="from_datetime" id="from_time" class="form-control">
</div>
<span class="text-danger"><?=  displayError($validation,'from_datetime')?><span> 
</div>

<div class="mb-3">
  <div class="input-group">
   <span class="input-group-text pe-4" id="from">To:</span>
   <input type="datetime-local" name="to_datetime" id="to_time" class="form-control" >          
</div>
  <span class="text-danger"><?=  displayError($validation,'to_datetime')?><span> 
 </div>

<div class="mb-3">
<!-- <input type="text" class="form-control mb-3" placeholder="Add Notes:" aria-label="Addnotes" aria-describedby="Addnotes"> -->
  <textarea class="form-control" name="Addleavenotes" id="Addleavenotes" placeholder="Add Notes:" rows="2"></textarea>
  <span class="text-danger"><?=  displayError($validation,'Addleavenotes')?><span>
</div>

             
<input type="text" class="form-control" placeholder="Email:" name="email" id="emailto" aria-describedby="email">
<span class="text-danger"><?=  displayError($validation,'email')?><span>
             
 </div>
<div class="modal-footer">
<button type="submit" name="" class="btn btn-primary" formaction="<?= base_url('Attendance/saveLeave'); ?>">Save</button>
<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
<button type="submit" name="save" formaction="<?= base_url('Attendance/addLeave'); ?>"  class="btn btn-primary">Apply</button>
</form>
 </div>
</div>
</div>
</div>
<!-- Appl leave Model end-->

     <!-- -leave table-->
<div class="row justify-content-center">
    <div class="col-md-5 col-sm-12 mb-3">
        <table class="table table-striped table-sm"   id="ltable" style="display:none" data-toggle="table" 

data-buttons-class="success"
data-icons-prefix="fa" data-icons="icons"
data-search-align="left"
data-buttons-align="left"  >
          <thead>
            <tr>
                <!--<th scope="col" data-width="2" data-width-unit="%" data-align="center"> SNo.</th>-->
                <th scope="col">Start Date</th>
                <th scope="col">End Date</th>
                <th scope="col">Status</th>
                <th data-field="operate" data-formatter="operateFormatter" data-events="operateEvents" data-align="center">Action</th>
                <th style="display:none" data-visible="false" data-field="db_id">ID</th>
            </tr>
          </thead>
          <?php if($empLeave){
            $i=1;
          foreach($empLeave as $leave){ 
            $end_date='00-00-0000, 0:00';
            $start_date='00-00-0000, 0:00';
            if($leave['end']!='0000-00-00 00:00:00' ){
                $end_date=  date('d-m-Y, h:iA',strtotime($leave['end']));
              }
              if($leave['start']!='0000-00-00 00:00:00'  ){
                $start_date=  date('d-m-Y, h:iA',strtotime($leave['start']));
              }
              if($leave['status']!='Plan'){?>
            <tr>   
                    <!--<td><?= $i; ?></td>-->
                    <td title="<?= $leave['leave_reason'] ?>"><?= $start_date ?></td>
                    <td><?= $end_date ?></td>
                    <td><?= $leave['status']; ?></td>

                    <td></td>      
                    <td style="display:none"><?= $leave['id']; ?></td>
                </tr>
            <?php }else{ ?>
            <tr style="background-color:#ffbb33fc">   
                    <!--<td><?= $i; ?></td>-->
                    <td title="<?= $leave['leave_reason'] ?>"><?= $start_date ?></td>
                    <td><?= $end_date ?></td>
                    <td><?= $leave['status']; ?></td>
                    <td></td>
                    <td style="display:none" ><?php echo $leave['id']; ?></td>
                </tr>
            <?php }
         ++$i;   }
        } ?>
            
       </table>
    </div>
</div>

    
<!-- -leave table end-->
<!-- Delete Modal -->
<div class=" modal fade " id="DeleteLeave" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">DELETE LEAVE</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      Are you sure you want to DELETE?
      <form action="<?php echo base_url('Attendance/deleteLeave'); ?>" method="post">
       <input type="hidden" class="form-control" name="del_db_id"  id="del_db_id">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Yes</button></form>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
       
      </div>
    </div>
  </div>
</div>
<!-- ####################################Delete Modal############################################# -->

<!-- template Model -->
<div class="modal fade" id="templateModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="templateModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">
<div class="modal-header">
    <h1 class="modal-title fs-5" >Create Template</h1>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <form action="<?= base_url('Report/template_create'); ?>" method="post">
     <div class="head">
       <div class="input-group mb-3">
            <input class="form-control" type="text" placeholder="Create Head" name="template" required>
            <span class="input-group-text add_field" ><i class="fas fa-plus-circle"></i></span>
            <!-- <span class="input-group-text" ><i class="fas fa-times-circle"></i></span> -->
        </div>
    </div>
<?php if($template){?>
   <table class="table table-striped table-hover table-bordered table-sm addonerow" data-toggle="table" id="tbl_temp_click">
         <thead>
            <tr>
              
              <th data-field="Temp_view">Template</th>
              <th style ="display:none;" data-visible="false" data-field="hidden">ID hidden</th>
            </tr>
          </thead>
          <tbody>
          <?php  
          
          foreach ($template as $temp) { ?>
          <tr>
           
            <td class="p-0" title="Click to delete Template"> <div class="input-group"><input class="form-control " type="text" placeholder="Read Head" name="template_edit[]"  value="<?= $temp["template"]; ?>" disabled>
               <span class="input-group-text delete"><i class="fas fa-times-circle"></i></span></div></td>
               <td><?= $temp["id"]; ?></td>
          </tr>

        <?php 
           ++$i;

            } 
          
            ?>
        </tbody>
        </table>
<?php }?> 
 </div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <button type="submit" name="save" class="btn btn-primary">Save</button></form>
            
</div>

</div>
</div>
</div>
<!-- template Model end-->
<!-- Report Model-->

<div class="modal" id="ReportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">
<div class="modal-header">
    <h1 class="modal-title fs-5" >Report</h1>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">

    <form action="<?= base_url('Report/add_report_modal'); ?>" method="post">
       <div class="input-group mb-3">
            <span class="input-group-text " id="" >Date:</span>
            <input type="date" name="date" value=""  class="form-control" id="date_without_temp" required>
        </div>
        <textarea class="form-control mb-3" name="report" placeholder="Add Details:" id="report" rows="2" required></textarea >


 <?php if($share_template){ ?>


  
  <?php  foreach ($share_template as $sharetemp) { ?> 
  <h6 class="fw-bold">Shared Template By  <?php echo  $sharetemp["name"]; 
      $this->db = db_connect();
      $builder = $this->db->table("rep_template as rt");
      $builder->select('rt.*');
      $builder->where('rt.updated_by',$sharetemp["emp_id"]);
      $builder->where('rt.status','Active');
      $query = $builder->get()->getResultArray();
    //   print_r( $query);



?></h6>
  <table class="table table-striped table-hover table-bordered table-sm" id="tbl_share">
 <thead>
    <tr>
      <th scope="col">Head </th>
      <th scope="col">Details</th>
    </tr>
  </thead>
  <?php if($query){ ?>
  <?php  foreach ($query as $qu) { ?>
  <tr>
    <td><?= $qu["template"] ?><input type="hidden" class="<?php echo  $sharetemp["name"];?>" name="temp_id_share[]" value="<?= $qu["id"]?>"></td>
    <td class="p-0"><textarea class="form-control form-control-sm <?php echo  $sharetemp["name"];?>" name ="details_share[]" rows="2" required></textarea></td>
  </tr>
<?php       } 
        }else{

?>
    <tr>
         <td class="p-0"><textarea class="form-control form-control-sm <?php echo  $sharetemp["name"];?>" name ="temp_id_share[]" rows="2"  readonly> By <?php echo  $sharetemp["name"];?></textarea></td>
         <!--<td  class="w-25">By <?php echo  $sharetemp["name"];?></td>-->

          <td class="p-0"><textarea class="form-control form-control-sm <?php echo  $sharetemp["name"];?>" name ="details_share[]" rows="2" required></textarea></td>
    </tr>
  

 <?php   }?>
 </table>
            
    <?php    } 
    }
?>
 </div>
<div class="modal-footer">
     <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#shareModal"><i class="fas fa-share"></i></button>
     <button type="button" name="" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#stopshareModal"><i class="fas fa-window-close"></i></button>
     <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#templateViewModal"><i class="fas fa-edit"></i></button>
     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
     <button type="submit" name="save" class="btn btn-primary">Save</button></form>
</div>

</div>
</div>
</div>
<!-- Report Model end-->


         <!-- <button type="button" class="btn btn-primary atte_btn_w" data-bs-toggle="modal" data-bs-target="#ReporttempModal"><i class="fas fa-user"></i> Report</button> -->

<!-- Report template Model -->
<div class="modal" id="ReporttempModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"  aria-labelledby="reporttempModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">
<div class="modal-header">
    <h1 class="modal-title fs-5" >Report</h1>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <form action="<?= base_url('Report/add_report'); ?>" method="post">

    <div class="input-group mb-3">
            <span class="input-group-text " >Date:</span>
            <input type="date" name="date" value="" id="date_with_temp" class="form-control" required>
    </div>
<table class="table table-striped table-hover table-bordered table-sm" id="tbl">
 <thead>
    <tr>
      <th scope="col">Head</th>
      <th scope="col">Details</th>
    </tr>
  </thead>
  <?php  
  if($template){
  
  foreach ($template as $temp) { ?>
  <tr>
    <td><?= $temp["template"] ?><input type="hidden" name="temp_id[]" value="<?= $temp["id"]?>"></td>
    <td class="p-0"><textarea class="form-control form-control-sm" name ="details[]" rows="2" required></textarea></td>
  </tr>
<?php
  }
} ?>
</table>
<?php if($share_template){ ?>


  <?php  foreach ($share_template as $sharetemp) { ?>
     <h6>Shared Template By<b> <?php echo  $sharetemp["name"]; ?></b></h6>
      <?php
      $this->db = db_connect();
      $builder = $this->db->table("rep_template as rt");
      $builder->select('rt.*');
      $builder->where('rt.updated_by',$sharetemp["emp_id"]);
      $builder->where('rt.status','Active');
      $query = $builder->get()->getResultArray();
      



?>
  <table class="table table-striped table-hover table-bordered table-sm" id="tbl_share">
 <thead>
    <tr>
      <th scope="col">Head</th>
      <th scope="col">Details</th>
    </tr>
  </thead>
  <?php if($query){ ?>
  <?php  foreach ($query as $qu) { ?>
  <tr>
    <td><?= $qu["template"] ?><input type="hidden"  class="<?php echo  $sharetemp["name"];?>" name="temp_id_share[]" value="<?= $qu["id"]?>"></td>
    <td class="p-0"><textarea class="form-control form-control-sm <?php echo  $sharetemp["name"];?>" name ="details_share[]" rows="2" required></textarea></td>
  </tr>
<?php       }

        }else{ ?>
        <tr>
         <td class="p-0"><textarea class="form-control form-control-sm <?php echo  $sharetemp["name"];?>" name ="temp_id_share[]" rows="2"  readonly> Report shared By <?php echo  $sharetemp["name"];?></textarea></td>
          <td class="p-0"><textarea class="form-control form-control-sm <?php echo  $sharetemp["name"];?>" name ="details_share[]" rows="2" required></textarea></td>
    </tr>
 

 <?php   
            }?>
             </table>
    <?php    } 
    }
?>
</div>

<div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#shareModal"><i class="fas fa-share"></i></button>
        <button type="button" name="" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#stopshareModal"><i class="fas fa-window-close"></i></button>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#templateViewModal"><i class="fas fa-edit"></i></button>

        <button type="button" name="add" class="btn btn-primary addrow" id="add_temp"><i class="fas fa-plus"></i></button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" name="save" class="btn btn-primary">Send</button></form>
</div>

</div>
</div>
</div>
<!-- Report template Model end-->
<!-- Stop Share report backup-->
<div class="modal" id="stopshareModal" tabindex="-1" aria-labelledby="shareModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="shareModalLabel"> Stop Share Backup</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
       <form action="<?= base_url('Report/stop_share_report'); ?>" method="post">
        <div class="modal-body">
        
        <div class="mb-3">
         <input class="form-control" type="date" placeholder="" name="stop_share_date">
        </div>
        
         <?php if($my_share){?>
            <label>Active Sharing</label>
            <div class="mb-3">
            <?php foreach($my_share as $ms){?>
                <input class="form-control" type="text" title="Information About Sharing" placeholder="" value="Report shared to <?php echo $ms['name']; ?> on <?php echo date('d-m-Y',strtotime($ms['shared_date'])); ?>" name="info_date" disabled>
            <?php
                }
            } ?>
            </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Send</button></form>
      </div>
    </div>
  </div>
</div>
<!-- Stop Share report backup end-->
<!--Share report backup-->
<div class="modal" id="shareModal" tabindex="-1" aria-labelledby="shareModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="shareModalLabel">Share Backup</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
       <form action="<?= base_url('Report/share_report'); ?>" method="post">
        <div class="modal-body">
        <div class="mb-3">
         <input class="form-control" type="date" placeholder="" name="share_date">
         <span class="text-danger"><?= displayError($validation, 'share_date') ?></span>
        </div>
       
        <div class="mb-3">
         <input class="form-control" type="text" placeholder="Enter Email Id:" name="share_email">
         <span class="text-danger"><?= displayError($validation, 'share_email') ?></span>
        </div>

       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Send</button></form>
      </div>
    </div>
  </div>
</div>
<!--Share report backup end-->
<!-- Report templateViewModal Model -->
<div class="modal" id="templateViewModal" tabindex="-1" aria-labelledby="reporttempModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">
<div class="modal-header">
    <h1 class="modal-title fs-5" >Edit Report</h1>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <form action="<?= base_url('Report/edit_report'); ?>" method="post">

    <div class="input-group mb-3">
            <span class="input-group-text " id="">Date:</span>
            <input type="date" name="date_add" id="date_add" value=""  class="form-control" required>
    </div>
    
<table class="table table-striped table-hover table-bordered table-sm" id="tbl_view">
 <thead>
    <tr>
      <th scope="col">Head</th>
      <th scope="col">Details</th>
    </tr>
  </thead>
  <?php if($template){?>
  <tbody>
  <?php  foreach ($template as $temp) { ?>
  <tr>
    <td><?= $temp["template"] ?><input type="hidden" name="temp_id[]" value="<?= $temp["id"]?>" disabled></td>
    <td class="p-0"><textarea class="form-control form-control-sm" name ="details[]" rows="2"></textarea></td>
  </tr>
        <?php    } ?>
        </tbody>
    <?php }else{?>
       <tbody>
        <tr>
            <td></td>
            <td class="p-0"><textarea class="form-control form-control-sm" name ="details[]" rows="2"></textarea></td>
        </tr>
       </tbody> 
    <?php    } ?>
    </table>
</div>
   
<div class="modal-footer">
        <!--<button type="button" name="add" class="btn btn-primary addrow" id="add_temp">Add</button>-->
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" name="save" class="btn btn-primary">Send</button></form>
</div>

</div>
</div>
</div>
<!-- Report templateViewModal Model end-->


<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
  
  $(document).ready(function() {
    <?php if($session->getflashdata('status')){?>
        swal({
  title: "<?= $session->getflashdata('status') ?>",
  text: "<?= $session->getflashdata('status_text')?>",
  icon: "<?= $session->getflashdata('status_icon')?>",
   button: {
    text: "OK",
    className: "btn btn-primary",
  },
});

 <?php }?>
  });
 $(document).ready(function(){
  $("#vLeave").click(function(){
    $("#ltable").fadeToggle(1000);

  });
}); 
    
    $(function() {
     $(".hidemsg").hide(10000);
   });
function operateFormatter (value, row, index) {
    return [
        '<a class="like" href="javascript:void(0)" title="Edit">',
        '<i class="fas fa-edit" ></i>',
        '</a> ',
        '<a class="danger remove" href="javascript:void(0)"  title="Remove">',
        '<i class="fas fa-trash-alt"></i>',
        '</a>'
    ].join('');
}



window.operateEvents = {
    'click .like': function (e, value, row, index) {
      
    var arr = JSON.stringify(row)
    const myObj = JSON.parse(arr);
   
    //   $("#db_id_yearly").val(myObj["db_id"]);
   
            var y = myObj["db_id"]; 
            $.ajax({ 
        type: 'GET', 
        url: "<?php echo base_url(); ?>/Attendance/fetch_emp_leave/" + y, 
        data:'',
        success: function(data) { 
            var parse_data = JSON.parse(data); //parse encoded data
                 $.each(parse_data, function(index, value) {
                    console.log(value);
                    var notes=value['leave_reason'];
                    var to_time=value['end'];
                    var from_time=value['start'];
                    var email=value['email_to'];
                    var leave_id=value['id'];
                    var em=$('#emailto')
                        em.val(email)
                    var td=$('#to_time')
                        td.val(to_time) 
                    var fd=$('#from_time')
                        fd.val(from_time)    
                    var md=$('#Addleavenotes')
                       md.val(notes)
                    var ld=$('#save_id')
                       ld.val(leave_id) 
                       $("#leaveModal").modal('show');
                });  
               
        }, 
        error:function(err){ 
          alert("error"+JSON.stringify(err)); 
        } 
    }) 
},
'click .remove': function (e, value, row, index) {
    $('#DeleteLeave').modal('show');
       var arr_del = JSON.stringify(row);
        const myObj_del = JSON.parse(arr_del);
        $("#del_db_id").val(myObj_del["db_id"]);
      
    }
}
</script>
<script type="text/javascript">
$(document).ready(function() {
    var addrow = $(".addonerow");
    var add_btn = $(".add_field");
    var head_read = $(".head_read");


    $(add_btn).click(function(e) {
   
      $(addrow).append('<tr><td class="p-0"><div class="input-group"><input class="form-control" type="text" placeholder="Create Head" name="template_1[]" id="template_1" required><span class="input-group-text delete" ><i class="fas fa-times-circle"></i></span></div></td></tr>'); //add input box
      
    })

    $(addrow).on("click", ".delete", function(e) {
        $(this).parent('div').remove();
    })

    //report row addition

    $("#add_temp").click(function(e) {
        // alert("hii");
        $("#tbl").append('<tr><td class="p-0 w-25"><textarea class="form-control" name="temp_id[]" rows="2"></textarea></td><td class="p-0"><div class="input-group"><textarea class="form-control" name ="details[]" rows="2"></textarea><span class="input-group-text delete"><i class="fas fa-times-circle"></i></span></div></td></tr>');

    })
    
    $("#tbl").on("click", ".delete", function(e) {
        $(this).closest("tr").remove();    
    })
});

///////////////////////////////////////Template Delete///////////////////////////////////////////
    $('#tbl_temp_click').on('click-row.bs.table', function (e,row, $element) {
         //    alert("hii")
         // alert(row.hidden);
         var data = {
          'id_temp':row.hidden,
          
         };  

        $.ajax({
            type:"POST",
            url:"<?php echo base_url('Report/del_template') ?>",
            data:data,
            success :function (data) {
                
                location.reload();
                
            }
            
        })
        
     })
///////////////////////////////////////Template Delete///////////////////////////////////////////
///////////////////////////////////Reoprt Edit////////////////////////////////////////////////////

$("#date_add").change(function(){
    // alert("on change");
    var data = {
          'date_add': $("#date_add").val(),
          'user_name':"<?php echo $session->get('employe_id'); ?>",
          
         };
        $.ajax({
            type:"POST",
            url:"<?php echo base_url('Report/get_detail') ?>",
            data:data,
            success :function (data) {
                // alert(data);
                // $(this).parent('div').remove();
                 $('#tbl_view > tbody').find('tr').remove();
                 data1 = JSON.parse(data);
                 var i =0;
                function myFunction(){
                    if(data1[i].template == null){
                        var template = data1[i].template_id;
                    }else{
                         template = data1[i].template;
                    }
                    // alert(isNaN(data1[i].template));
                    if(data1[i].share == 1 && data1[i].name != null){
                        var share = '(shared by '+data1[i].name+')';
                    }else{
                        share ='';
                    }
                    
                    $("#tbl_view").append('<tr><td class="p-0"><textarea class="form-control form-control-sm" name="temp_id[]" rows="2" disabled>'+template+''+share+'</textarea></td><td class="p-0"><textarea class="form-control form-control-sm" name ="details[]" rows="2" >'+data1[i].report+'</textarea><input type="hidden" name ="id_edit[]" value="'+data1[i].rep_id+'"></td></tr>');
                    i++;
                }

               data1.forEach(myFunction);
            }
            
        })
   
});
///////////////////////////////////Reoprt Edit////////////////////////////////////////////////////
//////////////////////////////Report Date change////////////////////////////////////////////
$("#date_without_temp").change(function(){
    // alert("on change");
    var date = $("#date_without_temp").val();
    var data = {
          
          'user_name':"<?php echo $session->get('employe_id'); ?>",
         };
        $.ajax({
            type:"POST",
            url:"<?php echo base_url('Report/get_share_date') ?>",
            data:data,
            success :function (data) {
                data1 = JSON.parse(data);
                var i =0;
                function myFunction(){
                    if(data1[i].shared_date > date){
                        // alert(data1[i].name);
                        // $("input").attr("disabled", true);
                         $("."+data1[i].name).attr("disabled", true);
                    }else if(data1[i].shared_date <= date){
                        $("."+data1[i].name).attr("disabled", false);
                    }

                   i++;
                }
                
                data1.forEach(myFunction);


            
            }
            })
   
});

$("#date_with_temp").change(function(){
    // alert("on change");
    var date = $("#date_with_temp").val();

    var data = {
          
          'user_name':"<?php echo $session->get('employe_id'); ?>",
         };
        $.ajax({
            type:"POST",
            url:"<?php echo base_url('Report/get_share_date') ?>",
            data:data,
            success :function (data) {
                // alert(data);
                data1 = JSON.parse(data);
                var i =0;
                function myFunction(){
                    if(data1[i].shared_date > date){
                        // alert(data1[i].name);
                        // $("input").attr("disabled", true);
                         $("."+data1[i].name).attr("disabled", true);
                    }else if(data1[i].shared_date <= date){
                        $("."+data1[i].name).attr("disabled", false);
                    }

                   i++;
                }
                
                data1.forEach(myFunction);
            }
            })
   
});

//////////////////////////////Report Date change////////////////////////////////////////////

</script>

<?= $this->endSection() ?>