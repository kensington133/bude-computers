<?php
    require_once '../../funcs/init.php';

    if(is_loggedin() == false) {
        header('Location: ../../index.php');
        exit();
    }
?>
<!DOCTYPE html>
<!--[if IE 8]> <html class="no-js lt-ie9" lang="en" > <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
    <title>Create a New Job</title>
    <?php require '../../includes/head.php'; ?>
</head>
<body>

    <?php require_once '../../funcs/menu.php'; ?>

    <div class="row">
        <div class="small-12 columns text-center">
            <div class="small-12 text-center">
                <img src="<?php echo $_LOGO ?>" alt="slide image">
            </div>
        </div>
    </div>

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
    <? require_once '../../includes/footer.php'; ?>
</body>
</html>
