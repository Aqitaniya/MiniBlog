<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8" />
    <title><?=SITE_NAME;?></title>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <link rel="stylesheet" type="text/css" href="css/style.css">
	<script language="JavaScript" type="text/javascript" src="js/jquery-2.1.3.js"></script>
	<script type="text/javascript" src="js/jquery.maskedinput.min.js"></script>
	<script type="text/javascript" src="js/script.js"></script>
	<script type="text/javascript" src="js/is.mobile.js"></script>
	<script type="text/javascript" src="js/check_form.js"></script>

</head>

<body>

<div class="wrapper">

    <header>
	<p class="right_orientation">Вы вошли на сайт как <?php 
															if(isset($_SESSION['login']))
															{
																echo($query_array['user_name'].' '.substr($query_array['user_surename'],0,1).'.');
															}
															else
															{ 
																echo "незарегистрированный пользователь.";
															} 
														?>
		<? if(isset($_SESSION['login'])): ?>
			<? if(!empty($query_array['user_avatar_small'])): ?>
				<img id="image_header" alt='$_SESSION["login"]' src='<?=$query_array['user_avatar_small']?>'/>
			<? elseif (empty($query_array['user_avatar_small'])): ?>
				<img id="image_header" alt='$_SESSION["login"]' src="<?=AVATAR_SMALL?>"/>
			<? endif ?>
		<? endif ?>
	</p>
	</header>