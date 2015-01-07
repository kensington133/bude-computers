<?php 
    include '../../funcs/init.php';
    // unset($_SESSION['errors']);
    $check = is_loggedin();
    if($check == false)
    {
        header('Location: ../../index.php');
        exit();
    }
    // print_r($_SESSION);
?>
<!DOCTYPE html>
<!--[if IE 8]> 				 <html class="no-js lt-ie9" lang="en" > <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en" > <!--<![endif]-->
<head>
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width initial-scale=1, maximum-scale=1">
  <title>Create a New Job</title>
  
  <?php require '../../funcs/head.php'; ?>

</head>
<body>

<!-- Navigation -->

  <?php include '../../funcs/menu.php'; ?> 
  
<!-- End Top Bar -->
 
<!--   <div class="row"> -->
    <div class="small-12 columns text-center">

    <!-- <div class="small-3 columns">&nbsp;</div> -->
 
    <!-- Content Slider -->
    <!-- <div class="small-6 columns text-centre"> -->
        <div class="row">
            <div class="small-12 hide-for-small text-center">
                <img src="<?php echo $_LOGO ?>" alt="slide image">
            </div>
        </div>
    </div>

    <!-- <div class="small-3 columns">&nbsp;</div> -->
    <!-- End Content Slider -->
 
    <!-- Mobile Header -->
 
      <div class="row">
        <div class="small-12 columns show-for-small text-center">
 
          <img src="<?php echo $_LOGO ?>" alt="slide image">
 
        </div>
      </div><br>
 
    <!-- End Mobile Header -->
    
    <div class="row">
        <div class="small-12 columns text-center">
        <h1>Create a New Job</h1>
        <div class="row">
            <div class="small-10 columns small-centered">
                <?php
                    if($_GET['s'] == 'y') $y = "success";
                    if( (isset($_SESSION['errors']['job_desc'])) || (isset($_SESSION['errors']['contact_name'])) ) $n = "disabled";

                ?>
              <form action="createjob.php" method="POST">
                        <div class="large-6 small-12 columns">
                                <input <?php if(isset($_SESSION['errors']['contact_name'])) echo "class='error'"; ?> type="text" name="contact_name" placeholder="Contact Name" value="<?php echo $_SESSION['contact_name'];?>"/>
                                <?php if(isset($_SESSION['errors']['contact_name'])) echo $_SESSION['errors']['contact_name']; ?>

                                <input type="text" name="contact_address" placeholder="Address"/>

                                <input type='number' pattern='[0-9]*' name="contact_phone" placeholder="Phone Number"/>

                                <input type="text" name="contact_email" placeholder="Email Address"/>

                        </div>
                        <div class="large-6 small-12 columns">
                                <input type="text" name="product_name" placeholder="Product Name"/>

                                <!-- <input type="text" name="product_reference" placeholder="Reference Number"/> -->

                                <textarea style='height:125px;' name="product_notes" placeholder='Notes'></textarea>
                        </div>
                      <div class="small-12 columns">
                        <textarea style='height:125px;' <?php if(isset($_SESSION['errors']['job_desc'])) echo "class='error'"; ?> name="job_description" placeholder="Job Description"><?php echo $_SESSION['job_description']; ?></textarea>
                        <?php if(isset($_SESSION['errors']['job_desc'])) echo $_SESSION['errors']['job_desc']; ?>


                        <input type="submit" class="button large expand <?php echo $y,$n?>" value="Save" />
                    </div>
                </form>
            </div>
          </div>
        </div>
    </div>
    <div class="row">
 
    <!-- End Content -->
 
 
    <!-- Footer -->
 
      <footer class="row hide-for-small">
        <div class="small-12 columns"><hr>
            <div class="row">
 
              <div class="small-6 columns">
                  <p>&copy; Ben Short</p>
              </div>
 
              <div class="small-6  columns">
                    <p class="right">Website Design by <a href="http://heybenshort.co.uk">Ben Short</a></p>
              </div>
                
            </div>
        </div>
      </footer>
 
    <!-- End Footer -->
 
    </div>
<!-- </div> -->
	<script src="/js/vendor/jquery.js"></script>
	<script src="/js/foundation.min.js"></script>
	<script>
		$(document).foundation();
	</script>
<!-- End Footer -->
</body>
</html>
