<?= $this->extend('include/header.php') ?>
<?= $this->section('content') ?>
<style>
.form-control-sm {
  height: calc(1.5em + 2.3rem + 2px) !important;
  }
  input:invalid {
    background-color: ivory;
    border: none;
    outline: 2px solid red;
    border-radius: 5px;
 }
</style>
<?php $session = session();
?>
<div class="container">
    <div class="row">
        <div class="col-lg-12 my-4 ">
            <h4 class="text-center fw-bold">STAFF MASTER</h4>
               <div class="text-center star_wrapper">
                 <hr class="top-Line"></hr><i class="fas fa-star fa-xs icons_rotate"></i><hr class="top-Line"></hr>
             </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="container">
    <!-- btn -->
    <div class="row justify-content-center">
        <div class="col">
            <!--<button type="button" class="btn btn-success mb-4" id="Discontiuation">Discontiuation</button>-->
            <!--<button type="button" class="btn btn-success mb-4 " id="reactivate">Reactivate</button>-->
            <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#sendmail">Send Email</button>

        </div>
    </div>

    <!-- Staff Info & ATTENDANCE start -->
    <?php
    if ($employee_detail) {
        $i = 1;

        foreach ($employee_detail as $empDet) {  ?>
            <form action="<?php echo base_url('Employee/update/' . $empDet['emp_id']); ?>" method="post"  enctype="multipart/form-data">
                <input type="hidden" name="_method" value="PUT" />
                <div class="mb-3">
                    <input type="hidden" class="form-control" id="doc_id" name="doc_id" value="<?php echo $empDet['emp_doc_id']  ?>">
                    <input type="hidden" class="form-control" id="user_id" name="user_id" value="<?php echo $empDet['ur_id']  ?>">
                    <input type="hidden" class="form-control" id="discont_id" name="discont_id" value="<?php echo $empDet['discont_id']  ?>">
                    <input type="hidden" class="form-control" id="attend_id" name="attend_id" value="<?php echo $empDet['atten_id']  ?>">

                </div>
                <div class="row justify-content-center">
                    <div class="col">
                        <fieldset class="formborder p-1">
                            <legend class="float-none w-auto fs-5 fw-semibold">Staff Info</legend>
                            <div class="row justify-content-center">
                                <div class="col-md-5">
                                    <div class="form-group form-control-sm">
                                        <label class="fw-semibold">Legal Name</label>
                                        <div>

                                            <input type="text" id="legalname" name="legalname" value="<?php echo $empDet['legal_name']; ?>" class="form-control" maxlength="25">

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group form-control-sm">
                                        <label class="fw-semibold">Personal Email Id</label>
                                        <div><input type="email" id="personalemailid" name="personalemailid" value="<?php echo $empDet['per_email_id']; ?>" class="form-control" maxlength="30"></div>

                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="col-md-5">
                                    <div class="form-group form-control-sm">
                                        <label class="fw-semibold">Personal Contact No.</label>
                                        <div><input type="text" id="percontactno" name="percontactno" value="<?php echo $empDet['per_mobile_no']; ?>" class="form-control" maxlength="20"></div>

                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group form-control-sm">
                                        <label class="fw-semibold">Current Location</label>
                                        <div><input type="text" id="currentlocation" name="currentlocation" value="<?php echo $empDet['emp_current_address']; ?>" class="form-control" maxlength="15"></div>


                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="col-md-5">
                                    <div class="form-group form-control-sm">
                                        <label class="fw-semibold">Date of Birth</label>
                                         <?php $date=date_create(date("Y-m-d"));
                                         $date->setDate($date->format("Y"),$date->format("m"),$date->format("t"));
                                         $date->format("Y-m-t");
                                         $mon=date("m");
                                         date_sub($date,date_interval_create_from_date_string("22 years $mon months")); ?>
                                        <div><input type="date" id="dob" name="dob" value="<?php echo $empDet['dob']; ?>" max="<?= date_format($date,"Y-m-d");?>" oninvalid="alert('Value must be 31-12-2000 or earlier');" class="form-control"></div>

                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group form-control-sm">
                                        <label class="fw-semibold">Anniversary Date</label>
                                        <div><input type="date" id="anniversary" name="anniversary" value="<?php echo $empDet['anniversary_date']; ?>" class="form-control"></div>

                                    </div>
                                </div>
                            </div>

                        <div class="row justify-content-center">
                         <div class="col-md-10">
                           <div class="form-group form-control-sm">
                           <label class="fw-semibold">Upload Photo</label>
                           <div><input class="form-control" type="file" id="uploadphoto" name="fileuploads[]" multiple="multiple"></div>
                          </div>
                        </div>
                        </div>

                        <div class="row justify-content-center">
                        <div class="col-md-10">
                        <div class="form-group form-control-sm">
                        <label class="fw-semibold">Upload Documents</label>
                        <div><input class="form-control" type="file" id="uploaddoc" name="fileuploads[]" multiple="multiple"></div>

                </div>
            </div>
        </div> 

                            <div class="row justify-content-center">
                                <div class="col-md-5">
                                    <div class="form-group form-control-sm">
                                        <label class="fw-semibold">Gender</label><br>
                                        <?php if ($empDet['gender'] != '') {
                                            if ($empDet['gender'] == 'F') { ?>
                                                <input type="radio" name='gender' value="F" checked> <?php echo 'Female'; ?>
                                            <?php } elseif ($empDet['gender'] == 'M') { ?>
                                                <input type="radio" value="M" name='gender' checked> <?php echo 'Male'; ?>
                                            <?php } else if ($empDet['gender'] == 'O') { ?>
                                                <input type="radio" name='gender' value="O" checked> <?php echo 'Other'; ?>
                                        <?php      }
                                        } ?>
                                    </div>
                                </div>
                                <div class="col-md-5 mb-4">
                                    <div class="form-group form-control-sm">
                                        <label class="fw-semibold">Salary Bank Details</label>
                                        <div><textarea class="form-control" id="salary_bank" name="salary_bank" value="<?php echo htmlspecialchars($empDet['salary_bank_detail']); ?>"><?php echo htmlspecialchars($empDet['salary_bank_detail']); ?></textarea></div>

                                    </div>
                                </div>
                            </div>

                        </fieldset>
                    </div>
                    <!-- Attandance Start -->
                    <div class="col">
                        <fieldset class="formborder p-1">
                            <legend class="float-none w-auto fs-5 fw-semibold">Attandance</legend>
                            <div class="row   justify-content-center">
                                <div class="col-md-10">
                                    <div class="form-group form-control-sm">
                                        <label class="fw-semibold">Login Time</label>
                                        <div><input type="time" id="logintime" name="logintime" value="<?php echo $empDet['login_time']; ?>" class="form-control"></div>

                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-md-10">
                                    <div class="form-group form-control-sm">
                                        <label class="fw-semibold">Logout Time</label>
                                        <div><input type="time" id="logout" name="logout" value="<?php echo $empDet['logout_time']; ?>" class="form-control"></div>


                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="col-md-5">
                                    <div class="form-group form-control-sm">
                                        <label class="fw-semibold">Break permitted</label>
                                        <div><input type="text" id="break" name="break" value="<?php echo $empDet['break_permitted']; ?>" class="form-control" maxlength="5"></div>

                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group form-control-sm">
                                        <label class="fw-semibold">Weekly Off</label>
                                        <div><input type="text" id="weekoff" name="weekoff" value="<?php echo $empDet['weekly_off']; ?>" class="form-control" maxlength="10"></div>

                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-md-5">
                                    <div class="form-group form-control-sm">
                                        <label class="fw-semibold">Leaves per month</label>
                                        <div><input type="text" id="leave" name="leave" value="<?php echo $empDet['leave_per_month']; ?>" class="form-control"></div>

                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group form-control-sm">
                                        <label class="fw-semibold">WIFI IP</label>
                                        <div><input type="text" id="wifiip" name="wifiip" value="<?php echo $empDet['wifi_ip']; ?>" class="form-control" maxlength="15"></div>

                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="col-md-5">
                                    <div class="form-check form-switch">
                                        <?php if ($empDet['attendance_exempt'] == '0' || $empDet['attendance_exempt'] == '') { ?>
                                            <input class="form-check-input" name="attendanceexempt"  type="checkbox" role="switch">
                                        <?php } else { ?>
                                            <input class="form-check-input" name="attendanceexempt" type="checkbox" role="switch"  checked>

                                        <?php    } ?>
                                        <label class="form-check-label">Attendance Exempt</label>

                                    </div>

                                </div>
                                <div class="col-md-5">
                                    <div class="form-check form-switch  ">
                                        <?php if ($empDet['report_exempt'] == '0' || $empDet['report_exempt'] == '') { ?>
                                            <input class="form-check-input" name="reportexempt" type="checkbox"   role="switch">
                                        <?php } else { ?>
                                            <input class="form-check-input" name="reportexempt" type="checkbox"  role="switch" checked>

                                        <?php    } ?>
                                        <label class="form-check-label">Report Exempt</label>
                                        <!-- <input class="form-check-input" type="checkbox"  id="reportexempt" name="reportexempt" value="0" /> -->

                                    </div>
                                </div>
                            </div>
                            <div class="row  justify-content-center mt-3">
                                <div class="col-md-5 mb-5">
                                    <div class="form-check form-switch">
                                        <?php if ($empDet['break_exempt'] == '0' || $empDet['break_exempt'] == '') { ?>
                                            <input class="form-check-input" name="breakexempt" type="checkbox" role="switch">
                                        <?php } else { ?>
                                            <input class="form-check-input" name="breakexempt" type="checkbox"  role="switch" checked>

                                        <?php    } ?> 
                                        <label class="form-check-label">Break Exempt</label>
                                        <!-- <input class="form-check-input" type="checkbox"  id="breakexempt" name="breakexempt" value="false" /> -->

                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-check form-switch">
                                        <?php if ($empDet['ip_exempt'] == '0' || $empDet['ip_exempt'] == '') { ?>
                                            <input class="form-check-input" name="ipexempt"  type="checkbox" role="switch">
                                        <?php } else { ?>
                                            <input class="form-check-input" name="ipexempt"  type="checkbox" role="switch" checked>

                                        <?php    } ?> 
                                        <label class="form-check-label">IP Exempt</label>
                                        <!-- <input class="form-check-input" type="checkbox"  id="ipexempt" name="ipexempt" value="false" /> -->

                                    </div>
                                </div>
                            </div>

                        </fieldset>
                    </div>
                </div>

                <!-- Staff Info & ATTENDANCE END -->

                <!-- Office Info  & SOS Start -->
                <div class="row justify-content-center">
                    <div class="col">
                        <fieldset class="formborder p-1">
                            <legend class="float-none w-auto fs-5 fw-semibold">Office Info</legend>
                            <div class="row justify-content-center">
                                <div class="col-md-5">
                                    <div class="form-group form-control-sm">
                                        <label class="fw-semibold">Name Allotted</label>
                                        <div>
                                            <input type="text" id="name_allotted" name="name_allotted" value="<?php echo $empDet['name']; ?>" class="form-control" maxlength="15">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group form-control-sm">
                                        <label class="fw-semibold">Short Code</label>
                                        <div>
                                            <input type="text" id="ShortCode" name="ShortCode" value="<?php echo $empDet['emp_short_code']; ?>" class="form-control" maxlength="10">

                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row  justify-content-center">
                                <div class="col-md-5">
                                    <div class="form-group form-control-sm">
                                        <label class="fw-semibold">Date of Joining</label>
                                        <div><input type="date" id="datejoining" name="datejoining" value="<?php echo $empDet['date_of_joining']; ?>" class="form-control"></div>


                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group form-control-sm">
                                        <label class="fw-semibold">Reference</label>
                                        <div><input type="text" id="reference" name="reference" value="<?php echo $empDet['reference']; ?>" class="form-control" maxlength="10"></div>

                                    </div>
                                </div>
                            </div>

                        <div class="row justify-content-center">  
                           <div class="col-md-10">
                           <div class="form-group form-control-sm">
                         <label class="fw-semibold">Hiring Documents</label>
                        <div><input class="form-control" type="file" id="hiringdoc" name="fileuploads[]" multiple="multiple"></div>
                        </div>
                       </div> 
                        </fieldset>
                    </div>

                    <!--SOS Start -->
                    <div class="col">
                        <fieldset class="formborder p-1">
                            <legend class="float-none w-auto fs-5 fw-semibold">SOS</legend>
                            <div class="row justify-content-center">
                                <div class="col-md-5">
                                    <div class="form-group form-control-sm">
                                        <label class="fw-semibold">Relationship - kin</label>
                                        <div><input type="text" id="Relkin" name="Relkin" value="<?php echo $empDet['relationship_kin']; ?>" class="form-control" maxlength="15"></div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group form-control-sm">
                                        <label class="fw-semibold">Kin's Name</label>
                                        <div><input type="text" id="kinsname" name="kinsname" value="<?php echo $empDet['kin_name']; ?>" class="form-control" maxlength="25"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="col-md-5">
                                    <div class="form-group form-control-sm">
                                        <label class="fw-semibold">Kin's Mobile No.</label>
                                        <div><input type="text" id="Kinsmobileno" name="Kinsmobileno" value="<?php echo $empDet['kin_mobile_no']; ?>" class="form-control" maxlength="20"></div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group form-control-sm">
                                        <label class="fw-semibold"> Kin's Address</label>
                                        <div><textarea class="form-control" id="Kinsadd" name="Kinsadd" value="<?php echo $empDet['kin_address']; ?>" rows="1"><?php echo $empDet['kin_address']; ?></textarea></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="col-md-5">
                                    <div class="form-group form-control-sm">
                                        <label class="fw-semibold">Kin's Job Details</label>
                                        <div><textarea class="form-control" name="Kinsjob" value="<?php echo $empDet['kin_job']; ?>" rows="1"><?php echo $empDet['kin_job']; ?></textarea></div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group form-control-sm">
                                        <label class="fw-semibold">Current Address</label>
                                        <div><textarea class="form-control" name="Currentaddress" value="<?php echo $empDet['kin_current_address']; ?>" rows="1"><?php echo $empDet['kin_current_address']; ?></textarea></div>
                                    </div>
                                </div>
                            </div>


                        </fieldset>
                    </div>
                </div>
                <!-- Office Info  & SOS END -->
                <!-- Login Start -->
                <div class="row justify-content-center">
                    <div class="col">
                        <fieldset class="formborder p-1">
                            <legend class="float-none w-auto fs-5 fw-semibold">Login</legend>
                            <div class="row mb-3 justify-content-center">
                                <div class="col-md-5">
                                    <div class="form-group form-control-sm">
                                        <label class="fw-semibold">Login ID</label>
                                        <div><input type="text" id="login" name="login" value="<?php echo $empDet['login_id']; ?>" class="form-control" maxlength="10"></div>

                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group form-control-sm">
                                        <label class="fw-semibold"> Password</label>
                                        <div><input type="password" name="password" name="password" value="<?php echo $empDet['login_password']; ?>" class="form-control" maxlength="10"></div>

                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
                <!-- Login END -->
                 <!-- all user Documents -->
                <div class="row justify-content-center">
                    <div class="col">
                        <fieldset class="formborder p-1">
                            <legend class="float-none w-auto fs-5 fw-semibold">Documents</legend>
                        <div class="row justify-content-center mb-3">
                        <div class="col-md-8">
                          <table class="table table-striped table-hover table-bordered  table-sm" id="table" data-toggle="table" >
                           <thead>
                           <tr class="bg-gradient-primary sidebar sidebar-dark">
                               <th>SN.</th>
                               <th>File  Name</th>
                               <th>Action</th>
                           </tr>
                           </thead>
                           <?php 
                                                        $j=1;

                                                       
                                                        foreach($employee_doc as $docDet){ 
                                                         if($docDet['file_name']!='')  {
                                                            ?>
                           <tr>
                               <td><?php echo $j; ?></td>
                               <td><?php echo  $docDet['file_name']; ?></td>
                               <td><a href="<?php echo  base_url().'/'.$docDet['filepath']; ?>" target="_blank"><i class="fas fa-download"></i></a>
                              <a href="<?php echo base_url('Employee/delete/'.$docDet['id'].'/'.$empDet['emp_id']); ?>"> <i class="fas fa-trash-alt"></i></a></td>
                           </tr>
 <?php } ++$j;  }?>
                          </table>
                         </div>
                         </div>


                          

                            
                        </fieldset>
                    </div>
                </div>
                <!-- Documents END -->

                <!-- DISCONTINUATION  & REACTIVATE -->

                <div class="row justify-content-center">
                <!-- style="display: none;" -->
                    <div class="col" id="Discont" >
                        <fieldset class="formborder p-1">
                            <legend class="float-none w-auto fs-5 fw-semibold">Discontinuation</legend>
                            <div class="row justify-content-center">
                                <div class="col-md-10">
                                    <div class="form-group form-control-sm">
                                        <label class="fw-semibold">Date of leaving</label>
                                        <div><input type="date" name="dateofleaving" class="form-control" value="<?php echo $empDet['date_of_leaving']; ?>"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="col-md-5">
                                    <div class="form-group form-control-sm">
                                        <label class="fw-semibold">Reason for leaving</label>
                                        <div><textarea class="form-control" name="reasonforleaving" value="<?php echo $empDet['leaving_reason']; ?>"  rows="2"><?php echo $empDet['leaving_reason']; ?></textarea></div>
                                    </div>
                                </div>
                                
                                <div class="col-md-5">
                                    <div class="form-group form-control-sm">
                                        <label class="fw-semibold">Comments</label>
                                        <div><textarea class="form-control" name="Comment" value="<?php echo $empDet['comments']; ?>" rows="2"><?php echo $empDet['comments']; ?></textarea></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="col-md-10 mt-4">
                                    <div class="form-group form-control-sm">
                                        <label class="fw-semibold">Attachments</label>
                                        <div><input class="form-control" type="file" name="fileuploads[]" multiple="multiple"></div>
                                    </div>
                                </div>
                        </fieldset>
                    </div>

                    <!--Reactivate -->
                    <!-- style="display: none;" -->
                       
                
                    <div class="col" id="reacti" >
                            <?php  if($empDet['date_of_leaving']!=''): ?>


                        <fieldset class="formborder p-1">
                            <legend class="float-none w-auto fs-5 fw-semibold">Reactivate</legend>
                        <div class="row justify-content-center">
                       <div class="col-md-10">
                         <div class="form-group form-control-sm">
                        <label class="fw-semibold">Date of Rejoining</label>
                        <div><input type="date" name="dateofrejoin"  value="<?php echo $empDet['date_of_rejoin']; ?>"  id="dateofrejoining" class="form-control"></div>
                       </div>
                      </div>  
                      </div>

                            <div class="row justify-content-center">

                                <div class="col-md-10">
                                    <div class="form-group form-control-sm">
                                        <label class="fw-semibold"> Reason </label>
                                        <div><textarea class="form-control" name="reason"  value="<?php echo $empDet['reactive_reason']; ?>" rows="2"> <?php echo $empDet['reactive_reason']; ?></textarea></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="col-md-10 mt-4">
                                    <div class="form-group form-control-sm">
                                        <label class="fw-semibold">Authorized by</label>
                                        <div><input type="text" name="auth"  value="<?php echo $empDet['reactive_authorized_by']; ?>" class="form-control" maxlength="15"></div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <?php endif; ?>

                    </div>
                   
             
             </div>

                <!-- Dis  & Reactivate END -->
                
               

                <!-- save -->
                <div class="row justify-content-center my-4">
                    <div class="col-md-2 text-center">
                        <button type="submit" name="save" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </div>
       
            </form>
<!-- modal -->
    <?php
    $this->db = db_connect();
    $builder = $this->db->table("employee as emp");
    $builder->select('emp.legal_name,emp.emp_short_code,emp.id');

    $query = $builder->get()->getResultArray();

    ?>

    <div class="modal fade" id="sendmail" tabindex="-1" aria-labelledby="sendmailLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="sendmail">Send Email</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                    <form action="<?= base_url('Employee/sendmail'); ?>" method="post"  enctype="multipart/form-data">
                  <input type="hidden" class="form-control" id="employee_id" name="employee_id" value="<?= $empDet['emp_id']; ?>">
                  <input type="hidden" class="form-control"  name="requestmail" value="edit">
                        <div class="mb-3">
                            <label class="col-form-label">Name</label>
                            <select  required class="form-select form-select" aria-label="form-select-sm example" name="username">
                                <option value="">Select Name</option>
                                <?php $i = 1;
                                foreach ($query as $emp_det) { ?>
                                    <option <?php if($emp_det['id'] == $empDet['emp_id'] ){ echo 'selected="selected"'; } ?> value="<?php echo $emp_det['id']; ?>"><?php echo $emp_det['legal_name'] . '-' . $emp_det['emp_short_code'];?> </option>


                                <?php ++$i;
                                } ?>
                            </select>
                       

                        </div>



                        <div class="mb-3">
                            <label class="col-form-label">Email:</label>
                            <input type="text" required class="form-control" placeholder="Email" aria-label="email" name="email">
                           

                        </div>

                        <div class="mb-3">
                            <label class="col-form-label">Subject:</label>
                            <input type="text" class="form-control" placeholder="Email Subject" aria-label="Email Subject" name="subject">

                        </div>
                        <div class="mb-3">
                            <label class="col-form-label">Message:</label>
                            <input type="text" class="form-control" placeholder="" aria-label="Description" name="message">

                        </div>

                        <!--<div class="mb-3">-->
                        <!--    <label class="col-form-label">Upload:</label>-->
                        <!--    <input class="form-control" type="file" id="upload" multiple>-->
                        <!--</div>-->

                    </div>
                    <div class="modal-footer text-center">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="sendmail" class="btn btn-primary">Send Mail</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

 <?php }
    } ?>
    <!-- send mail END-->
            
            
             
            <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
            <script>
                $(document).ready(function() {
                    <?php if ($session->getflashdata('status')) { ?>
                        swal({
                            title: "<?= $session->getflashdata('status') ?>",
                            text: "<?= $session->getflashdata('status_text') ?>",
                            icon: "<?= $session->getflashdata('status_icon') ?>",
                         button: {
                         text: "OK",
                         className: "btn btn-primary",
                         },
                        });

                    <?php } ?>
                });

              
  $('#sendmail').on('hidden.bs.modal', function(e) {
        $(this)
            .find("input,textarea,select")
            .val('')
            .end()
            .find("input[type=checkbox], input[type=radio]")
            .prop("checked", "")
            .end();
    });
$(document).ready(function() {
    $('sendmail').submit(function(event) {
        var form_data = {
            username: $('#username').val(),
            email: $('#email').val(),
            message: $('#message').val(),
            subject: $('#subject').val(),
            requestmail: $('#requestmail').val(),
        };

        $.ajax({
            url: "<?php echo base_url('Employee/sendmail'); ?>",
            type: 'POST',
            data: form_data,
            success: function(msg) {
                // // console.log(msg);
                if (msg == 'YES'){
                    $('#alert-msg').html('<div class="alert alert-success text-center">Your mail has been sent successfully!</div>');
                 // Hide after 1 second
                //  setTimeout(function(){ $("#alert-msg").hide(); },1000);
                //  location.reload();
                }else if (msg == 'NO'){
                    $('#alert-msg').html('<div class="alert alert-danger text-center">Error in sending your message! Please try again later.</div>');
                 // Hide after 1 second
                //  setTimeout(function(){ $("#alert-msg").hide(); },1000);
                //  location.reload();
                }else{
                    $('#alert-msg').html('<div class="alert alert-danger">'+msg+'</div>');
                // Hide after 1 second
                // setTimeout(function(){ $("#alert-msg").hide(); },1000);
                //  location.reload();
                }

                }
        });
        return false;
    });
});
            </script>
               <?= $this->endSection() ?>
