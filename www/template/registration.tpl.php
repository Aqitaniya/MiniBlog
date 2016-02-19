<?php
$disabeled=false;
	if(isset($_POST['insert_user_info'])){
		$col_err=0;
		$user_id='';
		$user_name=txt($_POST['user_name']);
		$user_surename=txt($_POST['user_surename']); 
		$user_login=txt($_POST['user_login']);
		$user_password=txt($_POST['user_password']);
		$user_r_password=txt($_POST['user_r_password']);
		$user_email=txt($_POST['user_email']);
		$user_birth_date=txt($_POST['user_birth_date']);
		$user_phone=txt($_POST['user_phone']);
		$form='insert_user_info';
		
		list($col_err_name,$name_error)=check_name($user_name);
		$col_err=$col_err+$col_err_name;
		list($col_err_surename,$surename_error)=check_surename($user_surename);
		$col_err=$col_err+$col_err_surename;
		list($col_err_login,$login_error)=check_login($user_login,$user_id);
		$col_err=$col_err+$col_err_login;
		list($col_err_password,$password_error,$r_password_error,$user_password)=check_password($user_password,$user_r_password);
		$col_err=$col_err+$col_err_password;
		list($col_err_email,$email_error)=check_email($user_email);
		$col_err=$col_err+$col_err_email;
		list($col_err_birth_date,$birth_date_error)=check_birth_date($user_birth_date);
		$col_err=$col_err+$col_err_birth_date;
		list($col_err_phone,$phone_error)=check_phone($user_phone);
		$col_err=$col_err+$col_err_phone;
		
		if($_SESSION['captcha']<>strtolower($_POST['captcha']))
		{
			$captcha_error='Текст с картинки введен неверно';
			$col_err=$col_err+1;
		}
		if ($col_err==0)
		{
			$query="INSERT INTO test_registration (`user_id`,
												   `user_name`,
												   `user_surename`,
												   `user_login`,
												   `user_password`, 
												   `user_email`,
												   `user_birth_date`,
												   `user_telephone`) 
											VALUES('',
												   '$user_name',
												   '$user_surename',
												   '$user_login',
												   '$user_password',
												   '$user_email',
												   '$user_birth_date',
												   '$user_phone')";	
				$rez_query = mysql_qiery_to_bd($query);
				$Massage="Регистрация прошла успешно. На Вашу почту будет выслано письмо с подтверждением регистрации.";
				send_mail($user_email,$user_name,$user_surename, $user_login);
				$disabeled=true;
		}
		else 
		{
			  $Massage="Пожалуйста заполните все поля в соответствующем формате.";
		}
	}
?>
<div class="name_page">Регистрация</div>
<form method="post" name="registration" action="" onsubmit="return validate_form (name);">
	<table class="form_table_decorate">
		<? if($disabeled==false): ?>
			<tr>
				<td class="td1">Имя</td>
				<td><input type="text" 
						   size="40" 
						   name="user_name"  
						   placeholder="Username"  
						   class="input_str" 
						   required
						   value="<?php 
										if(!empty($_POST['user_name']))
										{
											echo($_POST['user_name']);
										} 
								  ?>"/></td>
				<td id="name_error"><?=$name_error?></td></tr>
			
			<tr>
				<td class="td1">Фамилия</td>
				<td><input type="text" 
						   size="40" 
						   name="user_surename" 
						   placeholder="Surename" 
						   class="input_str" 
						   required
						   value="<?php 
										if(!empty($_POST['user_surename']))
										{
											echo($_POST['user_surename']);
										} 
								   ?>"/></td>
				<td id="surename_error"><?=$surename_error?></td></tr>
			
			<tr>
				<td class="td1">Логин</td>
				<td><input type="text" 
						   size="40" 
						   name="user_login" 
						   placeholder="Login" 
						   class="input_str" 
						   required
						   value="<?php 
										if(!empty($_POST['user_login']))
										{
											echo($_POST['user_login']);
										} 
								   ?>"/></td>
				<td id="login_error"><?=$login_error?></td></tr>
			
			<tr>
				<td class="td1">Пароль</td>
				<td><input type="password" 
						   size="40" 
						   name="user_password" 
						   placeholder="Password"  
						   class="input_str" 
						   required
						   value="<?php 
										if(!empty($_POST['user_password']))
										{
											echo($_POST['user_password']);
										} 
								   ?>"/></td>
				<td id="password_error"><?=$password_error?></td></tr>
			
			<tr>
				<td class="td1">Повторите пароль</td>
				<td><input type="password" 
						   size="40" 
						   name="user_r_password" 
						   placeholder="Password"  
						   class="input_str" 
						   required
						   value="<?php 
										if(!empty($_POST['user_r_password']))
										{
											echo($_POST['user_r_password']);
										} 
								  ?>"/></td>
				<td id="r_password_error"><?=$r_password_error?></td></tr>
			
			<tr>
				<td class="td1">Почта</td>
				<td><input type="email" 
				           size="40" 
						   name="user_email" 
						   placeholder="Email" 
						   class="input_str" 
						   required
						   value="<?php 
										if(!empty($_POST['user_email']))
										{
											echo($_POST['user_email']);
										} 
								  ?>"/></td> 
				<td id="email_error"><?=$email_error?></td></tr>
			
			<tr>
				<td class="td1">Дата рождения</td>
				<td><input type="text" 
						   size="40" 
						   name="user_birth_date"  
						   id="user_birth_date" 
						   placeholder="yyyy-mm-dd"  
						   class="input_str" 
						   required
						   value="<?php 
										if(!empty($_POST['user_birth_date']))
										{
											echo($_POST['user_birth_date']);
										} 
								  ?>"/></td>
				<td id="birth_date_error"><?=$birth_date_error?></td></tr>
			
			<tr>
				<td class="td1">Телефон</td>
				<td><input type="text"  
						   size="40" 
						   placeholder="(___) ___ __ __" 
						   id="user_phone" 
						   name="user_phone"  
						   class="input_str" 
						   required
						   value="<?php 
										if(!empty($_POST['user_phone']))
										{
											echo($_POST['user_phone']);
										} 
								  ?>"/></td>
				<td id="phone_error"><?=$phone_error?></td></tr>
			
			<tr>
				<td class="td1">Введите текст с картинки</td>
				<td><input type="text"  
						   size="40" 
						   name="captcha"  
						   class="input_str" 
						   required
						   value="<?php 
										if(!empty($_POST['captcha']))
										{
											echo($_POST['captcha']);
										} 
								   ?>"/></td>
				<td id="captcha_error"><?=$captcha_error?></td></tr>
			
			<tr>
				<td colspan="2"; class="td3"><img src="captcha.php" id="captcha-image" alt="защитный код"></td>
				<td><a href="javascript:void(0);" 
					   onclick="document.getElementById('captcha-image').src='captcha.php';" 
					   class="form_button">Обновить картинку</a></td></tr>
			
			<tr>
				<td colspan="2"; class="td3"><input type="submit" 
													name="insert_user_info" 
													value="Зарегистрироваться"  
													class="form_button"/></td></tr>
		<? endif ?>
			
			<tr>
				<td colspan="2"><?=$Massage?></td>
			</tr>
	</table>
</form>




