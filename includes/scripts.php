<?php
// print_r($_SESSION);
// die();
        if(isset($_SESSION['status']) && $_SESSION['status'] !=''){
          
      ?>
        <script>
        /*swal({
          title: "<?php echo $_SESSION['status']; ?>",
          text: "You clicked the button!",
          icon: "<?php echo $_SESSION['status_code']; ?>",
          button: "Ok!",
        });*/
          $(function(){
            $.notify("<?php echo $_SESSION['status']; ?>",{globalPosition:'top right',className:'<?php echo $_SESSION['status_code']; ?>'});
          });

        </script>
      <?php  
     unset($_SESSION['status']);   
        }
       
      ?>
      

      