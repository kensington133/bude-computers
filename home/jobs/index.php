<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/php/init.php';

    $utils->isLoggedIn();

    if(isset($_GET['id'])){
        $jobData = $jobFeatures->getJobByID($_GET['id']);
    } else {
        $jobData = $jobFeatures->getMostRecentJob();
    }

    $jobIDs = $jobFeatures->getAllJobIDs();

    $maxid = $jobIDs[count($jobIDs) - 1];
    $firstid = $jobIDs[0];

    foreach ($jobIDs as $key => $value) {
        if($value === $jobData['job_number']){
            $currentIDKey = $key;
        }
    }

    foreach ($jobIDs as $key => $value) {
        if($key == ($currentIDKey - 1)){
            $previd = $value;
        }
        if($key == ($currentIDKey + 1)){
            $nextid = $value;
        }
    }

    if($jobData['job_number'] === $maxid){
        $nextid = $jobIDs[0];
    }

    if($jobData['job_number'] === $firstid){
        $previd = $maxid;
    }
?>
<!DOCTYPE html>
<!--[if IE 8]> <html class="no-js lt-ie9" lang="en" > <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en" > <!--<![endif]-->
<head>
    <title>Existing Jobs</title>
    <?php require_once $_PATH.'/includes/head.php'; ?>
</head>
<body>

    <?php include $_PATH.'/includes/menu.php'; ?>
    <div class="row">
        <div class="small-12 columns text-center">
            <div class="small-12 text-center">
                <a href="/home/">
                	<img src="<?php echo $_LOGO ?>" alt="slide image">
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="small-12 columns">
            <h1 class="text-center">Existing Jobs</h1>
            <h2 class="text-center"><?php echo $utils->niceDate($jobData['date_submitted']); ?> - <?php echo $jobData['time_submitted']; ?></h2>
        </div>
    </div>

    <div class="row">
        <div class="small-12 columns small-centered">
            <form action="updatejob.php" method="POST">
                <div class="small-12 columns">
                    <?php $url = "done.php?id=".$jobData['job_number']; ?>
                    <ul class="button-group even-4 round hide-for-print" style="margin-top: 25px;">
                        <li><a href="/home/jobs/?id=<?php echo $previd; ?>" class="button small"><i class="hide-for-small-only fa fa-angle-left"></i> Back</a></li>
                        <li><input type="submit" class="button small fa-input saveButton" value="&#61639; Save" /></li>
                        <li><a class="button small" href="<?php echo $url ?>"><i class="hide-for-small-only fa fa-print"></i> Print</a></li>
                        <li><a href="/home/jobs/?id=<?php echo $nextid; ?>" class="button small">Next <i class="hide-for-small-only fa fa-angle-right"></i></a></li>
                    </ul>
                </div>

                <div class="large-6 medium-6 small-12 columns">
                    <label for="customer_name">Name</label>
                    <input type="text" name="customer_name" placeholder="Customer Name" value="<?php echo $jobData['customer_name']; ?>" />

                    <label for="customer_address">Address</label>
                    <input type="text" name="customer_address" placeholder="Address" value="<?php echo $jobData['customer_address']; ?>"/>

                    <label for="customer_phone">Phone Number</label>
                    <input type='number' pattern='[0-9]*' name="customer_phone" placeholder="Phone Number" value="<?php if($jobData['customer_phone'] != '0') echo $jobData['customer_phone']; ?>"/>

                    <label for="customer_email">Email Address</label>
                    <input type="email" name="customer_email" placeholder="Email Address" value="<?php echo $jobData['customer_email']; ?>"/>
                </div>

                <div class="large-6 medium-6 small-12 columns">
                    <label for="product_name">Product Name</label>
                    <input type="text" name="product_name" placeholder="Product Name" value="<?php echo $jobData['product_name']; ?>"/>

                    <label for="job_notes">Notes</label>
                    <textarea style='height:186px;' name="job_notes" placeholder='Notes'><?php echo $jobData['job_notes']; ?></textarea>
                </div>

                <div class="small-12 columns">
                    <label for="job_description">Job Description</label>
                    <textarea style='height:160px;' name="job_description" placeholder="Job Description"><?php echo $jobData['job_description']; ?></textarea>

                    <label for="work_done">Work Carried Out</label>
                    <textarea style='height:160px;' name="work_done" placeholder="Work Carried Out"><?php echo $jobData['work_done']; ?></textarea>
                </div>

                <div class="large-8 medium-8 small-12 columns">
                    <label for="parts_used">Parts Used</label>
                    <textarea style='height:160px; max-width:100%;' name="parts_used" id="parts_used" placeholder="Parts Used" ><?php echo $jobData['parts_used']; ?></textarea>
                </div>

                <div class="large-4 medium-4 small-12 columns">
                    <label for="job_price">Price</label>
                    <textarea style='height:160px;' name="job_price" id="job_price" placeholder="Price - inc VAT"><?php echo $jobData['job_price']; ?></textarea>
                </div>

                <div class="small-10 medium-11 columns" style="margin-bottom: 25px;">
                    <label>Urgency</label>
                    <div class="range-slider" data-slider data-options="display_selector: #urgencyOutput; start: 1; end: 10; initial:<?php  echo $jobData['urgency']; ?>;">
                        <span class="range-slider-handle" role="slider"></span>
                        <span class="range-slider-active-segment"></span>
                        <input type="hidden" name="urgency" id="urgency">
                    </div>
                </div>
                <div class="small-2 medium-1 columns">
                    <span id="urgencyOutput"></span>
                </div>

                <div class="small-4 columns text-center">
                    <h6>Charger</h6>
                    <div class="switch large">
                        <input id="chargerSwitch" name="charger" type="checkbox" <?php if($jobData['charger'] == 'yes') echo "checked"?>>
                        <label for="chargerSwitch"></label>
                    </div>
                </div>
                <div class="small-4 columns text-center">
                    <h6>Bag</h6>
                    <div class="switch large">
                        <input id="bagSwitch" name="bag" type="checkbox" <?php if($jobData['bag'] == 'yes') echo "checked"?>>
                        <label for="bagSwitch"></label>
                    </div>
                </div>
                <div class="small-4 columns text-center">
                    <h6>Storage</h6>
                    <div class="switch large">
                        <input id="storageMedia" name="storage" type="checkbox" <?php if($jobData['storage'] == 'yes') echo "checked"?>>
                        <label for="storageMedia"></label>
                    </div>
                </div>

                <input type="hidden" name="job_number" value="<?php echo $jobData['job_number'];?>">

                <div class="small-4 columns text-center">
                    <h6>Not Started</h6>
                    <div class="switch large">
                        <input type="radio" name="progress" value="0" id="notStarted" <?php if($jobData['progress'] == '0') echo "checked"?>>
                        <label for="notStarted">Not Started</label>
                    </div>
                </div>
                <div class="small-4 columns text-center">
                    <h6>In Progress</h6>
                    <div class="switch large">
                        <input type="radio" name="progress" value="1" id="inProgress" <?php if($jobData['progress'] == '1') echo "checked"?>>
                        <label for="inProgress">In Progress</label>
                    </div>
                </div>
                <div class="small-4 columns text-center">
                    <h6>Completed</h6>
                    <div class="switch large">
                        <input type="radio" name="progress" value="2" id="completed" <?php if($jobData['progress'] == '2') echo "checked"?>>
                        <label for="completed">Completed</label>
                    </div>
                </div>

                <div class="small-12 columns text-center">
                    <ul class="button-group even-4 round hide-for-print" style="margin-top: 25px;">
                        <li><a href="/home/jobs/?id=<?php echo $previd; ?>" class="button small"><i class="hide-for-small-only fa fa-angle-left"></i> Back</a></li>
                        <li><input type="submit" class="button small fa-input saveButton" value="&#61639; Save" /></li>
                        <li><a class="button small" href="<?php echo $url ?>"><i class="hide-for-small-only fa fa-print"></i> Print</a></li>
                        <li><a href="/home/jobs/?id=<?php echo $nextid; ?>" class="button small">Next <i class="hide-for-small-only fa fa-angle-right"></i></a></li>
                    </ul>
                </div>

            </form>
        </div>
    </div>
    <?php require_once $_PATH.'/includes/footer.php'; ?>
</body>
</html>