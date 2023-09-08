<?= $this->extend('include/header.php') ?>
<?= $this->section('content') ?>
<?php $session = session();
?>
<div class="container">
    <div class="row">
        <div class="col-lg-12 my-4 ">
            <h4 class="text-center fw-bold">EMAIL</h4>
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
            <button type="button" class="btn btn-primary mb-2" id="showlist">Show List</button>
        </div>
    </div>

    <!-- Email Entry -->
    <form method="post" action="<?= base_url('OnceEmail/store'); ?>">
        <div class="row justify-content-center">
            <div class="col">
                <fieldset class="formborder p-5">
                    <legend></legend>
                    <div class="row justify-content-center">
                        <div class="col-3">
                            <div class="form-group">
                                <label class="fw-semibold">Email Id<span class="text-danger">*</span></label>
                                <div><input type="text" name="email" value="<?php echo set_value('email'); ?>" class="form-control"></div>
                                <span class="text-danger"><?= displayError($validation, 'email') ?><span>

                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label class="fw-semibold">Nature of Email<span class="text-danger">*</span></label>
                                <div><input type="text" name="natureofmail" value="<?php echo set_value('natureofmail'); ?>" class="form-control" maxlength=""></div>
                                <span class="text-danger"><?= displayError($validation, 'natureofmail') ?><span>

                            </div>
                        </div>
                        
                        <div class="col-3">
                            <div class="form-group">
                                <label class="fw-semibold">Email Expiry</label>
                                <div><input type="date" name="expiry" value="<?php echo set_value('expiry'); ?>" class="form-control" maxlength=""></div>
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="form-group">
                                <label class="fw-semibold">Forwarding To</label>
                                <div><input type="text" name="forwarding" value="<?php echo set_value('forwarding'); ?>" class="form-control" maxlength=""></div>
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
    <div class="my-3" id="table" style="display: none;">
        <table class="table table-striped table-sm " data-toggle="table" data-search="true" data-pagination="true" data-page-list="[10, 25, 50, 100, all]" data-show-export="true" data-icons-prefix="fa" data-icons="icons" data-buttons-class="primary">
            <thead>
                <tr class="blue_color">
                <th scope="col" data-width="2" data-width-unit="%" data-align="center">SNo.</th>
                    <th scope="col">Email Id</th>
                    <th scope="col">Nature of Email</th>
                    <th scope="col">Expiry</th>
                    <th scope="col">Forwarding To</th>
                    
                    <th scope="col" data-align="center">Action</th>

                </tr>
            </thead>
            <?php if ($email_detail) {
                $i = 1;
                foreach ($email_detail as $emailData) { ?>
                    <tr style="background-color:<?php if($emailData["status"] === 'Active'){
                echo "#ffbb33fc";
               
               }else{
                echo "";
               }
               
               if($emailData['expiry_date'] != '0000-00-00'){
                   $end_date = date("d-m-Y", strtotime($emailData["expiry_date"]));
                }else{ 
                    $end_date= "---";
                }
           ?>">
                        <td><?= $i; ?></td>
                        <td><?= $emailData['email_id']; ?></td>
                        <td><?= $emailData['nature_of_email']; ?></td>
                        <td><?= $end_date; ?></td>
                        <td><?= $emailData['forwarding_to']; ?></td>
                        
                        <td><a href="<?php echo base_url('OnceEmail/edit').'/'.$emailData['id'];?>"><i class="fas fa-edit"></i></a> |
                            <?php if($emailData['status'] == 'Active'){?>
                            <a href="<?php echo base_url('OnceEmail/delete').'/'.$emailData['id'];?>"> <i class="fas fa-trash-alt"></i></a><?php }
                            else{ ?>
                                <a href=""><i class="fas fa-trash-alt"></i></a>
                           <?php }?>
                        </td>




                    </tr>
            <?php ++$i;
                }
            } ?>
        </table>
    </div>

</div>


<!-- table end -->

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
    $(document).ready(function() {
        $("#showlist").click(function() {
            $("#table").slideToggle();

        });
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
</script>


<?= $this->endSection() ?>