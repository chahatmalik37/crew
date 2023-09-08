<?= $this->extend('include/header.php') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 my-4 ">
            <h4 class="text-center fw-bold">SEARCH STAFF</h4>
               <div class="text-center star_wrapper">
                 <hr class="top-Line"></hr><i class="fas fa-star fa-xs icons_rotate"></i><hr class="top-Line"></hr>
             </div>
        </div>
    </div>

    <div class="clearfix"></div>
  
    <form action="<?php echo base_url('SearchStaff/search_data'); ?>" method="post"> 
    <div class="row justify-content-center">
        <div class="col-xl-10 col-md-10 mb-4">
            
                        <div class="row no-gutters justify-content-center">
                            <div class="col-md-3 "><input type="text" class="form-control" placeholder="Search" id="search_text" name="search_text"></div>
                            <div class="col-md-2 text-center"><button type="submit" class="btn btn-primary">Search</button></div>                         
                      </div>
        </div>
    </div>
    </form>
</div>


<!-- start table -->
<div class="container-fluid">
<div class="row justify-content-center">
<div class="col-md-6 ">

  
            
            <!--<table class="table table-bordered border-primarytable-hover table-sm">-->
            <table class="table table-striped table-hover table-bordered table-sm" id="table"
  data-toggle="table" >
                <thead>
                    <tr class="bg-gradient-primary sidebar sidebar-dark">
                        <th>Name</th>
                        <th>Short Code</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <?php
                if($search){
                    foreach($search as $aset)
                    {?>
                 
                    <tr style="background-color:<?php if($aset["act_deact_re"] === 'Active'){
                echo "";
               
               }else{
                echo "#ffbb33fc";
               }
           ?>">
                        <td><?php echo $aset["legal_name"]; ?></td>
                        <td><?php echo $aset["emp_short_code"]; ?></td>
                        <td><a href="<?php echo base_url('Employee/get_detail/'.$aset["emp_id"]); ?>" target="_blank"><i class="fas fa-eye"></i></a>
                        
                        <a href="<?php echo base_url('Employee/edit/'.$aset['emp_id']); ?>" target="_blank"><i class="fas fa-edit"></i></a>
                        
                        </td>
                    </tr>
                     <?php }
                }
              else{
              echo 'No Records';
             }
              
             ?>  
            </table>

          

</div>
</div>
</div>
<br>
<?= $this->endSection() ?>
