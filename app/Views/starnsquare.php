<?= $this->extend('include/header.php') ?>
<?= $this->section('content') ?>
<div class="container">
    <div class="row">
        <div class="col-lg-12 my-4 ">
            <h4 class="text-center fw-bold">STAR/SQUARE</h4>
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
    <div class="col-10">
        <button type="button" class="btn btn-primary mb-2" id="showlist">Show List</button>
    </div> 
    </div>

    <!--star&square  -->
    <form action="<?= base_url('OnceStarSquare/store'); ?>"  method="post" > 
    <div class="row justify-content-center">
    <div class="col-10">
    <fieldset  class="formborder p-5">
       <legend class="float-none w-auto fs-5 fw-semibold"></legend>
       <div class="row justify-content-center">
            <div class="col-3">
                <div class="form-group">
                        <label class="fw-semibold">Star/Square<span class="text-danger">*</span></label>
                        <select class="form-select " name="starnsquare" id="starnsquare">
                                <option value="">Select</option>     
                                <option value="st">Star</option>     
                                <option value="sq">Square</option>     
                        </select>
                        <span class="text-danger"><?= displayError($validation, 'starnsquare') ?></span>

                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                        <label class="fw-semibold">Colour Name<span class="text-danger">*</span></label>
                        
                        <select class="form-control input-sm" name="color" id="color">
                        <option value="">Colour</option>
                        <option value="#FF0000">Red</option>
                        <option value="#f68d24">Orange</option>
                        <option value="#FFFF00">Yellow</option>
                        <option value="#009900">Green</option>
                        <option value="#0000FF">Blue</option>
                        <!--<option value="#9900cc">Purple </option>-->
                        <option value="#9400D3">Voilet</option>
                      </select>
                      <span class="text-danger"><?= displayError($validation, 'color') ?></span>
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
<!-- star&square END -->
<!-- table start -->
<div class=" row justify-content-center my-3"  id="table"  style="display: none;">
<div class="col-10">
<table class="table table-striped table-sm " data-toggle="table" data-search="true" data-pagination="true"
data-page-list="[10, 25, 50, 100, all]"  data-show-export="true" data-icons-prefix="fa" data-icons="icons" data-buttons-class="primary">
        <thead>
            <tr class="blue_color">
                
                <th scope="col" data-width="2" data-width-unit="%" data-align="center"> SNo.</th>
                <th scope="col">Star/Square</th>
                
                <th scope="col"  data-align="center">Action</th>
            </tr>
        </thead>
            <?php if ($desi_detail) {
                $i = 1;
                foreach ($desi_detail as $desiData) { ?>
                    <tr>
                        
                        <td><?= $i; ?></td>
                        <td> 
                            <i class="<?php
                        
                      if ($desiData['st_sq'] == "st") {
                    echo "fa fa-star";
                      } else if ($desiData['st_sq'] == "sq") {
                    echo "fa fa-square";
                      }
                      ?>" style="color:<?=$desiData['color']; ?>"></i></td>
                       
                        <td><a href="<?php echo base_url('OnceStarSquare/edit').'/'.$desiData['id'];?>"><i class="fas fa-edit"></i></a> |
                            <a href="<?php echo base_url('OnceStarSquare/delete').'/'.$desiData['id'];?>"> <i class="fas fa-trash-alt"></i></a>
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