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
    <form method="post" action="<?= base_url('OnceStarSquare/update/' . $row['id']); ?>">
        <input type="hidden" name="_method" value="PUT" />
    <div class="row justify-content-center">
    <div class="col-10">
    <fieldset  class="formborder p-4">
       <legend class="float-none w-auto fs-5 fw-semibold"></legend>
       <div class="row justify-content-center">
            <div class="col-3">
                <div class="form-group">
                        <label class="fw-semibold">Star/Square<span class="text-danger">*</span></label>
                        <select class="form-select " name="starnsquare" id="starnsquare">
                                <option value="">Select</option>     
                                <option value="st"<?php
                          if ($row['st_sq'] == "st") {
                              echo "Selected";
                          }
                          ?>>Star</option>     
                                <option value="sq"<?php
                          if ($row['st_sq'] == "sq") {
                              echo "Selected";
                          }
                          ?>>Square</option>     
                        </select>
                        <span class="text-danger"><?= displayError($validation, 'starnsquare') ?></span>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                        <label class="fw-semibold">Colour Name<span class="text-danger">*</span></label>
                        
                        <select class="form-control input-sm" name="color" id="color">
                        <option value="">Colour</option>
                        <option value="#FF0000" <?php
                          if ($row['color']  == "#FF0000") {
                              echo "Selected";
                          }
                          ?>>Red</option>
                        <option value="#FFC948" <?php
                          if ($row['color'] == "#FFC948") {
                              echo "Selected";
                          }
                          ?>>Orange</option>
                        <option value="#FFFF00" <?php
                          if ($row['color'] == "#FFFF00") {
                              echo "Selected";
                          }
                          ?>>Yellow</option>
                        <option value="#35ff35" <?php
                          if ($row['color'] == "#35ff35") {
                              echo "Selected";
                          }
                          ?>>Green</option>
                        <option value="#0000FF" <?php
                          if ($row['color'] == "#0000FF") {
                              echo "Selected";
                          }
                          ?>>Blue</option>
                        <option value="#4B0082" <?php
                          if ($row['color'] == "#4B0082") {
                              echo "Selected";
                          }
                          ?>>Indigo</option>
                        <option value="#9400D3" <?php
                          if ($row['color'] == "#9400D3") {
                              echo "Selected";
                          }
                          ?>>Voilet</option>
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
<table class="table table-striped table-sm "  data-toggle="table"  data-search="true" data-pagination="true"
data-page-list="[10, 25, 50, 100, all]"  data-show-export="true" data-icons-prefix="fa" data-icons="icons" data-buttons-class="primary">
        <thead>
            <tr class="blue_color">
                
                <th scope="col" data-width="2" data-width-unit="%" data-align="center"> SNo.</th>
                <th scope="col">Star/Square</th>
               
                <th scope="col"  data-align="center">Action</th>
            </tr>
        </thead>
            <?php if ($category) {
                $i = 1;
                foreach ($category as $desiData) { ?>
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