<?= $this->extend('include/header.php') ?>
<?= $this->section('content') ?>
<div class="container">
    <div class="row">
        <div class="col-lg-12 my-4 ">
            <h4 class="text-center fw-bold">ANTIVIRUS</h4>
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

    <!--Antivirus -->
    <form action="<?= base_url('OnceAntivirus/store'); ?>" method="post"> 
    <div class="row justify-content-center">
    <div class="col-12">
    <fieldset  class="formborder p-5">
       <legend class="float-none w-auto fs-5 fw-semibold"></legend>
       <div class="row justify-content-center">
            <div class="col-3">
                <div class="form-group">
                        <label class="fw-semibold">Service Provider<span class="text-danger">*</span></label>
                        <input type="text" name="provider" id="provider" value="<?php echo set_value('provider'); ?>" class="form-control" maxlength=""><span class="text-danger"><?= displayError($validation, 'provider') ?></span>                
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                        <label class="fw-semibold">Keys Allotted<span class="text-danger">*</span></label>
                        <input type="text" name="keys" id="keys"  value="<?php echo set_value('keys'); ?>" class="form-control" maxlength=""><span class="text-danger"><?= displayError($validation, 'keys') ?></span>  
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                        <label class="fw-semibold">Expiry Date</label>
                        <input type="date"  name="expirydate" id="expirydate"  class="form-control" value="<?php echo set_value('expirydate'); ?>"><span class="text-danger"></span>
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
<!-- Antivirus END -->
<!-- table start -->
<div class=" row justify-content-center my-3"  id="table"  style="display: none;">
<div class="col-12">
<table class="table table-striped table-sm "  data-toggle="table"  data-search="true" data-pagination="true"
data-page-list="[10, 25, 50, 100, all]"  data-show-export="true" data-icons-prefix="fa" data-icons="icons" data-buttons-class="primary">
        <thead>
            <tr>
                
                <th scope="col" data-width="2" data-width-unit="%" data-align="center"> SNo.</th>
                <th scope="col">Service Provider</th>
                <th scope="col">Keys Allotted</th>
                <th scope="col">Expiry Date</th>
                <th scope="col"  data-align="center">Action</th>
            </tr>
        </thead>
        <?php if ($desi_detail) {
                $i = 1;
                foreach ($desi_detail as $desiData) { 
                if($desiData["expiry_date"] != '0000-00-00'){
                            $end_date = date("d-m-Y", strtotime($desiData["expiry_date"]));
                        }else{ 
                            $end_date= "---";
                    }
                ?>
                    <tr style="background-color:<?php if($desiData["status"] === 'Active'){
                echo "#ffbb33fc";
               
               }else{
                echo "";
               }
           ?>">
                        
                        <td><?= $i; ?></td>
                        <td><?= $desiData['serv_provider']; ?></td>
                        <td><?= $desiData['key_alloted']; ?></td>
                        <td><?= $end_date; ?></td>
                        <td><a href="<?php echo base_url('OnceAntivirus/edit').'/'.$desiData['id'];?>"><i class="fas fa-edit"></i></a> |
                        <?php if($desiData['status'] == 'Active'){?>
                            <a href="<?php echo base_url('OnceAntivirus/delete').'/'.$desiData['id'];?>"> <i class="fas fa-trash-alt"></i></a><?php }
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
</div>
<!-- table end -->
<script>
$(document).ready(function(){
  $("#showlist").click(function(){
    $("#table").slideToggle();

  });
});
</script>

<?= $this->endSection() ?>