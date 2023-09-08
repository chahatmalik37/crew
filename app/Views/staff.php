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
<?php  $session = session();
?>
<div class="container">
    <div class="row">
        <div class="col-lg-12 my-4 ">
            <h4 class="text-center fw-bold">STAFF MASTER</h4>
             <div class="text-center star_wrapper">
                 <hr class="top-Line"></hr><i class="fas fa-star fa-xs icons_rotate"></i><hr class="top-Line"></hr>
             </div>
        <!--</div>-->
       

    </div>
</div>
<div class="clearfix"></div>

<div class="container">
    <!-- btn -->
    <div class="row justify-content-center">
    <div class="col-12">
        <!--<button type="button" class="btn btn-primary mb-2" id="Discontiuation">Discontiuation</button>-->
        <!--<button type="button" class="btn btn-primary mb-2" id="reactivate">Reactivate</button>-->
        <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#sendmail">Send Email</button>


    </div> 
    </div>

    <!-- Staff Info & ATTENDANCE start -->
    <form  method="post"  enctype="multipart/form-data"> 
    <div class="row justify-content-center">
    <div class="col">
    <fieldset  class="formborder p-1">
       <legend class="float-none w-auto fs-5 fw-semibold">Staff Info</legend>
       <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="form-group form-control-sm">
                        <label class="fw-semibold">Legal Name<span class="text-danger">*</span></label>
                        <div>
                          
                            <input type="text" id="legalname" name="legalname" value="<?php echo set_value('legalname'); ?>" class="form-control" maxlength="25">
                       <span class="text-danger"><?=  displayError($validation,'legalname')?><span>
                       
                        </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group form-control-sm">
                        <label class="fw-semibold">Personal Email Id<span class="text-danger">*</span></label>
                        <div><input type="email" id="personalemailid" name="personalemailid" value="<?php echo set_value('personalemailid'); ?>" class="form-control" maxlength="30"></div>
                        <span class="text-danger"><?=  displayError($validation,'personalemailid')?><span>
                       
                    </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="form-group form-control-sm">
                        <label class="fw-semibold">Personal Contact No.</label>
                        <div><input type="text" id="percontactno" name="percontactno"  value="<?php echo set_value('percontactno'); ?>"class="form-control" maxlength="20"></div>
                        <span class="text-danger"><?=  displayError($validation,'percontactno')?><span>
                
                    </div>
            </div>
            <div class="col-md-5">
                <div class="form-group form-control-sm">
                        <label class="fw-semibold">Current Location<span class="text-danger">*</span></label>
                        <div><input type="text" id="currentlocation" name="currentlocation" value="<?php echo set_value('currentlocation'); ?>" class="form-control" maxlength="15"></div>
                        <span class="text-danger"><?=  displayError($validation,'currentlocation')?><span>
                
                
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
                 
                        <div><input type="date" id="dob" name="dob" value="<?php echo set_value('dob'); ?>" class="form-control" max="<?= date_format($date,"Y-m-d");?>" ></div>
                        <span class="text-danger"><?=  displayError($validation,'dob')?><span>
                
                    </div>
            </div>
            <div class="col-md-5">
                <div class="form-group form-control-sm">
                        <label class="fw-semibold">Anniversary Date</label>
                        <div><input type="date" id="anniversary" name="anniversary" value="<?php echo set_value('anniversary'); ?>" class="form-control" max="<?= date('Y-m-d'); ?>"></div>
                       
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

        <div class="row  justify-content-center">
            <div class="col-md-5 mb-5">
                <div class="form-group form-control-sm">
                        <label class="fw-semibold">Gender</label>
                            <div class="form-check">
                            <input class="form-check-input" type="radio" name="gender"  value="F" checked>
                            <label class="form-check-label">Female</label>
                            </div>
                            <div class="form-check">
                            <input class="form-check-input" type="radio" name="gender" value="M">
                            <label class="form-check-label">Male</label>
                            </div>
                            <div class="form-check">
                            <input class="form-check-input" type="radio" name="gender" value="O">
                            <label class="form-check-label">Other</label>
                            </div>
                </div>
            </div>
            <div class="col-md-5 mb-5 ">
                <div class="form-group form-control-sm">
                        <label class="fw-semibold">Salary Bank Details</label>
                        <div><textarea class="form-control" id="salary_bank" name="salary_bank" value="<?php echo set_value('salary_bank'); ?>" rows="3"></textarea></div>
                        <span class="text-danger"><?=  displayError($validation,'salary_bank')?><span>

                </div>
            </div>
        </div>

    </fieldset>
    </div>
    <!-- Attandance Start -->
    <div class="col">
    <fieldset  class="formborder p-1">
       <legend class="float-none w-auto fs-5 fw-semibold">Attendance</legend>
       <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="form-group form-control-sm">
                    <label class="fw-semibold">Login Time<span class="text-danger">*</span></label>
                    <div><input type="time" id="logintime" name="logintime" value="<?php echo set_value('logintime'); ?>" class="form-control"></div>
                     <span class="text-danger"><?=  displayError($validation,'logintime')?><span>
                   
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-10">
                        <div class="form-group form-control-sm">
                            <label class="fw-semibold">Logout Time<span class="text-danger">*</span></label>
                            <div><input type="time" id="logout" name="logout" value="<?php echo set_value('logout'); ?>" class="form-control"></div>
                    <span class="text-danger"><?=  displayError($validation,'logout')?><span>
                        
                        </div>
            </div>
        </div>
       
       <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="form-group form-control-sm">
                    <label class="fw-semibold">Break permitted</label>
                    <div><input type="text" id="break" name="break" value="<?php echo set_value('break'); ?>"  class="form-control" maxlength="5"></div>
                    
                
                </div>
            </div>
            <div class="col-md-5">
                        <div class="form-group form-control-sm">
                            <label class="fw-semibold">Weekly Off</label>
                            <div><input type="text" id="weekoff"  name="weekoff" value="<?php echo set_value('weekoff'); ?>" class="form-control" maxlength="10"></div>
                       
                        </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="form-group form-control-sm">
                    <label class="fw-semibold">Leaves per month</label>
                    <div><input type="number" id="leave" name="leave" value="<?php echo set_value('leave'); ?>" class="form-control" ></div>
                   
                </div>
            </div>
            <div class="col-md-5">
                    <div class="form-group form-control-sm">
                    <label class="fw-semibold">WIFI IP</label>
                    <div><input type="text" id="wifiip" name= "wifiip" value="<?php echo set_value('wifiip'); ?>"class="form-control"  maxlength="15"></div>
                  
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-5 ">
                    <div class="form-check form-switch">
                    <input class="form-check-input" type="hidden" role="switch"  name="attendanceexempt" value="0">
                    <input class="form-check-input" type="checkbox" role="switch" id="attendanceexempt" name="attendanceexempt" value="1">
                    <label class="form-check-label fw-semibold">Attendance Exempt</label>
                  
                </div>
               
            </div>
            <div class="col-md-5 ">
                    <div class="form-check form-switch">
                    <input class="form-check-input" type="hidden" role="switch"   name="reportexempt" value="0">
                    <input class="form-check-input" type="checkbox" role="switch" id="reportexempt"  name="reportexempt" value="1">
                    <label class="form-check-label fw-semibold">Report Exempt</label>
                    <!-- <input class="form-check-input" type="checkbox"  id="reportexempt" name="reportexempt" value="0" /> -->
 
                    </div>
            </div>
        </div>
        <div class="row  justify-content-center mt-3 mb-5">
            <div class="col-md-5 mb-4">
                    <div class="form-check form-switch">
                    <input class="form-check-input" type="hidden" role="switch"  name="breakexempt" value="0" >
                    <input class="form-check-input" type="checkbox" role="switch" id="breakexempt" name="breakexempt" value="1" >
                    <label class="form-check-label fw-semibold">Break Exempt</label>
                    <!-- <input class="form-check-input" type="checkbox"  id="breakexempt" name="breakexempt" value="false" /> -->
  
                    </div>
            </div>
            <div class="col-md-5">
                    <div class="form-check form-switch">
                    <input class="form-check-input" type="hidden" role="switch"   name="ipexempt" value="0">    
                    <input class="form-check-input" type="checkbox" role="switch"  id="ipexempt" name="ipexempt" value="1">
                    <label class="form-check-label fw-semibold">IP Exempt</label>
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
    <fieldset  class="formborder p-1">
       <legend class="float-none w-auto fs-5 fw-semibold">Office Info</legend>
       <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="form-group form-control-sm">
                    <label class="fw-semibold">Name Allotted<span class="text-danger">*</span></label>
                        <div>
                        <input type="text" id="name_allotted" name="name_allotted" value="<?php echo set_value('name_allotted'); ?>" class="form-control" maxlength="15">
                         <span class="text-danger"><?=  displayError($validation,'name_allotted')?><span>
                       
                        </div>
                </div>
            </div>
            <div class="col-md-5">
                    <div class="form-group form-control-sm">
                        <label class="fw-semibold">Short Code<span class="text-danger">*</span></label>
                        <div>
                        <input type="text" id="ShortCode" name="ShortCode"  value="<?php echo set_value('ShortCode'); ?>" class="form-control" maxlength="10">
                        <span class="text-danger"><?=  displayError($validation,'ShortCode')?><span>

                    </div>
                    </div>
            </div>
        </div>


        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="form-group form-control-sm">
                    <label class="fw-semibold">Date of Joining<span class="text-danger">*</span></label>
                        <div><input type="date" id="datejoining" name="datejoining" value="<?php echo set_value('datejoining'); ?>"  class="form-control"></div>
                        <span class="text-danger"><?=  displayError($validation,'datejoining')?><span>
               
               
                    </div>
            </div>
            <div class="col-md-5">
                    <div class="form-group form-control-sm">
                        <label class="fw-semibold">Reference</label>
                        <div><input type="text" id="reference" name="reference" value="<?php echo set_value('reference'); ?>" class="form-control" maxlength="10"></div>
                   
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
    <fieldset  class="formborder p-1">
       <legend class="float-none w-auto fs-5 fw-semibold">SOS</legend>
       <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="form-group form-control-sm">
                    <label class="fw-semibold">Relationship - kin</label>
                    <div><input type="text" id="Relkin" name="Relkin" value="<?php echo set_value('Relkin'); ?>" class="form-control" maxlength="15"></div>
                </div>
            </div>
            <div class="col-md-5">
                        <div class="form-group form-control-sm">
                            <label class="fw-semibold">Kin's Name</label>
                            <div><input type="text" id="kinsname" name="kinsname" value="<?php echo set_value('kinsname'); ?>" class="form-control" maxlength="25"></div>
                        </div>
            </div>
        </div>

        <div class="row  justify-content-center">    
                    <div class="col-md-5">
                        <div class="form-group form-control-sm">
                            <label class="fw-semibold">Kin's Mobile No.</label>
                            <div><input type="text" id="Kinsmobileno" name="Kinsmobileno"  value="<?php echo set_value('Kinsmobileno'); ?>" class="form-control" maxlength="20"></div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group form-control-sm">
                            <label class="fw-semibold"> Kin's Address</label>
                            <div><textarea class="form-control" id="Kinsadd" name="Kinsadd"  value="<?php echo set_value('Kinsadd'); ?>" rows="1"></textarea></div>
                        </div>
                    </div>
        </div>

        <div class="row  justify-content-center">  
                   <div class="col-md-5">
                        <div class="form-group form-control-sm">
                            <label class="fw-semibold">Kin's Job Details</label>
                            <div><textarea class="form-control"  name="Kinsjob" id="Kinsjob" value="<?php echo set_value('Kinsjob'); ?>"  rows="1"></textarea></div>
                        </div>
                   </div>
                   <div class="col-md-5">
                        <div class="form-group form-control-sm">
                            <label class="fw-semibold">Current Address</label>
                            <div><textarea class="form-control"  name="Currentaddress" id="Currentaddress" value="<?php echo set_value('Currentaddress'); ?>"  rows="1"></textarea></div>
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
    <fieldset  class="formborder p-1">
       <legend class="float-none w-auto fs-5 fw-semibold">Login</legend>
       <div class="row mb-3 justify-content-center">
            <div class="col-md-5">
                <div class="form-group form-control-sm">
                    <label class="fw-semibold">Login ID<span class="text-danger">*</span></label>
                    <div><input type="text"  id="login"  name="login"  value="<?php echo set_value('login'); ?>" class="form-control" maxlength="10"></div>
                    <span class="text-danger"><?=  displayError($validation,'login')?><span>
               
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group form-control-sm">
                        <label class="fw-semibold"> Password<span class="text-danger">*</span></label>
                        <div><input type="password" name="password"  name="password" value="<?php echo set_value('password'); ?>" class="form-control" maxlength="10"></div>
                        <span class="text-danger"><?=  displayError($validation,'password')?><span>
             
                    </div>
            </div>
        </div>
    </fieldset>
    </div>
    </div>
    <!-- Login END -->
     <!-- DISCONTINUATION  & REACTIVATE -->
    <!-- <div class="row justify-content-center" >-->
    <!--<div class="col-md-5"  id="Discont" style="display: none;">-->
    <!--<fieldset  class="formborder p-1">-->
    <!--   <legend class="float-none w-auto fs-5 fw-semibold">Discontinuation</legend>-->
    <!--   <div class="row justify-content-center">-->
    <!--        <div class="col-md-10">-->
    <!--            <div class="form-group form-control-sm">-->
    <!--                <label class="fw-semibold">Date of leaving</label>-->
    <!--                    <div><input type="date" name="dateofleaving"  value="<?php echo set_value('dateofleaving'); ?>"  class="form-control"></div>-->
    <!--            </div>-->
    <!--       </div>  -->
    <!--    </div>-->

        <!--<div class="row justify-content-center">-->
        <!--    <div class="col-md-5">-->
        <!--        <div class="form-group form-control-sm">-->
        <!--            <label class="fw-semibold">Reason for leaving</label>-->
        <!--            <div><textarea class="form-control" id="reasonforleaving"  rows="2"></textarea></div>-->

        <!--        </div>-->
        <!--    </div>-->
            
        <!--    <div class="col-md-5">-->
        <!--            <div class="form-group form-control-sm">-->
        <!--                <label class="fw-semibold">Comments</label>-->
        <!--                <div><textarea class="form-control" name="Comment"  value="<?php //echo set_value('Comment'); ?>" rows="2"></textarea></div>-->
        <!--            </div>-->
        <!--    </div>-->
        <!--</div>-->

    <!--    <div class="row  justify-content-center">  -->
    <!--        <div class="col-md-10 mt-4">-->
    <!--                <div class="form-group form-control-sm">-->
    <!--                    <label class="fw-semibold">Attachments</label>-->
    <!--                    <div><input class="form-control" type="file" name="fileuploads[]" multiple="multiple"></div>-->
    <!--                </div>-->
    <!--        </div>-->
    <!--</fieldset>-->
    <!--</div>-->

    <!--Reactivate -->
    <!--<div class="col-md-5" id="reacti" style="display: none;">-->
    <!--<fieldset  class="formborder p-1">-->
    <!--   <legend class="float-none w-auto fs-5 fw-semibold">Reactivate</legend>-->
    <!--     <div class="row justify-content-center">-->
    <!--        <div class="col-md-10">-->
    <!--            <div class="form-group form-control-sm">-->
    <!--                <label class="fw-semibold">Date of Rejoin</label>-->
    <!--                    <div><input type="date" name="dateofrejoin"  value="<?php echo set_value('dateofrejoin'); ?>"  class="form-control"></div>-->
    <!--            </div>-->
    <!--       </div>  -->
    <!--    </div>-->

        <!--<div class="row justify-content-center">    -->
                  
        <!--            <div class="col-md-10">-->
        <!--                <div class="form-group form-control-sm">-->
        <!--                    <label class="fw-semibold"> Reason </label>-->
        <!--                    <div><textarea class="form-control" name="reason"  value="<?php echo set_value('reason'); ?>"  rows="2"></textarea></div>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--</div>-->

        <!--<div class="row justify-content-center">-->
        <!--    <div class="col-md-10 mt-4">-->
        <!--        <div class="form-group form-control-sm">-->
        <!--            <label class="fw-semibold">Authorized by</label>-->
        <!--            <div><input type="text" name="auth" value="<?php //echo set_value('auth'); ?>"  class="form-control" maxlength="15"></div>-->
        <!--        </div>-->
        <!--    </div>-->
        <!--</div>-->
    <!--</fieldset>-->
    <!--</div>-->
    <!--</div>-->


<!-- Dis  & Reactivate END -->

<!-- save -->
<br>
<div class="row justify-content-center">
    <div class="col-md-2 text-center mb-4">
    <!-- <button type="submit" name="save" id="save"  value="save" class="btn btn-success">Save</button> -->
    <button type="submit" class="btn btn-primary" formaction="<?=  base_url('Employee/store'); ?>" formenctype="multipart/form-data">Save</button>
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
                    <form action="<?= base_url('Employee/sendmail'); ?>" method="post">
                    <input type="hidden" class="form-control"  name="requestmail" value="insert">


                        <div class="mb-3">
                            <label class="col-form-label">Name</label>
                            <select required class="form-select form-select" name="username">
                                <option value="">Select Name</option>
                                <?php $i = 1;
                                foreach ($query as $emp_det) { ?>
                                    <option value="<?= $emp_det['id'] ?>"><?= $emp_det['legal_name'] . '-' . $emp_det['emp_short_code'] ?></option>

                                <?php ++$i;
                                } ?>
                            </select>

                        </div>



                        <div class="mb-3">
                            <label class="col-form-label">Email:</label>
                            <input type="text" required class="form-control" placeholder="Email" aria-label="email" name="email"></div>

                        <div class="mb-3">
                            <label class="col-form-label">Subject:</label>
                            <input type="text" class="form-control" placeholder="Email Subject" aria-label="Email Subject" name="subject">

                        </div>
                        <div class="mb-3">
                            <label class="col-form-label">Message:</label>
                            <input class="form-control" type="text" placeholder="Message" aria-label="Description" name="message">

                        </div>

                        <div class="mb-3">
                            <!--<label class="col-form-label">Upload:</label>-->
                            <!--<input class="form-control" type="file" id="upload" multiple>-->
                        </div>

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
  
  $('#sendmail').on('hidden.bs.modal', function(e) {
        $(this)
            .find("input,textarea,select")
            .val('')
            .end()
            .find("input[type=checkbox], input[type=radio]")
            .prop("checked", "")
            .end();
    });

</script>
<?= $this->endSection() ?>






    
 



