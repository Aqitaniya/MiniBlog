<?php
	header("Content-Type:text/html;charset=UTF-8");

	session_start();
	require_once "config.php";
	require_once "functions.php";

	if (isset($_COOKIE['auto']) and isset($_COOKIE['login']) and isset($_COOKIE['password']))
    {
		if ($_COOKIE['auto'] == 'yes') 
		{ 
			$_SESSION['password']=encrypt(txt($_COOKIE['password'])); 
			$_SESSION['login']=$_COOKIE['login'];
			$_SESSION['id']=$_COOKIE['id'];
		}
    } 
	if (!empty($_SESSION['login']) and !empty($_SESSION['password']))
	{
		$login    = $_SESSION['login'];
        $password = $_SESSION['password'];
         
		$query="SELECT * FROM test_registration WHERE user_login='$login' AND user_password='$password'";
		$rez_query = mysql_qiery_to_bd($query);
        $query_array    = mysql_fetch_array($rez_query);
    }

	$page = txt($_GET['page']);

	if(!$page)
	{
		$page="main";
	}
	
	switch ($page)
	{
		case "registration":
			$content = render(TEMPLATE."registration.tpl");
			break;
		case "personal_cabinet":
			$content = render(TEMPLATE."personal_cabinet.tpl",array('query_array'=>$query_array));
			break;
		case "main":
			$content = render(TEMPLATE."main.tpl");
			break;
		case "login_logout":
			$content = render(TEMPLATE."login_logout.tpl");
			break;
		case "contacts":
			$content = render(TEMPLATE."contacts.tpl");
			break;
		default:
			$content = render(TEMPLATE."main.tpl");
			break;	
	}
	require_once TEMPLATE."index.php";
?>