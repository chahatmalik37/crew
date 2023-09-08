<?= $this->extend('include/header.php') ?>
<?= $this->section('content') ?>
<?php $session = session();
?>
<div class="container">
    <div class="row">
        <div class="col-lg-12 my-4 ">
            <h4 class="text-center fw-bold">DESIGNATION</h4>
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

    <!-- Designation  -->
    <form method="post" action="<?= base_url('OnceDesignation/update/' . $row['id']); ?>">
        <input type="hidden" name="_method" value="PUT" />
    <div class="row justify-content-center">
    <div class="col-10">
    <fieldset  class="formborder p-4">
       <legend class="float-none w-auto fs-5 fw-semibold"></legend>
       <div class="row justify-content-center">
            <div class="col-3">
                <div class="form-group">
                        <label class="fw-semibold">Designation Name<span class="text-danger">*</span></label>
                        <input type="text" name="designation" value="<?= $row['designation'] ?>" class="form-control">
                        <span class="text-danger"><?= displayError($validation, 'designation') ?><span> 
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
<!-- Designation END -->
<!-- table start -->
<div class=" row justify-content-center my-3"  id="table"  style="display: none;">
<div class="col-10">
<table class="table table-striped table-sm "  data-toggle="table" data-search="true" data-pagination="true"
data-page-list="[10, 25, 50, 100, all]"  data-show-export="true" data-icons-prefix="fa" data-icons="icons" data-buttons-class="primary">
        <thead>
            <tr class="blue_color">
           
            <th scope="col" data-width="2" data-width-unit="%" data-align="center"> SNo.</th>
            <th scope="col">Designation Name</th>
            <th scope="col"  data-align="center">Action</th>

            </tr>
        </thead>
        <?php if ($category) {
                $i = 1;
                foreach ($category as $desiData) { ?>
                    <tr>
                        
                        <td><?= $i; ?></td>
                        <td><?= $desiData['designation']; ?></td>
                        <td><a href="<?php echo base_url('OnceDesignation/edit').'/'.$desiData['id'];?>"><i class="fas fa-edit"></i></a> |
                            <a href="<?php echo base_url('OnceDesignation/delete').'/'.$desiData['id'];?>"> <i class="fas fa-trash-alt"></i></a>
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






    
 



