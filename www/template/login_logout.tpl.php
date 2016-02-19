<?php
	if(isset($_POST['login_loguot']))
	{
		$in_login=txt($_POST['in_login']);
		$query="SELECT `user_id`,`user_password` FROM `test_registration` WHERE `user_login` = '$in_login'"; 
		$rez_query = mysql_qiery_to_bd($query);
		$query_array = mysql_fetch_array($rez_query); 
		if(!$query_array)
		{ 
			$in_Massage="Нет зарегистированных пользователей под таким логином!";
		} 
		else if(encrypt(txt($_POST['in_password'])) != $query_array['user_password'])
		{ 
			$in_Massage="Пароль введен неверно!";
		} 
		else 
		{ 
			$_SESSION['password']=$query_array['user_password']; 
            $_SESSION['login']=$_POST['in_login']; 
			$_SESSION['id']=$query_array['user_id'];
			if (isset($_POST['save']))
			{
				//Если    пользователь хочет, чтобы его данные сохранились для последующего входа, то    сохраняем в куках его браузера
				setcookie("login",    $_POST["in_login"], time()+9999999);
				setcookie("password",    $_POST["in_password"], time()+9999999);
				setcookie("id", $query_array['user_id'],    time()+9999999);
			}
			if (isset($_POST['autovhod']))
			{
				//Если    пользователь хочет входить на сайт автоматически
				setcookie("auto", "yes",    time()+9999999);
				setcookie("login",    $_POST["in_login"], time()+9999999);
				setcookie("password",    $_POST["in_password"], time()+9999999);
				setcookie("id",    $query_array['user_id'], time()+9999999);
			} 
			header("location:http://MiniBlog/index.php");
		}
	}
	if(isset($_POST['exit']))
	{
		session_start();
		unset($_SESSION['password']);
        unset($_SESSION['login']); 
        unset($_SESSION['id']);//    уничтожаем переменные в сессиях
		setcookie("auto", "",    time()+9999999);//очищаем автоматический вход
	}
?>
<div class="name_page">Авторизация</div>
<form method="post" action="" >
	<table class="form_table_decorate">
		<? if (empty($_SESSION['login']) and empty($_SESSION['password'])): ?>
				<h2><a class="href_reg" href="index.php?page=registration" >Регистрация</a></h2>
				<tr>
					<td></td><td size="40" class="td2">Автоматический вход на сайт
					<input name="autovhod" 
						   type="checkbox" 
						   value='1'></td></tr>
				<tr>
					<td class="td1">Логин</td>
					<td><input type="text" 
							   size="40" 
							   name="in_login" 
							   placeholder="Login" 
							   pattern="^([A-zА-я0-9\-\_\ ])+$" 
							   class="input_str" 
							   required 
							   value="<?php 
											if(isset($_COOKIE['login']))
											{
												echo($_POST['in_login']=$_COOKIE['login']);
											} 
										?>"></td></tr>
				<tr>
					<td class="td1">Пароль</td>
					<td><input type="password" 
							   size="40" 
							   name="in_password" 
							   placeholder="Password" 
							   class="input_str" 
							   required 
							   value="<?php 
											if(isset($_COOKIE['password']))
											{
												echo($_POST['in_password']=$_COOKIE['password']);
											} 
										?>"/></td></tr>
				<tr><td colspan="2"; class="td4"><input type="submit" 
														name="login_loguot" 
														value="Войти" 
														required 
														class="form_button"/></td></tr>
				<tr><td colspan="2"><?=$in_Massage?></td></tr>
		<? endif ?>	
		<? if (!empty($_SESSION['login']) and !empty($_SESSION['password'])): ?>
				<tr><td colspan="2"; class="td4"><input type="submit" 
														name="exit" 
														value="Выйти" 
														required 
														class="form_button"/></td></tr>
		<? endif ?>	
				<tr><td>&nbsp;</td></tr>
	</table
</form>