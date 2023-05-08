<?php
session_start();

function dd($value)
{
    var_dump($value);
    return die();
}

$predefined_mnames_jolobazo = array_map('trim', file('main.txt'));

$days_of_week = array("شنبه", "يکشنبه", "دوشنبه", "سه شنبه", "چهارشنبه", "پنجشنبه");

if (!isset($_SESSION['data'])) {
    $_SESSION['data'] = array();
}

if (isset($_POST['submit']) && isset($_POST['mnames']) && isset($_POST['repetition']) && isset($_POST['set'])
    && !empty($_POST['mnames'] && !empty($_POST['repetition']) && !empty($_POST['set']))) {
    $post = $_POST;
    $selected_mnames = $_POST['mnames'];
    $repetitions = $_POST['repetition'];
    $sets = $_POST['set'];
    $selected_day = $_POST['day'];
    $repetitions = array_values(array_filter($repetitions));
    $sets = array_values(array_filter($sets));
    $repetitions = array_values(array_filter($repetitions));
    foreach ($selected_mnames as $key => $mname) {
        $day = $selected_day;
        if (!isset($_SESSION['data'][$day])) {
            $_SESSION['data'][$day] = array();
        }


        $_SESSION['data'][$day][] = array(
            'mname' => $mname,
            'text11' => $repetitions[$key],
            'text12' => $sets[$key]
        );
    }
}
if (isset($_POST['clear'])) {
    $_SESSION['data'] = array();
    unset($_SESSION['name']);

}
?>
<!DOCTYPE html>
<html dir="rtl">
<head>
	<meta content="width=device-width, initial-scale=0.5, maximum-scale=0.5, user-scalable=0.5" name="viewport">
	<link href="https://www.w3schools.com/w3css/4/w3.css" rel="stylesheet">
	<link href="style.css" rel="stylesheet">
	<title>DNA gym Planner</title>
	<style>
	</style>
</head>
<body>
	<header class="main">
		<nav class="hco navbar navbar-expand-lg bg-body-tertiary">
			<div class="htitle container-fluid">
				<a class="navbar-brand" href="#">باشگاه پروش اندام DNA</a> <a class="navbar-brand" href="#">علي قادري</a> <a class="navbar-brand" dir="ltr" href="#">@aligaderi71</a> <!-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button> -->
				<div class="collapse navbar-collapse nonrprint" id="navbarSupportedContent">
					<div class="navbar-nav me-auto mb-2 mb-lg-0" style="margin-left: 2em">
						<form method="post">
							<input class="btn-donate nonprint" name="clear" type="submit" value="حذف اين برنامه و ساخت برنامه جديد">
						</form><button class="btn-donate nonprint" onclick="window.print()">چاپ برنامه</button>
					</div>
				</div>
			</div>
		</nav>
	</header>
	<div class="main">
		<div class="shakh main p20pad tbco2">
			<div class="form-group">
				<div class="ctitle row align-items-start">
					<h4 class="nonrprint">اطلاعات شخصي</h4><?php


					if (isset($_POST['submitname'])) {
					    // ذخيره نام و نام خانوادگي در Session
					    $_SESSION['name'] = $_POST['name'];
					    $_SESSION['age'] = $_POST['age'];
					    $_SESSION['gender'] = $_POST['gender'];
					$_SESSION['asib'] = $_POST['asib'];

					}

					// بررسي وجود نام و نام خانوادگي در Session
					if (isset($_SESSION['name']) && ($_SESSION['age']) && ($_SESSION['gender'])) {
					    // نمايش نام و نام خانوادگي
					    echo 'نام و نام خانوادگي: ' . $_SESSION['name']. '<br>';
					    echo 'سن: ' . $_SESSION['age']. '<br>';
					echo 'نقطه ضعف: ' . $_SESSION['gender']. '<br>';
					echo 'نقطه ضعف: ' . $_SESSION['asib']. '<br>';
					}else {
					    // نمايش فرم براي ورود نام و نام خانوادگي
					    echo '<div class="large-font p-1 badge text-bg-light border border-dark-subtle grid" style="margin:1px;background-color:#fff!important;width:85%;">';
					    echo '<form method="POST">';
					    echo 'نام و نام خانوادگي: <input type="text" name="name"> ';
					    echo 'سن: <input type="text" name="age">';
					    echo '<br>';
					echo 'نقطه ضعف: <input type="text" name="gender"> ';
					echo 'آسيب: <input type="text" name="asib"> ';
					    echo '<input class="" type="submit" name="submitname" value="ذخيره">';
					    echo '</form>';
					    echo '</div>';
					}

					?>
				</div>
			</div>
		</div>
		<div class="row align-items-start">
			<h2 class="nonrprint">حرکات</h2>
			<div class="hide main nonrprint" style="">
				<div class="p20pad tbco2 nonprint">
					<div class="harekat form-group">
						<form method="post">
							<?php
							                foreach ($predefined_mnames_jolobazo as $mname) {
							                    ?>
							<div class='nonprint table large-font p-1 badge text-bg-light border border-dark-subtle grid' style='margin-bottom:20px;background-color:#fff!important;border:solid 1px #000'>
								<div style="width:100%">
									<input class='input2 xform' name='mnames[]' type='checkbox' value=' &lt;?= $mname ?&gt; '> <?= $mname ?>
								</div><input class='input3 xform' name='repetition[]' placeholder='تکرار'> <input class='input3 xform' name='set[]' placeholder='ست'>
							</div><?php
							                }
							                ?><select class='nonprint' name='day' style='color:red!important; margin-right: 10px'>
								<?php
								                    foreach ($days_of_week as $day) {
								                        ?>
								<option class="" value='&lt;?= $day ?&gt;'>
									<?= $day ?>
								</option><?php } ?>
							</select> <input class="nonprint" name="submit" type="submit" value="افزودن">
						</form>
					</div>
				</div>
			</div>
			<div class="main">
				<h4 class="hide-p nonrprint">پيش نمايش</h4><?php
				    foreach ($days_of_week as $day) {
				        echo "<div class='ctitle p-5 badge text-bg-light border border-dark-subtle grid' style='margin:7px;background-color:transparent!important;'>";
				        echo "<strong>$day</strong><br>";
				        echo "<div class='large-font text-bg-light grid' style='margin:5px;'>";
				        if (isset($_SESSION['data'][$day])) {
				            foreach ($_SESSION['data'][$day] as $item) {
				                echo "<div class='ctitle'>" . "." . $item['mname'];
				                echo " ";
				                echo $item['text12'] . "x";
				                echo $item['text11'];
				                echo "<br>";
				                echo "</div>";
				            }
				        }
				        echo "</div><br>";
				        echo "</div>";
				    }
				    ?>
			</div>
		</div>
	</div>
	<footer class="nonprint">
		<div class="row nonrprint" style=" color:#fff!important">
			<a class="col-2" href="#zir">زیربغل</a> <a class="col-2" href="#posht">پشت بازو</a> <a class="col-2" href="#jolo">جلوبازو</a> <a class="col-2" href="#sine">سینه</a> <a class="col-2" href="#sar">سرشانه</a> <a class="col-2" href="#pa">پا</a>
		</div>
	</footer>
</body>
</html>
