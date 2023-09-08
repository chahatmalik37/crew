<!--  --><?= $this->extend('include/header.php') ?>
<?= $this->section('content') ?>
<div class="container">
    <div class="row">
        <div class="col-lg-12 my-4 ">
            <h4 class="text-center fw-bold">SIMCARD</h4>
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
    <form action="<?php echo base_url('SimCard/update/'. $row['id']); ?>" method="post">
        <input type="hidden" name="_method" value="PUT" />

    <div class="row justify-content-center">
    <div class="col">
    <fieldset  class="formborder p-5">
       <legend class="float-none w-auto fs-5 fw-semibold"></legend>
       <div class="row justify-content-center">
            <div class="col-3">
                <div class="form-group">
                        <label class="fw-semibold">Sim Number<span class="text-danger">*</span></label>
                        <div><input type="text" name="simno" id="simno" value="<?php echo $row['number']; ?>" class="form-control"><span class="text-danger"><?= displayError($validation, 'simno') ?></span>
                            
                        </div> 
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                        <label class="fw-semibold">Service Provider<span class="text-danger">*</span></label>
                        <div><input type="text" name="provider" id="provider" value="<?php echo $row['provider']; ?>" class="form-control" maxlength=""></div> 
                        <span class="text-danger"><?= displayError($validation, 'provider') ?></span>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                        <label class="fw-semibold">Package<span class="text-danger">*</span></label>
                        <div><input type="text" name="package" id="package" value="<?php echo $row['package']; ?>" class="form-control" maxlength=""></div> 
                        <span class="text-danger"><?= displayError($validation, 'package') ?></span>
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
<div class="my-3"  id="table"  style="display: none;">
<table class="table table-striped table-sm "  data-toggle="table"  data-search="true" data-pagination="true"
data-page-list="[10, 25, 50, 100, all]"  data-show-export="true" data-icons-prefix="fa" data-icons="icons" data-buttons-class="primary">
        <thead>
            <tr class="blue_color">
            
            <th scope="col" data-width="2" data-width-unit="%" data-align="center">SNo.</th>
            <th scope="col">Sim Number</th>
            <th scope="col">Service Provider</th>
            <th scope="col">Package</th>
            <th scope="col" data-align="center">Action</th>

            </tr>
        </thead>
        <tbody>
             
            <?php
    if($simcard)
        {$i=1;
            foreach($simcard as $sim)
            {?>

           <tr style="background-color:<?php if($sim["status"] === 'Active'){
                echo "#ffbb33fc";
               
               }else{
                echo "";
               }
           ?>">
                    
                    <td><?php echo $i; ?></td>
                    <td><?php echo $sim["number"];?></td>
                    <td><?php echo $sim["provider"]; ?></td>
                    <td><?php echo$sim["package"]; ?></td>
                    
                    <td><a href="<?php echo base_url('SimCard/edit').'/'.$sim['id'];?>"><i class="fas fa-edit"></i></a> |
                    <?php if($sim['status'] == 'Active'){?>
                            <a href="<?php echo base_url('SimCard/delete').'/'.$sim['id'];?>"> <i class="fas fa-trash-alt"></i></a>
                            <?php }
                            else{ ?>
                                <a href=""><i class="fas fa-trash-alt"></i></a>
                           <?php }?>
                        </td>
                    
                </tr>
                <?php ++$i;
            }
            
        }
        else{?>
            
                <tr><td> No Records</td></tr>';
     <?php   }

    ?>
        </tbody>
    </table>
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









    
 



