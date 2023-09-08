<?= $this->extend('include/header.php') ?>
<?= $this->section('content') ?>

<div class="container">
    <div class="row">
        <div class="col-lg-12 my-5 ">
            <h4 class="text-center fw-bold">USER DETAIL</h4>
            <div class="text-center star_wrapper">
                 <hr class="top-Line"></hr><i class="fas fa-star fa-xs icons_rotate"></i><hr class="top-Line"></hr>
             </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>
    
     
<!--<div class="container">-->
<!--   <div class="row justify-content-center"></div>-->
<!--</div>-->
<!--<div class="clearfix"></div>-->
       
<!-- start table -->
<div class="container-fluid">
<div class="row justify-content-center">
<div class="col-md-8 ">

<table class="table table-striped table-hover table-bordered table-sm" id="table"
  data-toggle="table" >
<thead>
    <tr class="bg-color">
      <th scope="col"  data-field="state" data-checkbox="true"></th>
      <th scope="col" data-width="2" data-width-unit="%" data-align="center">SN.</th>
      <th scope="col" data-field="Category" data-formatter="Textlimit">Category</th>
      <th scope="col" data-field="Question" data-formatter="queslimit"><div class="th-inner_questxt " style="display: inherit;">Question</div></th>
      
      <th scope="col" data-field="Remarks">Remarks</th>
      <th scope="col" data-field="Rating">Rating</th>
      
    </tr>
  </thead>
   <?php
    if($user_detail)
        {
                // print_r($user_detail);
                 $i=1;
                 
            foreach($user_detail as $ud)
            {
                 
                echo '
                <tr>
                    <td></td>
                    <td>'.$i.'</td>
                    <td>'.$ud["cat_ques"].'</td>
                    <td title="'.$ud["sample"].'">'.$ud["ques_id"].'</td>
                    
                    <td>'.$ud["review"].'</td>
                    <td>'.$ud["rating"].'</td>

                    
                </tr>';
                ++$i;
                
            }
            
        }
        else{
            echo '
                <tr><td> No Records</td></tr>';
        }

    ?>
</table>
</div>
</div>
</div>
<div class="clearfix"></div>
<!-- $$$$$$$$$$$$$$$$ Edit Assets Modal $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$ -->

<!-- modal -->
<div class="modal fade" id="EditCan" tabindex="-1" aria-labelledby="AddAssetsLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="AddAssetsLabel">Edit Review</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="<?php echo base_url('Question/edit_review'); ?>" method="post">
        <div class="mb-3">
            <label class="col-form-label">Category:</label>
            <input type="text" class="form-control"  placeholder="Category" aria-label="Category" id="category_edit" name="category_edit">

          </div>
          <div class="mb-3">
            <label class="col-form-label">Question:</label>
            <input type="text" class="form-control"  placeholder="Question" aria-label="Assets Name" id="question_edit" name="question_edit">

          </div>
            <div class="mb-3">
            <label class="col-form-label">Remarks:</label>
                <input type="text" class="form-control"  placeholder="Remarks" aria-label="Assets Name" id="remarks_edit" name="remarks_edit">
            </div>

            <div class="mb-3">
            <label class="col-form-label">Rating:</label>
                <input type="text" class="form-control"  placeholder="Rating" aria-label="Assets Name" id="rating_edit" name="rating_edit">
            </div>

            

          <div class="mb-3">
            <input type="hidden" class="form-control"  placeholder="Question" aria-label="Assets Name" id="id_edit" name="id_edit">

          </div>
          <div class="mb-3">
            <input type="hidden" class="form-control"  placeholder="Question" aria-label="Assets Name" id="user_id" name="user_id" value="<?php echo $user_detail[0]['user_id']; ?>">

          </div>
          
          
        
      </div>
      <div class="modal-footer text-center">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="delete_can">Delete</button>

        <button type="submit" class="btn btn-primary">Save</button></form>
      </div>
    </div>
  </div>
</div>
<!-- $$$$$$$$$$$$$$$$ Edit Assets Modal $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$ -->
<script>
$('#table').on('check.bs.table', function (e,row, $element) {
   var user_id = <?php echo $user_detail[0]['user_id']; ?>;
    // alert(user_id);
    // alert(row.Category);
      $('#category_edit').val(row.Category);
      $('#question_edit').val(row.Question);
      $('#remarks_edit').val(row.Remarks);
      $('#rating_edit').val(row.Rating);
    var data = {
          // 'user_id':row.user,
          'remark':row.Remarks,
          'quest':row.Question,
          'user_id':user_id,
         };          
          $.ajax({
            type: "POST",
            url: "<?php echo base_url('Question/get_id'); ?>",
            data:data,  
            success: function (data) {
                // alert(data);
                 // var arr = JSON.stringify(data);
               // alert(arr);
               const myObj = JSON.parse(data);
               $("#id_edit").val(myObj[0].id);
               $('#EditCan').modal('show');
            }
          });
}) 

 $("#delete_can").click(function(){
   var data = {
      'del_db_id':$("#id_edit").val(),
    }; 

   $.ajax({
            type: "POST",
            url: "<?php echo base_url('Question/delete_review'); ?>",
            data:data,  
            success: function (data) {
               location.reload()

            }
          });
});
</script>
<br>


<?= $this->endSection() ?>
