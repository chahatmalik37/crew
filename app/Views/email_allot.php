<?= $this->extend('include/header.php') ?>
<?= $this->section('content') ?>
<?php
$this->db = db_connect();
$builder = $this->db->table("employee as emp");
$builder->select('emp.name,emp.emp_short_code,emp.id');
$builder->where('emp.status', 'Active');
$builder->orderby('emp.emp_short_code');
$query = $builder->get()->getResultArray();

$builder = $this->db->table("once_email as email");
$builder->select('email.*');
$builder->where('email.forwarding_to', '');
$builder->where('email.status', 'Active');
$email_data = $builder->get()->getResultArray();

$builder = $this->db->table("once_simcard as sim");
$builder->select('sim.*');
$builder->where('sim.status', 'Active');
$sim_data = $builder->get()->getResultArray();

$builder = $this->db->table("once_dept as dept");
$builder->select('dept.*');
$builder->where('dept.status', 'Active');
$dept_data = $builder->get()->getResultArray();

$builder = $this->db->table("once_designation as desgn");
$builder->select('desgn.*');
$builder->where('desgn.status', 'Active');
$desgn_data = $builder->get()->getResultArray();

$builder = $this->db->table("once_star_square as stsq");
$builder->select('stsq.*');
$builder->where('stsq.status', 'Active');
$stsq_data = $builder->get()->getResultArray();

$builder = $this->db->table("once_antivirus as anti");
$builder->select('anti.*');
$builder->where('anti.status', 'Active');
$anti_data = $builder->get()->getResultArray();


?>

<div class="container">
    <div class="row">
        <div class="col-lg-12 my-4 ">
            <h4 class="text-center fw-bold">ALLOTMENT</h4>
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
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="allotment">
                    <button class="nav-link active btn btn-outline-primary fw-semibold" id="email-tab" data-bs-toggle="tab" data-bs-target="#email-tab-pane" type="button" role="tab" aria-controls="email-tab-pane" aria-selected="true">Email</button>
                </li>
                <li class="nav-item" role="allotment">
                    <button class="nav-link btn btn-outline-primary fw-semibold" id="star-tab" data-bs-toggle="tab" data-bs-target="#star-tab-pane" type="button" role="tab" aria-controls="star-tab-pane" aria-selected="false">Star/Square</button>
                </li>
                <li class="nav-item" role="allotment">
                    <button class="nav-link btn btn-outline-primary fw-semibold" id="sim-tab" data-bs-toggle="tab" data-bs-target="#sim-tab-pane" type="button" role="tab" aria-controls="sim-tab-pane" aria-selected="false">Sim Card</button>
                </li>
                <li class="nav-item" role="allotment">
                    <button class="nav-link btn btn-outline-primary fw-semibold" id="antivirus-tab" data-bs-toggle="tab" data-bs-target="#antivirus-tab-pane" type="button" role="tab" aria-controls="antivirus-tab-pane" aria-selected="false">Antivirus</button>
                </li>
                <li class="nav-item" role="allotment">
                    <button class="nav-link btn btn-outline-primary fw-semibold" id="department-tab" data-bs-toggle="tab" data-bs-target="#department-tab-pane" type="button" role="tab" aria-controls="department-tab-pane" aria-selected="false">Department</button>
                </li>
                <li class="nav-item" role="allotment">
                    <button class="nav-link btn btn-outline-primary fw-semibold" id="designation" data-bs-toggle="tab" data-bs-target="#designation-tab-pane" type="button" role="tab" aria-controls="designation-tab-pane" aria-selected="false">Designation</button>
                </li>

            </ul>
            <div class="tab-content" id="myTabContent">
                <!-- email -->
                <div class="tab-pane fade show active" id="email-tab-pane" role="tabpanel" aria-labelledby="email-tab" tabindex="0">
                    <!-- Email Entry -->
                    <form method="post" id="Form" action="<?= base_url('EmailIdController/store/Email'); ?>">
                        <input type="hidden" name="alloted_tab" value="EmailTab">
                        <div class="row justify-content-center">
                            <div class="col">
                                <fieldset class="formborder p-5">
                                    <legend class="float-none w-auto fs-5 fw-semibold"></legend>
                                    <div class="row justify-content-center">
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label class="fw-semibold">Name Allotted</label><span class="text-danger">*</span>
                                                <select class="form-select nameallotted" name="nameallotted">
                                                    <option value="">Select Name</option>
                                                    <?php $i = 1;
                                                    foreach ($query as $emp_dets) { ?>
                                                        <option value="<?= $emp_dets['id'] ?>"><?= $emp_dets['name']; ?></option>

                                                    <?php ++$i;
                                                    } ?>
                                                </select>
                                                <span class="text-danger"><?= displayError($validation, 'nameallotted') ?><span>

                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label class="fw-semibold">Short Code</label><span class="text-danger">*</span>
                                                <div><select disabled name="ShortCode" class="form-control ShortCode">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label class="fw-semibold">Email Id</label><span class="text-danger">*</span>
                                                <div> <select class="form-select " name="emailId">
                                                        <option value="">Select Email</option>
                                                        <?php $i = 1;
                                                        foreach ($email_data as $emp_det) { ?>
                                                            <option value="<?= $emp_det['id'] ?>"><?= $emp_det['email_id']; ?></option>

                                                        <?php ++$i;
                                                        } ?>
                                                    </select>
                                                    <span class="text-danger"><?= displayError($validation, 'emailId') ?><span>
                                                </div>
                                            </div>
                                        </div>
                                         <div class="col-2 text-center">
                                             <br>
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </div>

                                </fieldset>
                            </div>
                        </div>
                    </form>
                    <!-- Email END -->
                    <!-- table start -->
                    <div class="my-3" id="table">
                        <div id="sendmail">
                            <form method="post" action="<?= base_url('EmailIdController/sendmail/Email'); ?>">
                            <button type="submit" class="btn btn-primary">Send Email</button>
                            </form>
                        </div>
                        <table id="tblemail" class="table table-striped table-sm " data-toggle="table"  data-search="true" data-toolbar="#sendmail" data-pagination="true" data-page-list="[10, 25, 50, 100, all]" data-show-export="true" data-icons-prefix="fa" data-icons="icons" data-buttons-class="primary">
                            <thead>
                                <tr class="blue_color">
                                    <th scope="col" data-checkbox="true"></th>
                                    <th scope="col">Name Allotted</th>
                                    <th scope="col">Short Code</th>
                                    <th scope="col">Email Id</th>
                                    <th scope="col" data-align="center">Action</th>
                                </tr>
                            </thead>
                            <?php if ($alot_detail) { // if loop

                                foreach ($alot_detail as $emailData) { //man loop

                                    $email_id = explode(",", $emailData['email_id']);

                                    foreach ($email_id as $val) {
                                        $builder = $this->db->table("once_email as email");
                                        $builder->select('email.email_id,email.id');
                                        $builder->where('email.id', $val);

                                        $emData = $builder->get()->getResultArray();



                                        foreach ($emData as $value) {


                                            if ($emailData['email_id'] != '') { ?>

                                                <tr>
                                                    <td></td>
                                                    <td><?= $emailData['name']; ?></td>
                                                    <td><?= $emailData['emp_short_code']; ?></td>
                                                    <td><?= $value['email_id']; ?></td>
                                                    <td><a href="<?php echo base_url('EmailIdController/edit') . '/' . $emailData['id'] . '/' . $value['id'] . '/Email'; ?>"  target="_blank"><i class="fas fa-edit"></i></a> |
                                                        <a href="<?php echo base_url('EmailIdController/delete') . '/' . $emailData['id'] . '/' . $value['id'] . '/Email'; ?>"> <i class="fas fa-trash-alt" onClick="return doconfirm();"></i></a>
                                                    </td>




                                                </tr>
                            <?php
                                            }
                                        }
                                    }
                                }
                            }
                            ?>


                        </table>
                    </div>

                </div>
                <!-- table end -->

                <!-- end email -->


                <div class="tab-pane fade" id="star-tab-pane" role="tabpanel" aria-labelledby="star-tab" tabindex="0">
                    <!--  Star/Square Entry -->
                    <form method="post" action="<?= base_url('EmailIdController/store/StnSq'); ?>">
                        <div class="row justify-content-center">
                            <input type="hidden" name="alloted_tab" value="StSqTab">
                            <div class="col">
                                <fieldset class="formborder p-5">
                                    <legend class=""></legend>
                                    <div class="row justify-content-center">
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label class="fw-semibold">Name Allotted</label><span class="text-danger">*</span>
                                                <select class="form-select  nameallotted" name="nameallotted">
                                                    <option value="">Select Name</option>
                                                    <?php $i = 1;
                                                    foreach ($query as $emp_dets) { ?>
                                                        <option value="<?= $emp_dets['id'] ?>"><?= $emp_dets['name']; ?></option>

                                                    <?php ++$i;
                                                    } ?>
                                                </select>
                                                <span class="text-danger"><?= displayError($validation, 'nameallotted') ?><span>

                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label class="fw-semibold">Short Code</label><span class="text-danger">*</span>
                                                <div><select disabled name="ShortCode" class="form-control ShortCode">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label class="fw-semibold">Star/Square</label><span class="text-danger">*</span>

                                                <select class="form-select " name="StSq">
                                                    <option value="">Select Star/Square</option>

                                                    <?php
                                                    foreach ($stsq_data as $st_det) { ?>
                                                        <option value="<?php echo $st_det['id']; ?>" style="color:<?= $st_det['color']; ?>;font-weight: bold;">
                                                            <?php if ($st_det['st_sq'] == "st") {
                                                                echo "Star";
                                                            } else if ($st_det['st_sq'] == "sq") {
                                                                echo "Square";
                                                            } ?>

                                                        </option>

                                                    <?php
                                                    } ?>
                                                </select>
                                                <span class="text-danger"><?= displayError($validation, 'StSq') ?><span>

                                            </div>
                                        </div>
                                        <div class="col-md-2 text-center ">
                                            <br>
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    </form>
                    <!-- star/square END -->
                    <!-- table start -->
                    <div class="my-3" id="table">
                        <div id="sendmailstar">
                            <form method="post" action="<?= base_url('EmailIdController/sendmail/StnSq'); ?>">
                            <button type="submit" class="btn btn-primary">Send Email</button>
                            </form>
                        </div>
                        <table class="table table-striped table-sm " data-toggle="table" data-toolbar="#sendmailstar" data-search="true" data-pagination="true" data-page-list="[10, 25, 50, 100, all]" data-show-export="true" data-icons-prefix="fa" data-icons="icons" data-buttons-class="primary">
                            <thead>
                                <tr class="blue_color">
                                    <th scope="col" data-checkbox="true"></th>
                                    <th scope="col">Name Allotted</th>
                                    <th scope="col">Short Code</th>
                                    <th scope="col">Star/Square</th>
                                    <th scope="col" data-align="center">Action</th>
                                </tr>
                            </thead>
                            <?php if ($alot_detail) { // if loop

                                foreach ($alot_detail as $stsqData) { //man loop

                                    $stsq_id = explode(",", $stsqData['star_id']);

                                    foreach ($stsq_id as $val) {
                                        $builder = $this->db->table("once_star_square as stsq");
                                        $builder->select('stsq.st_sq,stsq.id,stsq.color');
                                        $builder->where('stsq.id', $val);

                                        $stData = $builder->get()->getResultArray();



                                        foreach ($stData as $value) {


                                            if ($stsqData['star_id'] != '') { ?>

                                                <tr>
                                                    <td></td>
                                                    <td><?= $stsqData['name']; ?></td>
                                                    <td><?= $stsqData['emp_short_code']; ?></td>
                                                    <td><i class="<?php

                                                                    if ($value['st_sq'] == "st") {
                                                                        echo "fa fa-star";
                                                                    } else if ($value['st_sq'] == "sq") {
                                                                        echo "fa fa-square";
                                                                    }
                                                                    ?>" style="color:<?= $value['color']; ?>"></i></td>
                                                    <td><a  target="_blank" href="<?php echo base_url('EmailIdController/edit') . '/' . $stsqData['id'] . '/' . $value['id'] . '/StnSq'; ?>"><i class="fas fa-edit"></i></a> |
                                                        <a href="<?php echo base_url('EmailIdController/delete') . '/' . $stsqData['id'] . '/' . $value['id'] . '/StnSq'; ?>"> <i class="fas fa-trash-alt" onClick="return doconfirm();"></i></a>
                                                    </td>




                                                </tr>
                            <?php
                                            }
                                        }
                                    }
                                }
                            }
                            ?>

                        </table>
                    </div><!-- table end -->
                </div>
                <!-- Star/Square END -->

                <!-- Main sim Start-->
                <div class="tab-pane fade" id="sim-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">
                    <div class="row justify-content-center">
                        <div class="col">

                            <fieldset class="formborder p-5">
                                <legend class="float-none w-auto fs-5 fw-semibold"></legend>
                                <div class="row justify-content-center">
                                    <div class="col-3">
                                        <form action="<?php echo base_url('EmailIdController/store/Sim'); ?>" name="simVal" onsubmit="return validateFormSim()" method="post">

                                            <input type="hidden" name="alloted_tab" value="SimTab">
                                            <div class="form-group">
                                                <label class="fw-semibold">Name Allotted</label><span class="text-danger">*</span>
                                                <select class="form-select nameallotted " name="nameallotted">
                                                    <option value="">Select Name</option>
                                                    <?php foreach ($query as $emp) { ?>
                                                        <option value="<?php echo $emp["id"]; ?>"><?php echo $emp["name"]; ?></option>
                                                    <?php } ?>
                                                </select>
                                                <span class="text-danger"><?= displayError($validation, 'nameallotted') ?><span>

                                            </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="fw-semibold">Short Code</label><span class="text-danger">*</span>
                                            <div><select disabled name="ShortCode" class="form-control ShortCode">
                                                </select></div>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="fw-semibold">Sim Card</label>
                                            <select class="form-select" name="simcard" id="simcard">
                                                <option value="">Select Simcard</option>
                                                <?php foreach ($sim_data as $sim) { ?>
                                                    <option value="<?php echo $sim["id"]; ?>"><?php echo $sim["number"]; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-1">
                                        <div class="form-check">
                                            <br>
                                            <input class="form-check-input" type="checkbox" id="gridCheck" name="gridCheck" onchange='handleChange(this);' value="0">
                                            <label class="form-check-label" for="gridCheck">Personal</label>
                                        </div>
                                    </div>
                                    <div class="col-2 text-center">
                                        <br>
                                        <button type="submit" class="btn btn-primary">Save</button>
                                        </form>
                                    </div>
                                </div>


                                <!--<div class="row justify-content-center my-4">-->
                                <!--    <div class="col-md-2 text-center ">-->
                                <!--        <button type="submit" class="btn btn-primary">Save</button>-->
                                <!--        </form>-->
                                <!--    </div>-->
                                <!--</div>-->

                            </fieldset>
                        </div>
                    </div>

                    <!-- Sim END -->
                    <!-- table start -->
                    <div class="my-3" id="table">
                         <div id="sendmailsim">
                            <form method="post" action="<?= base_url('EmailIdController/sendmail/Sim'); ?>">
                            <button type="submit" class="btn btn-primary">Send Email</button>
                            </form>
                         </div>
                        <table class="table table-striped table-sm " data-toggle="table"  data-toolbar="#sendmailsim" data-search="true" data-pagination="true" data-page-list="[10, 25, 50, 100, all]" data-show-export="true" data-icons-prefix="fa" data-icons="icons" data-buttons-class="primary">
                            <thead>
                                <tr class="blue_color">
                                    <th scope="col" data-checkbox="true"></th>
                                    <th scope="col">Name Allotted</th>
                                    <th scope="col">Short Code</th>
                                    <th scope="col">Sim Card</th>
                                    <th scope="col" data-align="center">Action</th>
                                </tr>
                            </thead>
                             <tbody>
                                <?php
                                if ($alot_detail) {
                                    foreach ($alot_detail as $sim) {
                                        if ($sim['sim_id'] != '') {
                                            $sim_id = explode(",", $sim['sim_id']);


                                            foreach ($sim_id as $val) {
                                                $builder = $this->db->table("once_simcard as sim");
                                                $builder->select('sim.number,sim.id');
                                                $builder->where('sim.id', $val);

                                                $smData = $builder->get()->getResultArray();



                                                foreach ($smData as $value) {

                                                    $number = $value["number"];

                                ?>

                                                    <tr>
                                                        <td></td>
                                                        <td><?php echo $sim["name"]; ?></td>
                                                        <td><?php echo $sim["emp_short_code"]; ?></td>
                                                        <td><?php echo $number; ?></td>

                                                        <td> <a href="<?php echo base_url('EmailIdController/edit') . '/' . $sim['id'] . '/' . $value['id'] . '/Sim'; ?> "><i class="fas fa-edit"></i></a> |
                                                            <a href="<?php echo base_url('EmailIdController/delete') . '/' . $sim['id'] . '/' . $value['id'] . '/Sim'; ?>"><i class="fas fa-trash-alt" onClick="return doconfirm();"></i></a>
                                                        </td>

                                                    </tr>
                                            <?php
                                                }
                                            }
                                        }
                                        if ($sim['person_sim'] == '1') {

                                            $number = '(' . $sim["per_mobile_no"] . ')';

                                            ?>

                                            <tr>
                                                <td></td>
                                                <td><?php echo $sim["name"]; ?></td>
                                                <td><?php echo $sim["emp_short_code"]; ?></td>
                                                <td><?php echo $number; ?></td>

                                                <td><a href=""><i class="fas fa-edit disabled"></i></a> |
                                                    <a href="<?php echo base_url('EmailIdController/delete') . '/' . $sim['id'] . '/0' . '/Sim'; ?>"><i class="fas fa-trash-alt" onClick="return doconfirm();"></i></a>
                                                </td>

                                            </tr>
                                <?php
                                        }
                                    }
                                } ?>




                            </tbody>
                        </table>
                    </div>

                </div>
                <!-- End Main sim -->
                <!-- antivirus -->
                <div class="tab-pane fade" id="antivirus-tab-pane" role="tabpanel" aria-labelledby="antivirus-tab" tabindex="0">
                    <!-- antivirus Entry -->
                    <form method="post" name="anti" onsubmit="return validateFormAnti()" action="<?= base_url('EmailIdController/store/Anti'); ?>">
                        <input type="hidden" name="alloted_tab" value="AntiTab">
                        <div class="row justify-content-center">
                            <div class="col">
                                <fieldset class="formborder p-5">
                                    <legend class="float-none w-auto fs-5 fw-semibold"></legend>
                                    <div class="row justify-content-center">
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label class="fw-semibold">Name Allotted<span class="text-danger">*</span></label>
                                                <select class="form-select nameallotted" name="nameallotted">
                                                    <option value="">Select Name</option>
                                                    <?php $i = 1;
                                                    foreach ($query as $emp_dets) { ?>
                                                        <option value="<?= $emp_dets['id'] ?>"><?= $emp_dets['name']; ?></option>

                                                    <?php ++$i;
                                                    } ?>
                                                </select>
                                                <span class="text-danger"><?= displayError($validation, 'nameallotted') ?><span>

                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label class="fw-semibold">Short Code<span class="text-danger">*</span></label>
                                                <div><select disabled name="ShortCode" class="form-control ShortCode">
                                                    </select></div>
                                            </div>
                                        </div>
                                        <!-- <div class="col-4">
                                            <div class="form-group">
                                                <label class="fw-semibold">Sevice Provider<span class="text-danger">*</span></label>
                                                <select class="form-select " name="provider">
                                                    <option value="">Select Service Provider</option>
                                                </select>
                                            </div>
                                        </div> -->
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label class="fw-semibold">Keys Allotted</label>
                                                <select class="form-select " name="keyallotted" id="keyallotted">
                                                    <option value="">Select Key</option>
                                                    <?php $i = 1;
                                                    foreach ($anti_data as $anti_det) { ?>
                                                        <option value="<?= $anti_det['id'] ?>"><?= $anti_det['key_alloted']; ?></option>

                                                    <?php ++$i;
                                                    } ?>

                                                </select>
                                            </div>
                                        </div>
                                         <div class="col-3">
                                            <div class="form-group">
                                                <label class="fw-semibold">Personal Antivirus</label>
                                                <div><input type="text" name="P_anti" class="form-control" id="P_anti"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row justify-content-center mt-2">
                                        <div class="col-2 text-center">
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </div>

                                </fieldset>
                            </div>
                        </div>
                    </form>
                    <!-- antivirus Entry END -->
                    <!-- table start -->
                    <div class="my-3" id="table">
                      <div id="sendmailantivirus">
                        <form method="post" action="<?= base_url('EmailIdController/sendmail/Anti'); ?>">
                        <button type="submit" class="btn btn-primary">Send Email</button>
                        </form>
                      </div>
                        <table class="table table-striped table-sm" data-toggle="table" data-search="true"  data-toolbar="#sendmailantivirus" data-pagination="true" data-page-list="[10, 25, 50, 100, all]" data-show-export="true" data-icons-prefix="fa" data-icons="icons" data-buttons-class="primary">
                            <thead>
                                <tr>
                                    <th scope="col" data-checkbox="true"></th>
                                    <th scope="col">Name Allotted</th>
                                    <th scope="col">Short Code</th>
                                    <th scope="col">Service Provider</th>
                                    <th scope="col">Keys Allotted</th>
                                    <th scope="col" data-align="center">Action</th>
                                </tr>
                            </thead>
                           <tbody>
                                <?php
                                if ($alot_detail) {
                                    foreach ($alot_detail as $anti) {
                                        if ($anti['anti_id'] != '') {
                                            $anti_id = explode(",", $anti['anti_id']);


                                            foreach ($anti_id as $val) {
                                                $builder = $this->db->table("once_antivirus as anti");
                                                $builder->select('anti.key_alloted,anti.id,anti.serv_provider');
                                                $builder->where('anti.id', $val);

                                                $antiData = $builder->get()->getResultArray();



                                                foreach ($antiData as $value) {

                                ?>

                                                    <tr>
                                                        <td></td>
                                                        <td><?php echo $anti["name"]; ?></td>
                                                        <td><?php echo $anti["emp_short_code"]; ?></td>
                                                        <td><?php echo $value['serv_provider']; ?></td>
                                                        <td><?php echo $value['key_alloted']; ?></td>

                                                        <td> <a href="<?php echo base_url('EmailIdController/edit') . '/' . $anti['id'] . '/' . $value['id'] . '/Anti'; ?> "><i class="fas fa-edit"></i></a> |
                                                            <a href="<?php echo base_url('EmailIdController/delete') . '/' . $anti['id'] . '/' . $value['id'] . '/Anti'; ?>"><i class="fas fa-trash-alt" onClick="return doconfirm();"></i></a>
                                                        </td>

                                                    </tr>
                                            <?php
                                                }
                                            }
                                        }
                                        if ($anti['person_anti'] != '') {

                                            ?>

                                            <tr>
                                                <td></td>
                                                <td><?php echo $anti["name"]; ?></td>
                                                <td><?php echo $anti["emp_short_code"]; ?></td>
                                                <td></td>
                                                <td><?php echo $anti["person_anti"]; ?></td>

                                                <td><a href="<?php echo base_url('EmailIdController/edit') . '/' . $anti['id'] . '/0' . '/Anti'; ?> "><i class="fas fa-edit"></i></a> |
                                                    <a href="<?php echo base_url('EmailIdController/delete') . '/' . $anti['id'] . '/0' . '/Anti'; ?>"><i class="fas fa-trash-alt" onClick="return doconfirm();"></i></a>
                                                </td>

                                            </tr>
                                <?php
                                        }
                                    }
                                } ?>



                            </tbody>
                        </table>
                    </div><!-- table end -->
                </div>
                <!-- antivirus END -->

                <!-- designation -->
                <div class="tab-pane fade" id="designation-tab-pane" role="tabpanel" aria-labelledby="designation-tab" tabindex="0">
                    <!--  designation Entry -->
                    <form method="post" action="<?= base_url('EmailIdController/store/Desgn'); ?>">
                        <input type="hidden" name="alloted_tab" value="DesgnTab">
                        <div class="row justify-content-center">
                            <div class="col">
                                <fieldset class="formborder p-5">
                                    <div class="row justify-content-center">
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label class="fw-semibold">Name Allotted<span class="text-danger">*</span></label>
                                                <select class="form-select nameallotted" name="nameallotted">
                                                    <option value="">Select Name</option>
                                                    <?php $i = 1;
                                                    foreach ($query as $emp_dets) { ?>
                                                        <option value="<?= $emp_dets['id'] ?>"><?= $emp_dets['name']; ?></option>

                                                    <?php ++$i;
                                                    } ?>
                                                </select>
                                                <span class="text-danger"><?= displayError($validation, 'nameallotted') ?><span>

                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label class="fw-semibold">Short Code<span class="text-danger">*</span></label>
                                                <div><select disabled name="ShortCode" class="form-control ShortCode">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label class="fw-semibold">Designation Name<span class="text-danger">*</span></label>
                                                <select class="form-select " name="DesignId">
                                                    <option value="">Select Designation</option>
                                                    <?php $i = 1;
                                                    foreach ($desgn_data as $des_det) { ?>
                                                        <option value="<?= $des_det['id'] ?>"><?= $des_det['designation']; ?></option>

                                                    <?php ++$i;
                                                    } ?>
                                                </select>
                                                <span class="text-danger"><?= displayError($validation, 'DesignId') ?><span>

                                            </div>
                                        </div>
                                        <div class="col-md-2 text-center ">
                                            <br>
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    </form>
                    <!-- designation END -->
                    <!-- table start -->
                    <div class="my-3" id="table">
                        <div id="sendmaildesig">
                            <form method="post" action="<?= base_url('EmailIdController/sendmail/Desgn'); ?>">
                            <button type="submit" class="btn btn-primary">Send Email</button>
                            </form>
                         </div>
                        <table class="table table-striped table-sm " data-toggle="table"  data-search="true"  data-toolbar="#sendmaildesig" data-pagination="true" data-page-list="[10, 25, 50, 100, all]" data-show-export="true" data-icons-prefix="fa" data-icons="icons" data-buttons-class="primary">
                            <thead>
                                <tr class="blue_color">
                                    <th scope="col" data-checkbox="true"></th>
                                    <th scope="col">Name Allotted</th>
                                    <th scope="col">Short Code</th>
                                    <th scope="col">Designation</th>
                                    <th scope="col" data-align="center">Action</th>
                                </tr>
                            </thead>
                            <?php if ($alot_detail) { // if loop

                                foreach ($alot_detail as $desgnData) { //man loop

                                    $desgn_id = explode(",", $desgnData['desig_id']);

                                    foreach ($desgn_id as $val) {
                                        $builder = $this->db->table("once_designation as desgn");
                                        $builder->select('desgn.designation,desgn.id');
                                        $builder->where('desgn.id', $val);

                                        $emData = $builder->get()->getResultArray();



                                        foreach ($emData as $value) {


                                            if ($desgnData['desig_id'] != '') { ?>
                                                <tr>
                                                    <td></td>
                                                    <td><?= $desgnData['name']; ?></td>
                                                    <td><?= $desgnData['emp_short_code']; ?></td>
                                                    <td><?= $value['designation']; ?></td>
                                                    <td><a target="_blank" href="<?php echo base_url('EmailIdController/edit') . '/' . $desgnData['id'] . '/' . $value['id'] . '/Desgn'; ?>"><i class="fas fa-edit"></i></a> |
                                                        <a href="<?php echo base_url('EmailIdController/delete') . '/' . $desgnData['id'] . '/' . $value['id'] . '/Desgn'; ?>"> <i class="fas fa-trash-alt" onClick="return doconfirm();"></i></a>
                                                    </td>




                                                </tr>
                            <?php
                                            }
                                        }
                                    }
                                }
                            }
                            ?>
                        </table>
                    </div><!-- table end -->
                </div>
                <!-- designation END -->
                <!-- department -->
                <div class="tab-pane fade" id="department-tab-pane" role="tabpanel" aria-labelledby="department-tab" tabindex="0">
                    <!--  department Entry -->
                    <form method="post" action="<?= base_url('EmailIdController/store/Dept'); ?>">
                        <input type="hidden" name="alloted_tab" value="DeptTab">
                        <div class="row justify-content-center">
                            <div class="col">
                                <fieldset class="formborder p-5">
                                    <legend class=""></legend>
                                    <div class="row justify-content-center">
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label class="fw-semibold">Name Allotted<span class="text-danger">*</span></label>
                                                <select class="form-select nameallotted" name="nameallotted">
                                                    <option value="">Select Name</option>
                                                    <?php $i = 1;
                                                    foreach ($query as $emp_dets) { ?>
                                                        <option value="<?= $emp_dets['id'] ?>"><?= $emp_dets['name']; ?></option>

                                                    <?php ++$i;
                                                    } ?>
                                                </select>
                                                <span class="text-danger"><?= displayError($validation, 'nameallotted') ?><span>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label class="fw-semibold">Short Code<span class="text-danger">*</span></label>
                                                <div><select disabled name="ShortCode" class="form-control ShortCode">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label class="fw-semibold">Department Name<span class="text-danger">*</span></label>
                                                <select class="form-select " name="department">
                                                    <option value="">Select Department</option>
                                                    <?php $i = 1;
                                                    foreach ($dept_data as $dept_det) { ?>
                                                        <option value="<?= $dept_det['id'] ?>"><?= $dept_det['dept_name']; ?></option>

                                                    <?php ++$i;
                                                    } ?>
                                                </select>
                                                <span class="text-danger"><?= displayError($validation, 'department') ?><span>
                                            </div>
                                        </div>
                                        <div class="col-md-2 text-center ">
                                            <br>
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    </form>
                    <!-- department END -->
                    <!-- table start -->
                    <div class="my-3" id="table">
                        <div id="sendmaildep">
                            <form method="post" action="<?= base_url('EmailIdController/sendmail/Dept'); ?>">
                            <button type="submit" class="btn btn-primary">Send Email</button>
                            </form>
                        </div>
                        <table class="table table-striped table-sm " data-toggle="table" data-search="true"  data-toolbar="#sendmaildep" data-pagination="true" data-page-list="[10, 25, 50, 100, all]" data-show-export="true" data-icons-prefix="fa" data-icons="icons" data-buttons-class="primary">
                            <thead>
                                <tr>
                                    <th scope="col" data-checkbox="true"></th>
                                    <th scope="col">Name Allotted</th>
                                    <th scope="col">Short Code</th>
                                    <th scope="col">Department</th>
                                    <th scope="col" data-align="center">Action</th>
                                </tr>
                            </thead>
                            <?php if ($alot_detail) { // if loop

                                foreach ($alot_detail as $deptData) { //man loop

                                    $dept_id = explode(",", $deptData['dept_id']);

                                    foreach ($dept_id as $val) {
                                        $builder = $this->db->table("once_dept as dept");
                                        $builder->select('dept.dept_name,dept.id');
                                        $builder->where('dept.id', $val);

                                        $emData = $builder->get()->getResultArray();



                                        foreach ($emData as $value) {


                                            if ($deptData['dept_id'] != '') { ?>
                                                <tr>
                                                    <td></td>
                                                    <td><?= $deptData['name']; ?></td>
                                                    <td><?= $deptData['emp_short_code']; ?></td>
                                                    <td><?= $value['dept_name']; ?></td>
                                                    <td><a target="_blank" href="<?php echo base_url('EmailIdController/edit') . '/' . $deptData['id'] . '/' . $value['id'] . '/Dept'; ?>"><i class="fas fa-edit"></i></a> |
                                                        <a href="<?php echo base_url('EmailIdController/delete') . '/' . $deptData['id'] . '/' . $value['id'] . '/Dept'; ?>"> <i class="fas fa-trash-alt" onClick="return doconfirm();"></i></a>
                                                    </td>




                                                </tr>
                            <?php
                                            }
                                        }
                                    }
                                }
                            }
                            ?>
                        </table>
                    </div><!-- table end -->
                </div>
                <!-- department END -->

            </div>
        </div>
    </div>

</div>
<script>
 $(document).ready(function() {
        $(function() {
            var url = window.location.pathname;
            var tabVal = url.substring(url.lastIndexOf('/') + 1);
            if (tabVal == 'Email') {
                $("#email-tab").click();
                $("#email-tab").addClass('active');
                // $("#sim-tab").attr("disabled", true);
                // $("#star-tab").attr("disabled", true);
                // $("#antivirus-tab").attr("disabled", true);
                // $("#department-tab").attr("disabled", true);
                // $("#designation").attr("disabled", true);
            } else if (tabVal == 'Dept') {
                $("#department-tab").click();
                $("#department-tab").addClass('active');
                // $("#sim-tab").attr("disabled", true);
                // $("#star-tab").attr("disabled", true);
                // $("#antivirus-tab").attr("disabled", true);
                // $("#email-tab").attr("disabled", true);
                // $("#designation").attr("disabled", true);
            } else if (tabVal == 'Desgn') {
                $("#designation").click();
                $("#designation").addClass("active");
                // $("#sim-tab").attr("disabled", true);
                // $("#star-tab").attr("disabled", true);
                // $("#antivirus-tab").attr("disabled", true);
                // $("#department-tab").attr("disabled", true);
                // $("#email-tab").attr("disabled", true);
            } else if (tabVal == 'Sim') {
                $("#sim-tab").click();
                $("#sim-tab").addClass("active");
                // $("#designation").attr("disabled", true);
                // $("#star-tab").attr("disabled", true);
                // $("#antivirus-tab").attr("disabled", true);
                // $("#department-tab").attr("disabled", true);
                // $("#email-tab").attr("disabled", true);
            } else if (tabVal == 'Anti') {
                $("#antivirus-tab").click();
                $("#antivirus-tab").addClass("active");
                // $("#designation").attr("disabled", true);
                // $("#star-tab").attr("disabled", true);
                // $("#sim-tab").attr("disabled", true);
                // $("#department-tab").attr("disabled", true);
                // $("#email-tab").attr("disabled", true);
            } else if (tabVal == 'StnSq') {
                $("#star-tab").click();
                $("#star-tab").addClass("active");
                // $("#designation").attr("disabled", true);
                // $("#antivirus-tab").attr("disabled", true);
                // $("#sim-tab").attr("disabled", true);
                // $("#department-tab").attr("disabled", true);
                // $("#email-tab").attr("disabled", true);
            }

        });
    });
    $(".nameallotted").change(function() {
        // $().click(function() {
        var nameAllotted = $(this).val();
        // if (nameAllotted != '') {

        // console.log(nameAllotted);
        $.ajax({
            type: 'GET',
            url: "<?php echo base_url(); ?>/EmailIdController/fetch_emp_short_code/" + nameAllotted,
            data: '',
            cache: false,

            success: function(data) {
                var html = '';
                // var html = $(this).html() + " ";

                var parse_data = JSON.parse(data); //parse encoded data
                $.each(parse_data, function(index, value) {

                    html += ('<option value="' + value.emp_short_code + '">' + value.emp_short_code + '</option>');
                    console.log(html);

                });

                $(".ShortCode").html(html);


            }
        });
        // } else {
        //     alert('Please select Name Allotted');
        // }
    });
    $("#keyallotted").change(function() {
        $("#P_anti").attr("disabled", true);
        if (this.value == '') {
            $("#P_anti").removeAttr('disabled');

        }
    });
    $("#simcard").change(function() {
        $("#gridCheck").attr("disabled", true);
        if (this.value == '') {
            $("#gridCheck").removeAttr('disabled');

        }
    });

    function doconfirm() {
        if (confirm("Are you sure to delete permanently?")) {
            return true;

        } else {
            return false;
        }

    }
    function validateFormSim() {
        
        let a = document.forms["simVal"]["simcard"].value;
        let b = document.forms["simVal"]["gridCheck"].value;
        if (a == "" && b == "0") {
            alert("Please fill out one field  from  Sim tab");
            return false;
        }
    }
    function handleChange(checkbox) {
    if(checkbox.checked == true){
        document.getElementById("gridCheck").value=1;
        // document.getElementById("gridCheck").removeAttribute("disabled");
    }else{
        
        document.getElementById("gridCheck").value='';
        // document.getElementById("gridCheck").setAttribute("disabled", "disabled");
   }
}
    function validateFormAnti() {
        let x = document.forms["anti"]["keyallotted"].value;
        let y = document.forms["anti"]["P_anti"].value;
        if (x == "" && y == "") {
            alert("Please fill out one field  from  Antivirus tab");
            return false;
        }
    }

</script>

<?= $this->endSection() ?>