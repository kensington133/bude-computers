<?php
    require_once '../../funcs/init.php';

    if(is_loggedin() == false) {
        header('Location: ../../index.php');
        exit();
    }

    $job_data = get_mostrecent_job();
    $job_range = get_jobid_range();
    $job_ids = getAllJobIDs();
    $customer_data = get_customer_by_id($job_data['customer_id']);

    if(count($job_ids) > 0) {
	   foreach($job_ids as $key => $value) {
            if(is_array($value) && $value['job_number'] == $job_data['job_number']) {
                $currentkey = $key;
            }
	   }
    }
	$currentjob = $job_data['job_number'];

	for($i = 0; $i <= count($job_ids); $i++) {
		$prevkey = ($currentkey - 1);
		$nextkey = ($currentkey + 1);
		if($i == count($job_ids)) {
			$finalkey = $i;
		}
	}

	$previd = $job_ids[$prevkey]['job_number'];
	$nextid = $job_ids[$nextkey]['job_number'];

	if($nextkey == $finalkey) {
		$nextid = $job_ids[0]['job_number'];
	}

	if($previd == -1) {
		$previd = $job_ids[$finalkey-1]['job_number'];
	}
?>
<!DOCTYPE html>
<!--[if IE 8]> <html class="no-js lt-ie9" lang="en" > <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en" > <!--<![endif]-->
<head>
    <title>Existing Jobs</title>
    <?php require_once '../../includes/head.php'; ?>
</head>
<body>

    <?php include '../../includes/menu.php'; ?>
    <div class="row">
        <div class="small-12 columns text-center">
            <div class="small-12 text-center">
                <img src="<?php echo $_LOGO ?>" alt="slide image">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="small-12 columns">
            <h1 class="text-center">Existing Jobs</h1>
            <?php
                if(isset($_GET['id'])) {
                    $job_data = get_jobby_id($_GET['id']);
                    $job_ids = getAllJobIDs();

                  	foreach($job_ids as $key => $value) {
            			if(is_array($value) && $value['job_number'] == $job_data['job_number']) {
            				$currentkey = $key;
            			}
            		}

                    $currentjob = $job_data['job_number'];

        			for($i = 0; $i <= count($job_ids); $i++) {
        				$prevkey = ($currentkey - 1);
        				$nextkey = ($currentkey + 1);
        				if($i == count($job_ids)) {
        					$finalkey = $i;
        				}
        			}

        			$previd = $job_ids[$prevkey]['job_number'];
        			$nextid = $job_ids[$nextkey]['job_number'];

        			if($nextkey == $finalkey) {
        				$nextid = $job_ids[0]['job_number'];
        			}
        			if($prevkey == -1) {
        				$previd = $job_ids[$finalkey-1]['job_number'];
        			}
                }
            ?>
            <h2 class="text-center"><?php echo nice_date($job_data['date_submitted']); ?> - <?php echo $job_data['time_submitted']; ?></h2>
        </div>
    </div>

    <div class="row">
        <div class="small-12 columns small-centered">
            <form action="updatejob.php" method="POST">
                <div class="small-12 columns">
                    <ul class="button-group even-4 round hide-for-print">
                        <li><a href="/home/jobs/index.php?id=<?php echo $previd; ?>" class="button small">Back</a></li>
                        <li><input type="submit" class="button small" value="Save" /></li>
                        <?php $url = "done.php?id=".$job_data['job_number']."&code=".date('U'); ?>
                        <li><a class="button small" href="<? echo $url ?>">Print</a></li>
                        <li><a href="/home/jobs/index.php?id=<?php echo $nextid; ?>" class="button small">Next</a></li>
                    </ul>
                </div>

                <div class="large-6 medium-6 small-12 columns">
                    <label for="customer_name">Name</label>
                    <input type="text" name="customer_name" placeholder="Customer Name" value="<?php echo $customer_data['customer_name']; ?>" />

                    <label for="customer_address">Address</label>
                    <input type="text" name="customer_address" placeholder="Address" value="<?php echo $customer_data['customer_address']; ?>"/>

                    <label for="customer_phone">Phone Number</label>
                    <input type='number' pattern='[0-9]*' name="customer_phone" placeholder="Phone Number" value="<?php if($customer_data['customer_phone'] != '0') echo $customer_data['customer_phone']; ?>"/>

                    <label for="customer_email">Email Address</label>
                    <input type="email" name="customer_email" placeholder="Email Address" value="<?php echo $customer_data['customer_email']; ?>"/>
                </div>

                <div class="large-6 medium-6 small-12 columns">
                    <label for="product_name">Product Name</label>
                    <input type="text" name="product_name" placeholder="Product Name" value="<?php echo $job_data['product_name']; ?>"/>

                    <label for="job_notes">Notes</label>
                    <textarea style='height:186px;' name="job_notes" placeholder='Notes'><?php echo $job_data['job_notes']; ?></textarea>
                </div>

                <div class="small-12 columns">
                    <label for="job_description">Job Description</label>
                    <textarea style='height:160px;' name="job_description" placeholder="Job Description"><?php echo $job_data['job_description']; ?></textarea>

                    <label for="work_done">Work Carried Out</label>
                    <textarea style='height:160px;' name="work_done" placeholder="Work Carried Out"><?php echo $job_data['work_done']; ?></textarea>
                </div>

                <div class="large-8 medium-8 small-12 columns">
                    <label for="parts_used">Parts Used</label>
                    <textarea style='height:160px; max-width:100%;' name="parts_used" id="parts_used" placeholder="Parts Used" ><?php echo $job_data['parts_used']; ?></textarea>
                </div>

                <div class="large-4 medium-4 small-12 columns">
                    <label for="job_price">Price</label>
                    <textarea style='height:160px;' name="job_price" id="job_price" placeholder="Price - inc VAT"><?php echo $job_data['job_price']; ?></textarea>
                </div>

                <input type="hidden" name="job_number" value="<?php echo $job_data['job_number'];?>">

                <div class="small-12 columns text-center">

                    <input type="radio" name="progress" value="0" id="notStarted" <?php if($job_data['progress'] == '0') echo "checked"?>><label for="notStarted">Not Started</label>
                    <input type="radio" name="progress" value="1" id="inProgress" <?php if($job_data['progress'] == '1') echo "checked"?>><label for="inProgress">In Progress</label>
                    <input type="radio" name="progress" value="2" id="completed" <?php if($job_data['progress'] == '2') echo "checked"?>><label for="completed">Completed</label>

                    <ul class="button-group even-4 round hide-for-print">
                        <li><a href="/home/jobs/index.php?id=<?php echo $previd; ?>" class="button small">Back</a></li>
                        <li><input type="submit" class="button small" value="Save" /></li>
                        <li><a class="button small" href="<? echo $url; ?>">Print</a></li>
                        <li><a href="/home/jobs/index.php?id=<?php echo $nextid; ?>" class="button small">Next</a></li>
                    </ul>
                </div>
            </form>
        </div>
    </div>
    <? require_once '../../includes/footer.php'; ?>
</body>
</html>