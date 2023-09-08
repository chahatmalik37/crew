<?= $this->extend('include/header.php') ?>
<?= $this->section('content') ?>

<!--<h4 class="text-center fw-bold purple_color">Welome, </h4> -->
<div class="container">
    <div class="row">
        <div class="col-lg-12 my-4 ">
            <h4 class="text-center fw-bold head_color">DASHBOARD</h4>
             <div class="text-center star_wrapper">
                 <hr class="top-Line"></hr><i class="fas fa-star fa-xs icons_rotate" ></i><hr class="top-Line"></hr>
             </div>
        </div>
    </div>
    
    <div id="calendar" class="mb-4"></div>
    
</div>
  


<script>

      document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
              navLinks: true,
          headerToolbar: {
              left: 'prev,next today',
              center: 'title',
              right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
          showNonCurrentDates:false,
        
        eventSources: [
            {
            url:"<?php echo base_url('Dashboard/event'); ?>",
            backgroundColor: '#cc00ff',
            },
            {
            url:"<?php echo base_url('Dashboard/eventa'); ?>",
            backgroundColor: '#ff751a',
            },
            {
            url:"<?php echo base_url('Dashboard/email_expiry'); ?>",
            backgroundColor: '#99ff33',
            textColor: 'black'
            },
            {
            url:"<?php echo base_url('Dashboard/loadNotes'); ?>",
            backgroundColor: 'green',
            eventTextColor:'red',
            textColor: '#378006',
            },
            {
            url:"<?php echo base_url('Dashboard/loadLeave'); ?>",
            backgroundColor: '#ff471a',
            },
             {
            url:"<?php echo base_url('Dashboard/renewal'); ?>",
            backgroundColor: '#00b3b3',
            },
             
             

             ],
        // eventSources: [

        //     // your event source
        //     {
        //       url: '<?php echo base_url('Dashboard/event'); ?>', // use the `url` property
        //       color: 'yellow',    // an option!
        //       textColor: 'black'  // an option!
        //     }
        // ],
         
        });
        calendar.render();
      });

    </script>
    
    <?= $this->endSection() ?>



