<?= $this->extend('include/header.php') ?>
<?= $this->section('content') ?>
<div class="container">
    <div class="row">
        <div class="col-lg-12 my-4 ">
            <h4 class="text-center fw-bold">RENEWALS</h4>
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

    <!--RENEWALS -->
   <form method="post" action="<?= base_url('Renewal/update/' . $row['id']); ?>">
        <input type="hidden" name="_method" value="PUT" />
    <div class="row justify-content-center">
    <div class="col-12">
    <fieldset  class="formborder p-4">
       <legend class="float-none w-auto fs-5 fw-semibold"></legend>
       <div class="row justify-content-center">
            <div class="col-3">
                <div class="form-group">
                        <label class="fw-semibold">Product Name<span class="text-danger">*</span></label>
 

                       <input type="text" name="product" id="product" value="<?= $row['product']?>" class="form-control" maxlength=""><span class="text-danger"><?= displayError($validation, 'product') ?></span>                
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                        <label class="fw-semibold">Category<span class="text-danger">*</span></label>
                        <input type="text" name="category" id="category"  value="<?= $row['category']?>" class="form-control" maxlength=""> <span class="text-danger"><?= displayError($validation, 'category') ?></span> 
                </div>
            </div>
            <div class="col-3">
                <div class="form-group form-control-sm">
                        <label class="fw-semibold">Expiry Date</label>
                        <input type="date"  name="expirydate" id="expirydate" value="<?= $row['expiry_date']?>" class="form-control"><span class="text-danger"><?= displayError($validation, 'expirydate') ?></span>
                </div>
            </div>
            <?php if($row["amount"] != '0'){
                            $amount1  = $row["amount"];
                        }else{ 
                            $amount1 = " ";
                    }?>
            <div class="col-3">
                <div class="form-group form-control-sm">
                        <label class="fw-semibold">Last Renewal Amount</label>
                        <input type="text"  name="amount" id="amount" value="<?= $amount1 ?>" class="form-control"><span class="text-danger"><?= displayError($validation, 'amount') ?></span>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group form-control-sm">
                        <label class="fw-semibold">Notes</label>
                        <input type="text"  name="notes" id="notes" value="<?= $row['notes']?>" class="form-control"><span class="text-danger"><?= displayError($validation, 'notes') ?></span>
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
<table class="table table-striped table-sm "  data-toggle="table" data-search="true" data-pagination="true"
data-page-list="[10, 25, 50, 100, all]"  data-show-export="true" data-icons-prefix="fa" data-icons="icons" data-buttons-class="primary">
        <thead>
            <tr>
                
                <th scope="col" data-width="2" data-width-unit="%" data-align="center"> SNo.</th>
                <th scope="col">Product Name</th>
                <th scope="col">Category</th>
                <th scope="col">Expiry Date</th>
                <th scope="col">Last Renewal Amount</th>
                <th scope="col">Notes</th>
                <th scope="col"  data-align="center">Action</th>
            </tr>
        </thead>
        <?php if ($category) {
                $i = 1;
                foreach ($category as $desiData) { 

                        if($desiData["expiry_date"] != '0000-00-00'){
                            $end_date = date("d-m-Y", strtotime($desiData["expiry_date"]));
                        }else{ 
                            $end_date= "---";
                    }
                    
                    if($desiData["amount"] != '0'){
                            $amount  = $desiData["amount"];
                        }else{ 
                            $amount = " ";
                    }
                    ?>
                    
                    <tr>
                        
                        <td><?= $i; ?></td>
                        <td><?= $desiData['product']; ?></td>
                        <td><?= $desiData['category']; ?></td>
                        <td><?= $end_date; ?></td>
                        <td><?= $amount; ?></td>
                        <td><?= $desiData['notes']; ?></td>
                        <td><a href="<?php echo base_url('Renewal/edit').'/'.$desiData['id'];?>"><i class="fas fa-edit"></i></a>
                        <a href="<?php echo base_url('Renewal/delete').'/'.$desiData['id'];?>"> <i class="fas fa-trash-alt"></i></a>
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