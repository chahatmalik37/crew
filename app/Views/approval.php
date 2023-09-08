<?= $this->extend('include/header.php') ?>
<?= $this->section('content') ?>

<div class="container">
    <div class="row">
        <div class="col-lg-12 my-4 ">
            <h4 class="text-center fw-bold">APPROVAL</h4>
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
    <div id="updateatt">
        <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#Attendance">Edit</button>

    </div> 
    </div>
<!-- modal -->
<?php
    $this->db = db_connect();
    $builder = $this->db->table("employee as emp");
    $builder->select('emp.name,emp.emp_short_code,emp.id');
    $builder->where('emp.status','Active');
    $builder->orderby('emp.emp_short_code','asc');

    $query = $builder->get()->getResultArray();

    ?>

    <div class="modal fade" id="Attendance" tabindex="-1" aria-labelledby="AttendanceLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="Attendance">Edit Attendance</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                    <form  method="post">

                    <!--<div class="mb-12">-->
                        <div class="mb-3">
                            <label class="col-form-label">Name:</label>
                            <select required class="form-select attendance_change" name="username" id="username">
                                <option value="">Select Name</option>
                                <?php $i = 1;
                                foreach ($query as $emp_det) { ?>
                                    <option value="<?= $emp_det['id'] ?>"><?= $emp_det['name'] . '-' . $emp_det['emp_short_code'] ?></option>

                                <?php ++$i;
                                } ?>
                            </select>

                        </div>


                        <div class="mb-3">
                            <label class="col-form-label">Date:</label>
                            <input type="date" required class="form-control attendance_change" placeholder="Date" aria-label="date" name="date" id="date"></div>

                            <div class="mb-3">
                            <label class="col-form-label">Type:</label>
                            <select required class="form-select  attendance_change" name="type" id="type">
                                <option value="1">Login</option>
                                <option value="2">Break</option>
                                <option value="4">Restart</option>
                                <option value="3">Logout</option>
                            </select>

                        </div>
                        <table class="table table-striped table-hover table-bordered table-sm" id="tbl_view">
                         <thead>
                            <tr>
                              <!--<th scope="col">Type</th>-->
                              
                              <th scope="col">Log Time</th>
                              <th scope="col">Date</th>
                               <th scope="col">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                          
                        </tbody>
                        </table>
                    <!--</div>-->
                       
                    </div>
                    <div class="modal-footer text-center">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="save" formaction="<?= base_url('Attendance/UpdateAttendance'); ?>"  class="btn btn-primary">Save</button>

                    </div>
                </div>
            </form>
        </div>
    </div>


<!-----Update Attendanence End------>
        <!-- table start -->
        <table class="table table-striped table-sm " id="table" data-toggle="table"  data-search="true" data-toolbar="#updateatt" data-pagination="true" data-page-list="[10, 25, 50, 100, all]" data-show-export="true" data-icons-prefix="fa" data-icons="icons" data-buttons-class="primary">
            <thead>
                <tr>
                    <th scope="col" data-checkbox="true"></th>
                    <th scope="col" data-width="2" data-width-unit="%" data-align="center">SNo.</th>
                    <th scope="col">Name</th>
                    <th scope="col">Short Code</th>
                    <th scope="col">Type</th>
                    <th scope="col">Appoval Date & Time</th>
                    <th scope="col" data-align="center">Action</th>
                    <th scope="col" data-visible="false" data-field="db_id" data-align="center">DB Id</th>

                </tr>
            </thead>
        <?php if ($approval) {
                  $i = 1;
                
              foreach ($approval as $desiData) {
                    if($desiData['log_type']=='1'){
                      $log_type = 'Login';  
                    }elseif($desiData['log_type']=='2'){
                      $log_type = 'Break';  
                    }elseif($desiData['log_type']=='3'){
                      $log_type = 'Logout';  
                    }elseif($desiData['log_type']=='4'){
                      $log_type = 'Restart';  
                    }
                
                ?>

                    
                    <tr>

                        
                         <td scope="col" data-checkbox="true"></td>
                         <td><?= $i; ?></td>
                        <td><?= $desiData['name']; ?></td>
                        <td><?= $desiData['emp_short_code']; ?></td>
                        <td><?= $log_type; ?></td>
                        <td><?= date('d-m-Y, h:iA',strtotime($desiData['start'])); ?></td>
                        <td><a href="<?php echo base_url('Attendance/approval').'/'.$desiData['daily_id'].'/'.$desiData['notes_id'];?>"><i class="far fa-thumbs-up"></i></a>
                        </td>
                        <td><?= $desiData['notes_id']; ?></td>




                    </tr>
            <?php ++$i;
                }?>

            <?php } 
            if ($leave_approval) {?>
            <tr style="background-color:#ffbb33fc"><td></td><td colspan="6" ><b>LEAVE</b></td></tr>

               
           <?php     $j = 1 ;
                foreach ($leave_approval as $leaveData) {
                   
                if($leaveData['end']!='0000-00-00 00:00:00' || $leaveData['end']!='' ){
                  $end_date=  date('d-m-Y, h:iA',strtotime($leaveData['end']));
                } 
                if($leaveData['start']!='0000-00-00 00:00:00'||$leaveData['start']!='' ){
                  $start_date=  date('d-m-Y, h:iA',strtotime($leaveData['start']));
                }
                ?>

                    
                    <tr>

                        
                        <td scope="col" data-checkbox="true"></td>
                        <td><?= $j; ?></td>
                        <td><?= $leaveData['name']; ?></td>
                        <td><?= $leaveData['emp_short_code']; ?></td>
                        <td><?= 'Leave'; ?></td>
                        <td><?= 'Start: '.$start_date.', End: '.$end_date; ?></td>
                        <td><a href="<?php echo base_url('Attendance/leave_approval').'/'.$leaveData['notes_id'];?>"><i class="far fa-thumbs-up"></i></a>
                        </td>




                    </tr>
            <?php ++$j;
                }
            } ?>
                
        </table>  <!-- table end -->

</div>
<!-- Update Approval Model -->
<div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="notesModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">
<div class="modal-header">
    <h5 class="modal-title" id="Attendance">Edit Notes</h5>
    <button type="button" class="btn-close unchecked" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
<form method="post">
<input type="hidden" id="save_id" name="save_id" >
<input type="hidden" id="daily_id" name="daily_id" >

<div class="input-group mb-3">
    <input disabled id="head" class="form-control"> 

</div>

<div class="input-group mb-3">
<span class="input-group-text " id="from">Time For Update:</span>
<input type="datetime-local" name="from_datetime" id="from_time" class="form-control">
</div>

 <textarea class="form-control mb-3" name="notes" id="notes" placeholder="Add Notes:" rows="2"></textarea>
                       
 </div>
<div class="modal-footer">
<button type="submit"  formaction="<?= base_url('Attendance/DeleteNote/Note'); ?>"  class="btn btn-danger">Delete</button>

<button type="button" class="btn btn-secondary unchecked" data-bs-dismiss="modal">Close</button>
<button type="submit" name="save" formaction="<?= base_url('Attendance/updateNote/Note'); ?>"  class="btn btn-primary unchecked">Save</button>
</form>
 </div>
</div>
</div>
</div>
<!-- Update Approval Model end-->
<script>
 $('#table').on('check.bs.table', function (e,row, $element) {
 // alert(row.Category);
 var arr = JSON.stringify(row)
    const myObj = JSON.parse(arr);
    
            var x = myObj["db_id"]; 
          
            $.ajax({ 
        type: 'GET', 
        url: "<?php echo base_url(); ?>/Attendance/fetch_emp_detail_for_approval", 
        data:{note_id:x},
        success: function(data) { 
          htmlData='';
            var parse_data = JSON.parse(data); //parse encoded data
                 $.each(parse_data, function(index, value) {
                    var head=value['head'];
                    var notes=value['notes'];
                    var from_time=value['start'];
                    var note_id=value['id'];
                    var daily_id=value['daily_id'];
                    var em=$('#head')
                        em.val(head)
                    var fd=$('#from_time')
                        fd.val(from_time)    
                    var md=$('#notes')
                       md.val(notes)
                    var nd=$('#save_id')
                       nd.val(note_id) 
                    var di=$('#daily_id')
                       di.val(daily_id) 
                    $('#detailsModal').modal('show');
                  
                  });  
               
        }, 
        error:function(err){ 
          alert("error"+JSON.stringify(err)); 
        } 
    }) 
 

});
$(".attendance_change").change(function(){
    // alert("on change");
    var data = {
        'username': $("#username").val(),
          'type': $("#type").val(),
          'date': $("#date").val(),
         };
         if(data.username!='' && data.type!='' && data.date!=''){
        $.ajax({
            type:"GET",
            url:"<?php echo base_url('Attendance/get_detail') ?>",
            data:data,
            success :function (data) {
                // alert(data);
                // $(this).parent('div').remove();
                 $('#tbl_view > tbody').find('tr').remove();
                 data1 = JSON.parse(data);
                 var i =0;
                function myFunction(){
                    if(data1[i].log_type == 1){
                        var template = 'Login';
                    }else if(data1[i].log_type == 2){
                        template = 'Break';
                    }else if(data1[i].log_type == 3){
                        template = 'Logout';
                    }else if(data1[i].log_type == 4){
                        template = 'Restart';
                    }
                    
                    // $("#tbl_view").append('<tr><td class="p-0"><input class="form-control " type="text" name="temp_id[]" value="'+template+'"></td><td class="p-0"><input type="datetime-local"  class="form-control " name ="detail[]" value="'+data1[i].created_at+'"></td><td class="p-0"><input type="date"  class="form-control " name ="attend_detail[]" value="'+data1[i].attendance_date+'"><input type="hidden" name ="id_edit[]" value="'+data1[i].id+'"></td></tr>');
                    //<td >'+template+'</td>
                    $("#tbl_view").append('<tr><td class="p-0"><input type="datetime-local"  class="form-control " name ="detail[]" value="'+data1[i].created_at+'"></td><td class="p-0"><input type="date"  class="form-control " name ="attend_detail[]" value="'+data1[i].attendance_date+'"><input type="hidden" name ="id_edit[]" value="'+data1[i].id+'"></td><td class="text-center"><button  formaction="<?= base_url('Attendance/DeleteAttendance'); ?>" onclick="Delete('+data1[i].id+')"  title="Delete"><i class="fas fa-trash-alt"></i></button></td></tr>');

                    i++;
                }

               data1.forEach(myFunction);
            }
            
        });
    }
   
});

  $('.unchecked').click(function () {
      $('#table').bootstrapTable('uncheckAll')
    });
    
    function Delete(id) {
                 
        if (confirm("Are you sure to delete permanently?")) {
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url('Attendance/DeleteAttendance') ?>",
                        data: {attend_id:id},
                        success: function (data) {                  
                        }
                    });
                  }
                  
                }
                
</script>
<?= $this->endSection() ?>