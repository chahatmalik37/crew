<?= $this->extend('include/header.php') ?>
<?= $this->section('content') ?>
<style>
.form-control-sm {
  height: calc(1.5em + 2.3rem + 2px) !important;
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
            
        </div>
       

    </div>
</div>
<div class="clearfix"></div>

<div class="container">
    <!-- btn -->
    <div class="row justify-content-center">
    <div class="col-12">
        <!--<button type="button" class="btn btn-primary mb-4" id="Discontiuation">Discontiuation</button>-->
        <!--<button type="button" class="btn btn-primary mb-4 " id="reactivate">Reactivate</button>-->
       <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#sendmail">Send Email</button>

    </div> 
    </div>
    <!-- save -->


    <!-- Staff Info & ATTENDANCE start -->
    <!-- <form action="<?php //echo base_url('Employee/store'); ?>" method="post">  -->
    <?php
    if($view)
        {
                 $i=1;
                 
            foreach($view as $ud)
            {  ?> 

    <div class="row justify-content-center">
    <div class="col">
    <fieldset  class="formborder p-1">
       <legend class="float-none w-auto fs-5 fw-semibold">Staff Info</legend>
       <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="form-group form-control-sm">
                        <label class="fw-semibold">Legal Name</label>
                        <div>
                          
                            <input type="text" disabled id="legalname" name="legalname" value="<?php echo $ud['legal_name'] ?>" class="form-control" maxlength="25">
                       
                        </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group form-control-sm">
                        <label class="fw-semibold">Personal Email Id</label>
                        <div><input type="email" disabled id="personalemailid" name="personalemailid" value="<?php echo $ud['per_email_id'] ?>" class="form-control" maxlength="30"></div>
                       
                    </div>
            </div>
        </div>

        <div class="row  justify-content-center">
            <div class="col-md-5">
                <div class="form-group form-control-sm">
                        <label class="fw-semibold">Personal Contact No.</label>
                        <div><input type="text" disabled id="percontactno" name="percontactno"  value="<?php echo $ud['per_mobile_no']; ?>"class="form-control" maxlength="20"></div>
                        
                    </div>
            </div>
            <div class="col-md-5">
                <div class="form-group form-control-sm">
                        <label class="fw-semibold">Current Location</label>
                        <div><input type="text" disabled id="currentlocation" name="currentlocation" value="<?php echo $ud['emp_current_address']; ?>" class="form-control" maxlength="15"></div>
                        
                
                    </div>
            </div>
        </div>

        <div class="row  justify-content-center">
            <div class="col-md-5">
                <div class="form-group form-control-sm">
                        <label class="fw-semibold">Date of Birth</label>
                        <div><input  id="dob" disabled name="dob" value="<?php if($ud['dob']!='0000-00-00'){ echo date('d-m-Y',strtotime($ud['dob'])); }else{ echo 'dd-mm-yyyy';} ?>" class="form-control"></div>
                   
                    </div>
            </div>
            <div class="col-md-5">
                <div class="form-group form-control-sm">
                        <label class="fw-semibold">Anniversary Date</label>
                        <div><input  id="anniversary" disabled name="anniversary" value="<?php if($ud['anniversary_date']!='0000-00-00'){ echo date('d-m-Y',strtotime($ud['anniversary_date']));}else{ echo 'dd-mm-yyyy';} ?>" class="form-control"></div>
                       
                    </div>
            </div>
        </div>

         <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="form-group form-control-sm">
                        <label class="fw-semibold">Upload Photo</label>
                        <div><input class="form-control" disabled type="file" id="uploadphoto" name="uploadphoto" multiple></div>
                </div>
            </div>
           
        </div> 

         <div class="row justify-content-center">
           
            <div class="col-md-10">
                <div class="form-group form-control-sm">
                        <label class="fw-semibold">Upload Documents</label>
                        <div><input class="form-control" type="file" id="uploaddoc" disabled name="uploaddoc" multiple></div>

                </div>
            </div>
        </div> 

        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="form-group form-control-sm">
                        <label class="fw-semibold">Gender</label><br>
                            <?php if($ud['gender']!=''){
                                if($ud['gender']=='F'){ ?>
                                    <input type="radio" value="Female" checked> <?php    echo 'Female'; ?>
                               <?php }elseif($ud['gender']=='M'){ ?>
                           <input type="radio" value="Male" checked> <?php    echo 'Male'; ?>
                               <?php }else if($ud['gender']=='O'){ ?>
                                    <input type="radio" value="Other" checked> <?php    echo 'Other'; ?>
                               <?php      }}?>
                </div>
            </div>
            <div class="col-md-5 mb-4">
                <div class="form-group form-control-sm">
                        <label class="fw-semibold">Salary Bank Details</label>
                        <div><textarea class="form-control"  id="salary_bank" name="salary_bank" disabled  rows="2" value="<?php echo $ud['salary_bank_detail']; ?>" ><?php echo $ud['salary_bank_detail']; ?></textarea></div>
                     
                </div>
            </div>
        

    </fieldset>
    </div>
    <!-- Attandance Start -->
    <div class="col">
    <fieldset  class="formborder p-1">
       <legend class="float-none w-auto fs-5 fw-semibold">Attandance</legend>
       <div class="row   justify-content-center">
            <div class="col-md-10">
                <div class="form-group form-control-sm">
                    <label class="fw-semibold">Login Time</label>
                    <div><input type="time" id="logintime" disabled name="logintime" value="<?php echo $ud['login_time']; ?>" class="form-control"></div>
                   
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-10">
                        <div class="form-group form-control-sm">
                            <label class="fw-semibold">Logout Time</label>
                            <div><input type="time" id="logout" disabled name="logout" value="<?php echo $ud['logout_time']; ?>" class="form-control"></div>
                     
                        
                        </div>
            </div>
        </div>
       
       <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="form-group form-control-sm">
                    <label class="fw-semibold">Break permitted</label>
                    <div><input type="text" id="break" name="break" disabled value="<?php echo $ud['break_permitted']; ?>"  class="form-control" maxlength="5"></div>
                   
                </div>
            </div>
            <div class="col-md-5">
                        <div class="form-group form-control-sm">
                            <label class="fw-semibold">Weekly Off</label>
                            <div><input type="text" id="weekoff" disabled  name="weekoff" value="<?php echo $ud['weekly_off']; ?>" class="form-control" maxlength="10"></div>
                       
                        </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="form-group form-control-sm">
                    <label class="fw-semibold">Leaves per month</label>
                    <div><input type="number" id="leave" disabled name="leave" value="<?php echo $ud['leave_per_month']; ?>" class="form-control" ></div>
                   
                </div>
            </div>
            <div class="col-md-5">
                    <div class="form-group form-control-sm">
                    <label class="fw-semibold">WIFI IP</label>
                    <div><input type="text" id="wifiip" disabled name= "wifiip" value="<?php echo $ud['wifi_ip']; ?>"class="form-control"  maxlength="15"></div>
                  
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-5">
                    <div class="form-check form-switch">
                    <?php if($ud['attendance_exempt']=='0' || $ud['attendance_exempt']==''){ ?>
                               <input class="form-check-input" disabled type="checkbox" role="switch"    >
                     <?php }else{ ?>
                        <input class="form-check-input" disabled type="checkbox" role="switch"  checked >
                       
                   <?php    }?>
                   <label class="form-check-label">Attendance Exempt</label>
                     
                </div>
               
            </div>
            <div class="col-md-5">
                    <div class="form-check form-switch  ">
                    <?php if($ud['report_exempt']=='0' || $ud['report_exempt']==''){ ?>
                              <input class="form-check-input" disabled type="checkbox" role="switch" >
                       
                    <?php  }else{ ?>
                        <input class="form-check-input"  disabled type="checkbox" checked role="switch" >
                       
                  <?php    }?>
                    <label class="form-check-label">Report Exempt</label>
                   
                    <!-- <input class="form-check-input" type="checkbox"  id="reportexempt" name="reportexempt" value="0" /> -->
 
                    </div>
            </div>
        </div>
        <div class="row  justify-content-center mt-3">
            <div class="col-md-5 mb-5">
                    <div class="form-check form-switch">
                    <?php if($ud['break_exempt']=='0' || $ud['report_exempt']==''){ ?>
                        <input class="form-check-input" disabled  type="checkbox"  role="switch" >
                                
                     <?php }else{ ?>
                        <input class="form-check-input" disabled type="checkbox" checked role="switch" >
                       
                     <?php }?>
                     
                    <label class="form-check-label">Break Exempt</label>
                    <!-- <input class="form-check-input" type="checkbox"  id="breakexempt" name="breakexempt" value="false" /> -->
  
                    </div>
            </div>
            <div class="col-md-5">
                    <div class="form-check form-switch">
                    <?php if($ud['ip_exempt']=='0' || $ud['ip_exempt']==''){ ?>
                        <input class="form-check-input" disabled type="checkbox" role="switch" >
                              
                  <?php    }else{ ?>
                        <input class="form-check-input"  disabled type="checkbox" checked role="switch" >
                       
                    <?php  }?>
                    <!-- <input class="form-check-input" type="checkbox"  id="ipexempt" name="ipexempt" value="false" /> -->
 
                    <label class="form-check-label">IP Exempt</label>
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
                    <label class="fw-semibold">Name Allotted</label>
                        <div>
                        <input type="text" id="name_allotted" disabled name="name_allotted" value="<?php echo $ud['name']; ?>" class="form-control" maxlength="15">
                        </div>
                </div>
            </div>
            <div class="col-md-5">
                    <div class="form-group form-control-sm">
                        <label class="fw-semibold">Short Code</label>
                        <div>
                        <input type="text" id="ShortCode" name="ShortCode"   disabled value="<?php echo $ud['emp_short_code']; ?>" class="form-control" maxlength="10">
                      
                    </div>
                    </div>
            </div>
        </div>


        <div class="row  justify-content-center">
            <div class="col-md-5">
                <div class="form-group form-control-sm">
                    <label class="fw-semibold">Date of Joining</label>
                        <div><input id="datejoining" name="datejoining" disabled value="<?php echo date('d-m-Y',strtotime($ud['date_of_joining'])); ?>" class="form-control" ></div>
                       
               
                    </div>
            </div>
            <div class="col-md-5">
                    <div class="form-group form-control-sm">
                        <label class="fw-semibold">Reference</label>
                        <div><input type="text" id="reference"  disabled name="reference" value="<?php echo $ud['reference']; ?>" class="form-control" maxlength="10"></div>
                   
                    </div>
            </div>
        </div>

        <div class="row justify-content-center">  
            <div class="col-md-10">
                    <div class="form-group form-control-sm">
                        <label class="fw-semibold">Hiring Documents</label>
                        <div><input class="form-control"  type="file" id="hiringdoc" disabled multiple></div>
                    </div>
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
                    <div><input type="text" id="Relkin"  disabled name="Relkin" value="<?php echo $ud['relationship_kin']; ?>" class="form-control" maxlength="15"></div>
                </div>
            </div>
            <div class="col-md-5">
                        <div class="form-group form-control-sm">
                            <label class="fw-semibold">Kin's Name</label>
                            <div><input type="text" id="kinsname" disabled name="kinsname" value="<?php echo $ud['kin_name']; ?>" class="form-control" maxlength="25"></div>
                        </div>
            </div>
        </div>

        <div class="row justify-content-center">    
                    <div class="col-md-5">
                        <div class="form-group form-control-sm">
                            <label class="fw-semibold">Kin's Mobile No.</label>
                            <div><input type="text" id="Kinsmobileno" disabled name="Kinsmobileno"  value="<?php echo $ud['kin_mobile_no']; ?>" class="form-control" maxlength="20"></div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group form-control-sm">
                            <label class="fw-semibold"> Kin's Address</label>
                            <div><textarea class="form-control" disabled name="Kinsadd" id="Kinsadd" value="<?php echo $ud['kin_address']; ?>"  rows="1"><?php echo $ud['kin_address']; ?></textarea></div>
                    </div>
        </div>
        </div>


        <div class="row justify-content-center">  
                   <div class="col-md-5">
                        <div class="form-group form-control-sm">
                            <label class="fw-semibold">Kin's Job Details</label>
                            <div><textarea class="form-control" disabled name="Kinsjob" id="Kinsjob" value="<?php echo $ud['kin_job']; ?>"  rows="1"><?php echo $ud['kin_job']; ?></textarea></div>
                        </div>
                   </div>
                   <div class="col-md-5">
                        <div class="form-group form-control-sm">
                            <label class="fw-semibold">Current Address</label>
                            <div><textarea class="form-control" disabled  name="Currentaddress" id="Currentaddress" value="<?php echo $ud['kin_current_address']; ?>"  rows="1"><?php echo $ud['kin_current_address']; ?></textarea></div>
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
                    <label class="fw-semibold">Login ID</label>
                    <div><input type="text"  id="login"  name="login"  disabled value="<?php echo $ud['login_id']; ?>" class="form-control" maxlength="10"></div>
                    
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group form-control-sm">
                        <label class="fw-semibold"> Password</label>
                        <div><input type="password" name="password"  name="password"  disabled value="<?php echo $ud['login_password']; ?>" class="form-control" maxlength="10"></div>
                       
                    </div>
            </div>
        </div>
    </fieldset>
    </div>
    </div>
    <!-- Login END -->
     <!-- DISCONTINUATION  & REACTIVATE -->
     <div class="row justify-content-center" >
    <div class="col"  id="Discont">
    <fieldset  class="formborder p-1">
       <legend class="float-none w-auto fs-5 fw-semibold">Discontinuation</legend>
       <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="form-group form-control-sm">
                    <label class="fw-semibold">Date of leaving</label>
                        <div><input type="date" name="dateofleaving" disabled value="<?php echo $ud['date_of_leaving']; ?>" class="form-control"></div>
                </div>
           </div>  
        </div>

        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="form-group form-control-sm">
                    <label class="fw-semibold">Reason for leaving</label>
                    <div><textarea class="form-control" name="reasonforleaving" disabled value="<?php echo $ud['leaving_reason']; ?>" rows="2"><?php echo $ud['leaving_reason']; ?></textarea></div>

                </div>
            </div>
            <div class="col-md-5">
                    <div class="form-group form-control-sm">
                        <label class="fw-semibold">Comments</label>
                        <div><textarea class="form-control" name="Comment" value="<?php echo $ud['comments']; ?>" disabled rows="2"><?php echo $ud['comments']; ?></textarea></div>
                    </div>
            </div>
        </div>

        <div class="row justify-content-center">  
            <div class="col-md-10 mt-4">
                    <div class="form-group form-control-sm">
                        <label class="fw-semibold">Attachments</label>
                        <div><input class="form-control" disabled type="file" id="attachments" multiple></div>
                    </div>
            </div>
        </div>
    </fieldset>
    </div>

    <!--Reactivate -->
    
    <div class="col" id="reacti">
    <fieldset  class="formborder p-1">
       <legend class="float-none w-auto fs-5 fw-semibold">Reactivate</legend>
            <!--<?php  //if($ud['date_of_leaving']!=''): ?>-->

        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="form-group form-control-sm">
                    <label class="fw-semibold">Date of Rejoining</label>
                        <div><input type="date" name="dateofrejoin" disabled  value="<?php  echo $ud['date_of_rejoin']; ?>"  class="form-control"></div>
                </div>
           </div>  
        </div>
       

        <div class="row justify-content-center">    
                  
                    <div class="col-md-10">
                        <div class="form-group form-control-sm">
                            <label class="fw-semibold"> Reason </label>
                            <div><textarea class="form-control" name="reason"  value="<?php echo $ud['reactive_reason']; ?>" disabled rows="2"><?php echo $ud['reactive_reason']; ?></textarea></div>
                        </div>
                    </div>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-md-10 mt-4">
                <div class="form-group form-control-sm">
                    <label class="fw-semibold">Authorized by</label>
                    <div><input type="text" name="auth" value="<?php echo $ud['reactive_authorized_by']; ?>" disabled  class="form-control" maxlength="15"></div>
                </div>
            </div>
        </div>
    <?php //endif;?>

    </fieldset>
    </div>
    </div>
    </div>
    
<br>


<!-- send mail END-->


   
    
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
                    <input type="hidden" class="form-control" id="requestmail" name="requestmail" value="view">
                    <input type="hidden" class="form-control" id="employee_id" name="employee_id" value="<?= $ud['emp_id']; ?>">
 

                        <div class="mb-3">
                            <label class="col-form-label">Name</label>
                            <select required class="form-select form-select" aria-label="form-select-sm example" name="username">
                                <option value="">Select Name</option>
                                <?php $i = 1;
                                foreach ($query as $emp_det) { ?>
                                    <option <?php if($emp_det['id'] == $ud['emp_id'] ){ echo 'selected="selected"'; } ?> value="<?php echo $emp_det['id']; ?>"><?php echo $emp_det['legal_name'] . '-' . $emp_det['emp_short_code'];?> </option>


                                <?php ++$i;
                                } ?>
                            </select>
                       

                        </div>



                        <div class="mb-3">
                            <label class="col-form-label">Email:</label>
                            <input type="text" class="form-control" placeholder="Email" aria-label="email" name="email">
                            
                        </div>

                        <div class="mb-3">
                            <label class="col-form-label">Subject:</label>
                            <input type="text"  class="form-control" placeholder="Email Subject" aria-label="Email Subject" name="subject">

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
 <?php } } ?>
 
 <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
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
               //  if (msg == 'YES'){
               //      $('#alert-msg').html('<div class="alert alert-success text-center">Your mail has been sent successfully!</div>');
                //  // Hide after 1 second
                // //  setTimeout(function(){ $("#alert-msg").hide(); },1000);
                // //  location.reload();
              //  }else if (msg == 'NO'){
                    $('#alert-msg').html('<div class="alert alert-danger text-center">Error in sending your message! Please try again later.</div>');
                //  // Hide after 1 second
                // //  setTimeout(function(){ $("#alert-msg").hide(); },1000);
                // //  location.reload();
               //  }else{
               //     $('#alert-msg').html('<div class="alert alert-danger">'+msg+'</div>');
                // // Hide after 1 second
                // // setTimeout(function(){ $("#alert-msg").hide(); },1000);
                // //  location.reload();
              //  }

                }
        });
        return false;
    });
});
</script>
<?= $this->endSection() ?>






    
 



