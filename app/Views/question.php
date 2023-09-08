<?= $this->extend('include/header.php') ?>
<?= $this->section('content') ?>
<div class="container">
    <div class="row">
        <div class="col-lg-12 my-4 ">
            <h4 class="text-center fw-bold">INTERVIEW PROCESS</h4>
               <div class="text-center star_wrapper">
                 <hr class="top-Line"></hr><i class="fas fa-star fa-xs icons_rotate star_wrapper"></i><hr class="top-Line"></hr>
             </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>
<form action="<?php echo base_url('Question/search_data'); ?>" method="post"> 

<div class="container">
   <div class="row mb-5  justify-content-center">
        
        <div class="col-md-2"><input type="text" id="search_text" name="search_text" class="form-control" placeholder="Search"></div>
        <div class="col-md-1 "><button type="submit" id="search_ques" name="search_ques" class="btn btn-primary">Search</button></div>
        <div class="col-md-1 "><button type="button" class="btn btn-primary mb-2" id="add">Ques</button></div>

   </div>
</div>
</form>
<div class="clearfix"></div>
       
<!-- start table -->
<div class="container-fluid">
<div class="row justify-content-center">
<div class="col-md-8 ">
<!--<button type="button" class="btn btn-success mb-2" id="add">Add</button>-->
<button type="button" class="btn btn-primary mb-2" id="newques">New</button>
<form action="<?php echo base_url('Question/interview'); ?>" method="post">
 
<table class="table table-striped table-hover table-bordered table-sm" id="table"
  data-toggle="table" style="display: NONE;">
<thead>
    <tr class="bg-color">
      <th scope="col"  data-field="state" data-checkbox="true"></th>
      <th scope="col" data-width="2" data-width-unit="%" data-align="center">SN.</th>
      <th scope="col" data-field="Category" data-formatter="Textlimit" >Category</th>
      <th scope="col" data-field="Question" data-formatter="queslimit"><div class="th-inner_questxt " style="display: inherit;">Question</div></th>
     
      <th style ="display:none;" data-visible="false" data-field="id">ID</th>
      <th scope="col" data-field="Remarks">Remarks</th>
      <th scope="col" data-field="Rating" data-width="2" data-width-unit="%">Rating</th>
      
    </tr>
  </thead>
   <?php
    if($question)
        {
                 $i=1;
                 $j=1;
            foreach($question as $aset)
            {
                 
                echo '
                <tr>
                    <td></td>
                    <td><input type="hidden" name =" question_'.$j.'" value="'.$aset["quest"].'">'.$i.'</td>
                    <td>'.$aset["category"].'</td>
                    <td title="'.$aset["descp"].'">'.$aset["quest"].'</td>
                    
                    <td>'.$aset["id"].'</td>
                    <td class="px-0"><textarea class="form-control form-control-sm" name =" review_'.$j.'" rows="1" maxlength="50" style="width: 180px;"></textarea><input type="hidden" name ="sample_'.$j.'" value='.$aset["descp"].'></td>
                    <td class="px-0"><input type="text" class="form-control form-control-sm" name =" rating_'.$j.'" maxlength="4"><input type="hidden" name ="category_'.$j.'" value="'.$aset["category"].'"></td>

                    
                </tr>';
                ++$i;
                ++$j;
            }
            
        }
        else{
            echo '
                <tr><td> No Records</td></tr>';
        }

    ?>
</table>
<input type="submit" value="Save" id="save" class="btn btn-primary my-2" style="display: NONE;">


</form>
</div>
</div>
</div>
<div class="clearfix"></div>




<!-- $$$$$$$$$$$$$$$$ Add Assets Modal $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$ -->

<!-- modal -->
<div class="modal fade" id="AddAssets" tabindex="-1" aria-labelledby="AddAssetsLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="AddAssetsLabel">Add Question</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="<?php echo base_url('Question/insert'); ?>" method="post">
        <div class="mb-3">
            <label class="col-form-label">Category:</label>
            <input type="text" class="form-control"  placeholder="Category" aria-label="Category" id="category" name="category">

          </div>
          <div class="mb-3">
            <label class="col-form-label">Question:</label>
            <input type="text" class="form-control"  placeholder="Question" aria-label="Assets Name" id=" asset_name" name="asset_name">

          </div>
          
          <div class="mb-3">
            <label class="col-form-label">Sample:</label>
            <input type="text" class="form-control" placeholder="Sample" aria-label="Value" id="value" name="value">
            
          </div>
          
        
      </div>
      <div class="modal-footer text-center">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button></form>
      </div>
    </div>
  </div>
</div>
<!-- $$$$$$$$$$$$$$$$ Add Assets Modal $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$ -->




<!-- $$$$$$$$$$$$$$$$ Edit Assets Modal $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$ -->

<!-- modal -->
<div class="modal fade" id="EditQuestion" tabindex="-1" aria-labelledby="AddAssetsLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="AddAssetsLabel">Edit Question</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="<?php echo base_url('Question/update'); ?>" method="post">
        <div class="mb-3">
            <label class="col-form-label">Category:</label>
            <input type="text" class="form-control"  placeholder="Category" aria-label="Category" id="category_edit" name="category_edit">

          </div>
          <div class="mb-3">
            <label class="col-form-label">Question:</label>
            <input type="text" class="form-control"  placeholder="Question" aria-label="Assets Name" id="question_edit" name="question_edit">

          </div>

          <div class="mb-3">
            <input type="hidden" class="form-control"  placeholder="Question" aria-label="Assets Name" id="id_edit" name="id_edit">

          </div>
          
          <div class="mb-3">
            <label class="col-form-label">Sample:</label>
            <input type="text" class="form-control" placeholder="Sample" aria-label="Value" id="value_edit" name="value_edit">
            
          </div>
          
        
      </div>
      <div class="modal-footer text-center">
        <button type="button" class="btn btn-primary" id="delete_quest">Delete</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button></form>
      </div>
    </div>
  </div>
</div>
<!-- $$$$$$$$$$$$$$$$ Edit Assets Modal $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$ -->

<!-- ################################### Delete Modal ########################################## -->

<!-- Delete Modal -->
<div class=" modal fade " id="DeleteQuest" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">DELETE Question</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      Are you sure you want to DELETE?
      <form action="<?php echo base_url('Question/delete'); ?>" method="post">
       <input type="hidden" class="form-control" name="del_db_id"  id="del_db_id">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Yes</button></form>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
       
      </div>
    </div>
  </div>
</div>
<!-- ################################ Delete Modal ############################################# -->



<script type="text/javascript">
 var $table = $('#table')
  var $button = $('#edit')
  var $button_del = $('#del')
  var $button_add = $('#add')


  $(function() {
    $button.click(function () {
      // $('#EditQuestion').modal('show');
      // var arr = JSON.stringify($table.bootstrapTable('getSelections'));
      // const myObj = JSON.parse(arr);
      // alert(arr.split("/"));
      $('#category_edit').val($table.bootstrapTable('getSelections')[0].Category);
      $('#question_edit').val($table.bootstrapTable('getSelections')[0].Question);
      $('#value_edit').val($table.bootstrapTable('getSelections')[0]._Question_title);
      $('#id_edit').val($table.bootstrapTable('getSelections')[0].id);

      $('#EditQuestion').modal('show');
    })
  }) 
  
   $(function() {
    $button_del.click(function () {
      
      $('#del_db_id').val($table.bootstrapTable('getSelections')[0].id);

      $('#DeleteQuest').modal('show');
    })
  })

  $(function() {
    $button_add.click(function () {
      let enter = prompt("Please enter password:");
      var data = {
          'enter':enter,
          
         }; 

      if (enter == null || enter == "") {
        alert("You cancelled the request")
      } else {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('Question/pass_check'); ?>",
            data:data,  
            success: function (data) {
               // alert(data.length);
                 // var arr = JSON.stringify(data);
               // alert(arr);
               if(data.length == 2){
                  alert("Incorrect Password");
                 }
                const myObj = JSON.parse(data);
                var pass = myObj[0].pass;
                 // alert(pass.length);
                if(pass == enter && data.length != 2){
                   $('#AddAssets').modal('show');
                } 


            }
          });
        // alert("Incorrect Password");
      }
     
    })
  }) 

  $('#table').on('check.bs.table', function (e,row, $element) {
   
    // alert(row.Category);
      $('#category_edit').val(row.Category);
      $('#question_edit').val(row.Question);
      $('#value_edit').val(row._Question_title);
      $('#id_edit').val(row.id);
      $('#EditQuestion').modal('show');

    
}) 

 $("#delete_quest").click(function(){
   var data = {
      'del_db_id':$("#id_edit").val(),
        }; 

   $.ajax({
            type: "POST",
            url: "<?php echo base_url('Question/delete'); ?>",
            data:data,  
            success: function (data) {
               location.reload()

            }
          });
}); 

        
$(document).ready(function(){
  $("#newques").click(function(){
    $("#table").show();
    $("#save").show();

  });
});
  

</script>
<?= $this->endSection() ?>

