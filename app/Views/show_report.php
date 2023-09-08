<?= $this->extend('include/header.php') ?>
<?= $this->section('content') ?>
<style>
.table-sm td, .table-sm th {
    padding: 0 0.1rem !important;
}

/*.bootstrap-table .fixed-table-container .table.table-sm .th-inner {*/
/*    padding: 0.2rem;*/
/*    font-size: 13px;*/
/*}*/
/*tbody, td, tfoot, th, thead, tr {*/
/*    font-size: 14px;*/
/*}*/
/*body {*/
/*    margin: 0;*/
/*    line-height: 1.3;*/
   
/*}*/
/*input[type=checkbox], input[type=radio] {*/
   
/*    vertical-align: middle;*/
/*}*/
</style>
<div class="container">
  <div class="row">
    <div class="col-lg-12">
        <?php if($empReport){ ?>

      <h4 class="text-center fw-bold text-uppercase"><?php  echo ''.trim($empReport[0]['name']," ").' REPORT'?></h4>
        <?php } ?>
         <div class="text-center star_wrapper">
               <hr class="top-Line"></hr><i class="fas fa-star fa-xs icons_rotate"></i><hr class="top-Line"></hr>
        </div>
    </div>
  </div>
</div>
<div class="clearfix"></div>

<div class="container">
<table  data-sort-class="table-active"
  data-sortable="true"
  class="table table-striped table-sm"  id="table" data-toggle="table"  data-search="true" data-pagination="true" data-page-list="[10, 25, 50, 100, all]" data-show-export="true" data-icons-prefix="fa" data-icons="icons" data-buttons-class="primary"
  data-show-fullscreen="true">
  <thead>
    <tr>
      <th data-checkbox="true"></th>
       <th scope="col" data-width="2" data-width-unit="%" data-align="center">SNo.</th>
       <th scope="col" data-width="10" data-width-unit="%" data-align="center">Date</th>
     <th scope="col">Template</th>
         
     <th scope="col">Report</th>
         
  </tr>
  </thead>
 
  <tbody>         
<?php if($empReport){ ?>
   <!--<h4 style="font-weight:bold;"><?php  //echo 'Report Of '.trim($empReport[0]['name']," ").':-'?></h4>-->
    
  <?php $i=1;
    foreach($empReport as $report) {?>
    <?php  if($report['share']==0){ ?>
   <tr>
        <td ></td>
        <td ><?php echo $i; ?></td>

       <td ><?php echo  date('d-m-Y',strtotime($report['date']))?></td>
     <td><?php if($report['template']!='')  {
        echo $report['template'];
     }else{
        echo $report['template_id'];
     }
      ?></td>
         
     <td><?php echo nl2br($report['report']) ?></td>
         
          </tr>
          <?php }elseif($report['share']==1){ ?>
           <tr style="background-color:#ffbb33fc">
        <td ></td>
        <td ><?php echo $i; ?></td>

       <td ><?php echo  date('d-m-Y',strtotime($report['date']))?></td>
     <td><?php if($report['template']!='')  {
        echo $report['template'];
     }else{
        echo $report['template_id'];
     }
      ?></td>
         
     <td><?php echo $report['report']; ?></td>
         
          </tr>
          
          <?php  }?>
<?php ++$i;}
} ?>
  </tbody>
 </table>
  
</div>
<?= $this->endSection() ?>