<?= $this->extend('include/header.php') ?>
<?= $this->section('content') ?>

<div class="container">
    <div class="row">
        <div class="col-lg-12 my-4 ">
            <h4 class="text-center fw-bold">SEARCH RESULTS</h4>
               <div class="text-center star_wrapper">
                 <hr class="top-Line"></hr><i class="fas fa-star fa-xs icons_rotate"></i><hr class="top-Line"></hr>
             </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<form action="<?php echo base_url('Question/search_data'); ?>" method="post"> 
<div class="container">
   <div class="row mb-5  justify-content-center">
        
        <div class="col-md-2"><input type="text" id="search_text" name="search_text" class="form-control"></div>
        <div class="col-md-2 text-center"><button type="submit" id="search_ques" name="search_ques" class="btn btn-primary">Search</button></div>
   </div>
</div>
</form>
<div class="clearfix"></div>
       
<!-- start table -->
<div class="container-fluid">
<div class="row justify-content-center">
<div class="col-md-8 ">
<?php
    if($search)
        {
         
            foreach($search as $aset)
            {
                 
                echo '<a  href = "'.base_url('Question/get_detail').'/'.$aset["user_id"].'" target="_blank" >'.$aset["review"].',</a>&nbsp&nbsp;&nbsp;&nbsp;';
            }
        }
        else{
            echo 'No Records';
        }

    ?>

</div>
</div>
</div>
<div class="clearfix"></div>
<?= $this->endSection() ?>

