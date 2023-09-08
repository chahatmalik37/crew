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

$builder = $this->db->table("once_star_square as stsq");
$builder->select('stsq.*');
$builder->where('stsq.status', 'Active');
$stsq_data = $builder->get()->getResultArray();


$builder = $this->db->table("once_dept as dept");
$builder->select('dept.*');
$builder->where('dept.status', 'Active');
$dept_data = $builder->get()->getResultArray();

$builder = $this->db->table("once_designation as desgn");
$builder->select('desgn.*');
$builder->where('desgn.status', 'Active');
$desgn_data = $builder->get()->getResultArray();

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
        <div class="col" id="nav">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="allotment">
                    <button class="nav-link btn btn-outline-primary fw-semibold" id="email-tab" data-bs-toggle="tab" data-bs-target="#email-tab-pane" type="button" role="tab" aria-controls="email-tab-pane" aria-selected="true">Email</button>
                </li>
                <li class="nav-item" role="allotment">
                    <button class="nav-link btn btn-outline-primary fw-semibold" id="star-tab" data-bs-toggle="tab" data-bs-target="#star-tab-pane" type="button" role="tab" aria-controls="star-tab-pane" aria-selected="false">Star/Square</button>
                </li>
                <li class="nav-item" role="allotment">
                    <button class="nav-link btn btn-outline-primary fw-semibold" id="sim-tab" data-bs-toggle="tab" data-bs-target="#sim-tab-pane" type="button" role="tab" aria-controls="sim-tab-pane" aria-selected="false">Simcard</button>
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
                <div class="tab-pane fade show " id="email-tab-pane" role="tabpanel" aria-labelledby="email-tab" tabindex="0">
                    <!-- Email Entry -->
                    <?php
                    if ($edit_alot_detail) {
                        $i = 1;

                        foreach ($edit_alot_detail as $edit) {
                            $builder = $this->db->table("once_email as email");
                            $builder->select('email.email_id,email.id as em_id');

                            $builder->where('email.forwarding_to', '');
                            $builder->where('email.id', $EditValue);

                            $emData = $builder->get()->getResultArray();
                            foreach ($emData as $emailedit) { ?>
                                <form method="post" id="Form" action="<?= base_url('EmailIdController/update/' . $edit['id'] . '/' . $EditValue.'/Email'); ?>">

                                    <input type="hidden" name="alloted_tab" value="EmailTab">
                                    <div class="row justify-content-center">
                                        <div class="col">
                                            <fieldset class="formborder p-5">
                                                <legend class="float-none w-auto fs-5 fw-semibold"></legend>
                                                <div class="row justify-content-center">
                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <label class="fw-semibold">Name Allotted</label><span class="text-danger">*</span>
                                                            <select class="form-select nameallotted" disabled name="nameallotted">
                                                                <option value="">Select Name</option>
                                                                <?php $i = 1;
                                                                foreach ($query as $emp_dets) { ?>
                                                                    <option <?php if ($emp_dets['id'] == $edit['emp_id']) {
                                                                                echo 'selected="selected"';
                                                                            } ?> value="<?php echo $emp_dets['id']; ?>"><?php echo $emp_dets['name']; ?> </option>

                                                                <?php ++$i;
                                                                } ?>
                                                            </select>

                                                        </div>
                                                    </div>
                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <label class="fw-semibold">Short Code</label><span class="text-danger">*</span>
                                                            <div><select disabled name="ShortCode" class="form-control ShortCode">
                                                                    <option value=""><?= $edit['emp_short_code'] ?></option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <label class="fw-semibold">EmailID</label><span class="text-danger">*</span>
                                                            <div> <select class="form-select " name="emailId">
                                                                    <option value="<?= $emailedit['em_id'] ?>"><?= $emailedit['email_id'] ?></option>
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


                                                <!--<div class="row justify-content-center my-4">-->
                                                <!--    <div class="col-md-2 text-center ">-->
                                                <!--        <button type="submit" class="btn btn-primary">Save</button>-->
                                                <!--    </div>-->
                                                <!--</div>-->

                                            </fieldset>
                                        </div>
                                    </div>
                        <?php }
                        }
                    } ?>
                                </form>
                                <!-- Email END -->


                </div>
                <!-- table end -->

                <!-- end email -->


                <div class="tab-pane fade" id="star-tab-pane" role="tabpanel" aria-labelledby="star-tab" tabindex="0">
                    <!--  Star/Square Entry -->
                    <?php
                    if ($edit_alot_detail) {
                        $i = 1;

                        foreach ($edit_alot_detail as $edit) {
                            $builder = $this->db->table("once_star_square as stsq");
                            $builder->select('stsq.st_sq,stsq.id,stsq.color');
                            $builder->where('stsq.id', $EditValue);
                            $stsqData = $builder->get()->getResultArray();
                            foreach ($stsqData as $stsqedit) {

                    ?>
                                <form method="post" action="<?= base_url('EmailIdController/update/' . $edit['id'] . '/' . $EditValue.'/StnSq'); ?>">
                                    <div class="row justify-content-center">
                                        <input type="hidden" name="alloted_tab" value="StSqTab">
                                        <div class="col">
                                            <fieldset class="formborder p-5">
                                                <legend class=""></legend>
                                                <div class="row justify-content-center">
                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <label class="fw-semibold">Name Allotted</label><span class="text-danger">*</span>
                                                            <select disabled class="form-select  nameallotted" name="nameallotted">
                                                                <option value="">Select Name</option>
                                                                <?php $i = 1;
                                                                foreach ($query as $emp_dets) { ?>
                                                                    <option <?php if ($emp_dets['id'] == $edit['emp_id']) {
                                                                                echo 'selected="selected"';
                                                                            } ?> value="<?php echo $emp_dets['id']; ?>"><?php echo $emp_dets['name']; ?> </option>

                                                                <?php ++$i;
                                                                } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <label class="fw-semibold">Short Code</label><span class="text-danger">*</span>
                                                            <div><select disabled name="ShortCode" class="form-control ShortCode">
                                                                    <option value=""><?= $edit['emp_short_code'] ?></option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <label class="fw-semibold">Star/Square</label><span class="text-danger">*</span>
                                                            <select class="form-select " name="StSq">
                                                               
                                                                <?php
                                                                foreach ($stsq_data as $st_det) { ?>
                                                                    <option <?php if($st_det['id'] == $stsqedit['id'] ){ echo 'selected="selected"'; } ?> value=" <?php echo $st_det['id']; ?>" style="color:<?= $st_det['color']; ?>;font-weight: bold;">
                                                                        <?php if ($st_det['st_sq'] == "st") {
                                                                            echo "Star";
                                                                        } else if ($st_det['st_sq'] == "sq") {
                                                                            echo "Square";
                                                                        } ?>

                                                                    </option>

                                                                <?php
                                                                } ?>
                                                            </select>
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
                    <?php }
                        }
                    } ?>
                    <!-- star/square END -->
                </div>
                <!-- Star/Square END -->

                <!-- Main sim Start-->
                <div class="tab-pane fade" id="sim-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">
                    <!-- sim Entry -->

                    <div class="row justify-content-center">
                        <div class="col">

                            <fieldset class="formborder p-5">
                                <legend class="float-none w-auto fs-5 fw-semibold"></legend>
                                <div class="row justify-content-center">
                                    <div class="col-3">
                                        <?php
                                        if ($edit_alot_detail) {
                                            $i = 1;

                                            foreach ($edit_alot_detail as $edit) {
                                                $builder = $this->db->table("once_simcard as sim");
                                                $builder->select('sim.number,sim.id');
                                                $builder->where('sim.id', $EditValue);

                                                $simData = $builder->get()->getResultArray();
                                                if ($simData) {
                                                    foreach ($simData as $simedit) {

                                        ?>
                                                        <form action="<?php echo base_url('EmailIdController/update/' . $edit['id'] . '/' . $EditValue.'/Sim'); ?>" method="post">

                                                            <input type="hidden" name="alloted_tab" value="SimTab">
                                                            <div class="form-group">
                                                                <label class="fw-semibold">Name Allotted</label><span class="text-danger">*</span>
                                                                <select disabled class="form-select nameallotted " name="nameallotted">
                                                                    <option value="0">Select Name</option>
                                                                    <?php foreach ($query as $emp) { ?>
                                                                        <option <?php if ($emp['id'] == $edit['emp_id']) {
                                                                                    echo 'selected="selected"';
                                                                                } ?> value="<?php echo $emp['id']; ?>"><?php echo $emp['name']; ?> </option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="fw-semibold">Short Code</label><span class="text-danger">*</span>
                                            <div><select disabled name="ShortCode" class="form-control ShortCode">
                                                    <option value=""><?= $edit['emp_short_code'] ?></option>
                                                </select></div>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="fw-semibold">Sim Card</label><span class="text-danger">*</span>
                                            <select class="form-select" name="simcard" id="simcard">
                                                <option value="<?= $simedit['em_id'] ?>"><?= $simedit['number'] ?></option>
                                                <?php foreach ($sim_data as $sim) { ?>
                                                    <option value="<?php echo $sim["id"]; ?>"><?php echo $sim["number"]; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-2 text-center">
                                        <br>
                                        <button type="submit" class="btn btn-primary">Save</button></form>
                                    </div>
                                </div>


                                <!--<div class="row justify-content-center my-4">-->
                                <!--    <div class="col-md-2 text-center ">-->
                                <!--        <button type="submit" class="btn btn-primary">Save</button></form>-->
                                <!--    </div>-->
                                <!--</div>-->
                <?php }
                                                }
                                            }
                                        } ?>
                            </fieldset>
                        </div>
                    </div>

                    <!-- Sim END -->

                </div>
                <!-- End Main sim -->
                <!-- antivirus -->
                <div class="tab-pane fade" id="antivirus-tab-pane" role="tabpanel" aria-labelledby="antivirus-tab" tabindex="0">
                    <!-- antivirus Entry -->
                    <?php
                    if ($edit_alot_detail) {
                        $i = 1;

                        foreach ($edit_alot_detail as $edit) {
                            if ($EditValue != '0') {
                                $builder = $this->db->table("once_antivirus as anti");
                                $builder->select('anti.key_alloted,anti.id,anti.serv_provider');
                                $builder->where('anti.id', $EditValue);


                                $antiData = $builder->get()->getResultArray();
                            }


                    ?>
                            <form method="post" action="<?= base_url('EmailIdController/update/' . $edit['id'] . '/' . $EditValue.'/Anti'); ?>">
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
                                                                <option <?php if ($emp_dets['id'] == $edit['emp_id']) {
                                                                            echo 'selected="selected"';
                                                                        } ?> value="<?php echo $emp_dets['id']; ?>"><?php echo $emp_dets['name']; ?> </option>
                                                            <?php } ?>

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="form-group">
                                                        <label class="fw-semibold">Short Code<span class="text-danger">*</span></label>
                                                        <div><select disabled name="ShortCode" class="form-control ShortCode">
                                                                <option value=""><?= $edit['emp_short_code'] ?></option>
                                                            </select></div>
                                                    </div>
                                                </div>
                                                
                                            
                                                <?php if ($antiData) {
                                                    foreach ($antiData as $antiedit) {
                                                        if ($EditValue != '0') { ?>
                                                            <div class="col-3">
                                                                <div class="form-group">
                                                                    <label class="fw-semibold">Keys Allotted<span class="text-danger">*</span></label>
                                                                    <select class="form-select " name="keyallotted" id="keyallotted">
                                                                        <option value="<?= $antiedit['em_id'] ?>"><?= $antiedit['key_alloted'] ?></option>
                                                                        <?php foreach ($anti_data as $anti) { ?>
                                                                            <option value="<?php echo $anti["id"]; ?>"><?php echo $anti["key_alloted"]; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                    <?php }
                                                    }
                                                } else { ?>
                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <label class="fw-semibold">Personal Antivirus</label>
                                                            <div><input type="text" class="form-control" id="P_anti" name="P_anti"  value="<?php echo $edit['person_anti']  ?>"></div>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                                <div class="col-2 text-center">
                                                    <br>
                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                </div>
                                            </div>

                                        </fieldset>
                                    </div>
                                </div>
                            </form>
                    <?php }
                    }

                    ?>
                    <!-- antivirus Entry END -->

                </div>
                <!-- antivirus END -->

                <!-- designation -->
                <div class="tab-pane fade" id="designation-tab-pane" role="tabpanel" aria-labelledby="designation-tab" tabindex="0">
                    <!--  designation Entry -->
                    <?php
                    if ($edit_alot_detail) {
                        $i = 1;

                        foreach ($edit_alot_detail as $edit) {
                            $builder = $this->db->table("once_designation as desgn");
                            $builder->select('desgn.designation,desgn.id');
                            $builder->where('desgn.id', $EditValue);

                            $desgnData = $builder->get()->getResultArray();
                            if ($desgnData) {
                                foreach ($desgnData as $desgnedit) {

                    ?>
                                    <form method="post" action="<?= base_url('EmailIdController/update/' . $edit['id'] . '/' . $EditValue.'/Desgn'); ?>">
                                        <input type="hidden" name="alloted_tab" value="DesgnTab">
                                        <div class="row justify-content-center">
                                            <div class="col">
                                                <fieldset class="formborder p-5">
                                                    <div class="row justify-content-center">
                                                        <div class="col-3">
                                                            <div class="form-group">
                                                                <label class="fw-semibold">Name Allotted<span class="text-danger">*</span></label>
                                                                <select disabled class="form-select nameallotted" name="nameallotted">
                                                                    <option value="">Select Name</option>
                                                                    <?php $i = 1;
                                                                    foreach ($query as $emp_dets) { ?>
                                                                        <option <?php if ($emp_dets['id'] == $edit['emp_id']) {
                                                                                    echo 'selected="selected"';
                                                                                } ?> value="<?php echo $emp_dets['id']; ?>"><?php echo $emp_dets['name']; ?> </option>

                                                                    <?php ++$i;
                                                                    } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-3">
                                                            <div class="form-group">
                                                                <label class="fw-semibold">Short Code<span class="text-danger">*</span></label>
                                                                <div><select disabled name="ShortCode" class="form-control ShortCode">
                                                                        <option value=""><?= $edit['emp_short_code'] ?></option>

                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-3">
                                                            <div class="form-group">
                                                                <label class="fw-semibold">Designation Name<span class="text-danger">*</span></label>
                                                                <select class="form-select " name="DesignId">
                                                                     <?php $i = 1;
                                                                    foreach ($desgn_data as $des_det) { ?>
                                                                        <option <?php if($des_det['id'] == $desgnedit['id'] ){ echo 'selected="selected"'; } ?> value="<?= $des_det['id'] ?>"><?= $des_det['designation']; ?></option>

                                                                    <?php ++$i;
                                                                    } ?>
                                                                </select>
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
                    <?php }
                            }
                        }
                    } ?>
                    <!-- designation END -->

                </div>
                <!-- designation END -->
                <!-- department -->
                <div class="tab-pane fade" id="department-tab-pane" role="tabpanel" aria-labelledby="department-tab" tabindex="0">
                    <!--  department Entry -->
                    <?php
                    if ($edit_alot_detail) {
                        $i = 1;

                        foreach ($edit_alot_detail as $edit) {
                            $builder = $this->db->table("once_dept as dept");
                            $builder->select('dept.dept_name,dept.id');
                            $builder->where('dept.id', $EditValue);

                            $deptData = $builder->get()->getResultArray();
                            if ($deptData) {
                                foreach ($deptData as $deptedit) {

                    ?>
                                    <form method="post" action="<?= base_url('EmailIdController/update/' . $edit['id'] . '/' . $EditValue.'/Dept'); ?>">
                                        <input type="hidden" name="alloted_tab" value="DeptTab">
                                        <div class="row justify-content-center">
                                            <div class="col">
                                                <fieldset class="formborder p-5">
                                                    <legend class=""></legend>
                                                    <div class="row justify-content-center">
                                                        <div class="col-3">
                                                            <div class="form-group">
                                                                <label class="fw-semibold">Name Allotted<span class="text-danger">*</span></label>
                                                                <select disabled class="form-select nameallotted" name="nameallotted">
                                                                    <option value="">Select Name</option>
                                                                    <?php $i = 1;
                                                                    foreach ($query as $emp_dets) { ?>
                                                                        <option <?php if ($emp_dets['id'] == $edit['emp_id']) {
                                                                                    echo 'selected="selected"';
                                                                                } ?> value="<?php echo $emp_dets['id']; ?>"><?php echo $emp_dets['name']; ?> </option>

                                                                    <?php ++$i;
                                                                    } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-3">
                                                            <div class="form-group">
                                                                <label class="fw-semibold">Short Code<span class="text-danger">*</span></label>
                                                                <div><select disabled name="ShortCode" class="form-control ShortCode">
                                                                        <option value=""><?= $edit['emp_short_code'] ?></option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-3">
                                                            <div class="form-group">
                                                                <label class="fw-semibold">Department Name<span class="text-danger">*</span></label>
                                                                <select class="form-select " name="department">
                                                                    <?php $i = 1;
                                                                    foreach ($dept_data as $dept_det) { ?>
                                                                        <option  <?php if($dept_det['id'] == $deptedit['id'] ){ echo 'selected="selected"'; } ?> value="<?= $dept_det['id'] ?>"><?= $dept_det['dept_name']; ?></option>

                                                                    <?php ++$i;
                                                                    } ?>
                                                                </select>
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
                    <?php
                                }
                            }
                        }
                    } ?>
                    <!-- department END -->
                </div>
                <!-- department END -->

            </div>
        </div>
    </div>

</div>
<script>
    $("#keyallotted").change(function() {
        $("#P_anti").attr("disabled", true);
        if (this.value == 'Select') {
            $("#P_anti").removeAttr('disabled');

        }
    });
    $("#simcard").change(function() {
        $("#gridCheck").attr("disabled", true);
        if (this.value == 'Select') {
            $("#gridCheck").removeAttr('disabled');

        }
    });

    $(document).ready(function() {
        $(function() {
            var url = window.location.pathname;
            var tabVal = url.substring(url.lastIndexOf('/') + 1);
            if (tabVal == 'Email') {
                $("#email-tab").click();
                $("#email-tab").addClass('active');
                $("#sim-tab").attr("disabled", true);
                $("#star-tab").attr("disabled", true);
                $("#antivirus-tab").attr("disabled", true);
                $("#department-tab").attr("disabled", true);
                $("#designation").attr("disabled", true);
            } else if (tabVal == 'Dept') {
                $("#department-tab").click();
                $("#department-tab").addClass('active');
                $("#sim-tab").attr("disabled", true);
                $("#star-tab").attr("disabled", true);
                $("#antivirus-tab").attr("disabled", true);
                $("#email-tab").attr("disabled", true);
                $("#designation").attr("disabled", true);
            } else if (tabVal == 'Desgn') {
                $("#designation").click();
                $("#designation").addClass("active");
                $("#sim-tab").attr("disabled", true);
                $("#star-tab").attr("disabled", true);
                $("#antivirus-tab").attr("disabled", true);
                $("#department-tab").attr("disabled", true);
                $("#email-tab").attr("disabled", true);
            } else if (tabVal == 'Sim') {
                $("#sim-tab").click();
                $("#sim-tab").addClass("active");
                $("#designation").attr("disabled", true);
                $("#star-tab").attr("disabled", true);
                $("#antivirus-tab").attr("disabled", true);
                $("#department-tab").attr("disabled", true);
                $("#email-tab").attr("disabled", true);
            } else if (tabVal == 'Anti') {
                $("#antivirus-tab").click();
                $("#antivirus-tab").addClass("active");
                $("#designation").attr("disabled", true);
                $("#star-tab").attr("disabled", true);
                $("#sim-tab").attr("disabled", true);
                $("#department-tab").attr("disabled", true);
                $("#email-tab").attr("disabled", true);
            } else if (tabVal == 'StnSq') {
                $("#star-tab").click();
                $("#star-tab").addClass("active");
                $("#designation").attr("disabled", true);
                $("#antivirus-tab").attr("disabled", true);
                $("#sim-tab").attr("disabled", true);
                $("#department-tab").attr("disabled", true);
                $("#email-tab").attr("disabled", true);
            }

        });
    });
</script>

<?= $this->endSection() ?>