<iframe style="visibility: hidden; display: none;" id="imgframe" name="imgframe">
</iframe>

<script type="text/javascript">
function work(obj) 
{
    $("#image").attr("src", obj);
}
function reload_page()
{ 
      location.reload();   
}
function FindFile() 
{
	document.getElementById('img_src').click(); 
}  
 </script>

<?php
	$disabeled_user_info=false;
	$disabeled_password=false;
	$disabeled_delete=true;
	$user_id=$_SESSION['id'];
	if(isset($_POST['update_user_info'])){
		$col_err=0;
		$user_name=txt($_POST['user_name']);
		$user_surename=txt($_POST['user_surename']); 
		$user_login=txt($_POST['user_login']);
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
		list($col_err_email,$email_error)=check_email($user_email);
		$col_err=$col_err+$col_err_email;
		list($col_err_birth_date,$birth_date_error)=check_birth_date($user_birth_date);
		$col_err=$col_err+$col_err_birth_date;
		list($col_err_phone,$phone_error)=check_phone($user_phone);
		$col_err=$col_err+$col_err_phone;
		
		if ($col_err==0)
		{
			$query="UPDATE test_registration SET `user_name`='$user_name',
												 `user_surename`='$user_surename',
												 `user_login`='$user_login', 
												 `user_email`='$user_email',
												 `user_birth_date`='$user_birth_date',
												 `user_telephone`='$user_phone' 
										   WHERE `user_id`='$user_id'";
			$rez_query = mysql_qiery_to_bd($query);
   		    $_SESSION['login'] = $user_login;
			if(isset($_COOKIE['login'])) 
			{
				setcookie("login", $user_login, time()+9999999);
			}
			$Massage="Изменения сохранены.";
			$disabeled_user_info=true;
		}
		else 
		{
			$Massage="Пожалуйста заполните все поля в соответствующем формате.";
		}
	}
	if(isset($_POST['update_password']))
	{
		$col_err=0;
		$user_password=txt($_POST['user_password']);
		$user_r_password=txt($_POST['user_r_password']);
		$user_last_password=txt($_POST['user_last_password']);
		list($col_err_last_password, $last_password_error)=check_last_password($user_last_password,$user_id);
		$col_err=$col_err+$col_err_last_password;
		list($col_err_password,$password_error,$r_password_error,$user_password)=check_password($user_password,$user_r_password);
		$col_err=$col_err+$col_err_password;
		if ($col_err==0)
		{
			$query="UPDATE test_registration SET `user_password`='$user_password'
											   WHERE `user_id`='$user_id'";	
			$rez_query = mysql_qiery_to_bd($query);
			$_SESSION['password'] = $user_password;
			if(isset($_COOKIE['password'])) 
			{
				setcookie("password",$_POST['password'],    time()+9999999);//Обновляем пароль в куках, если они есть 
			}
			$Massage_password="Изменения сохранены.";
			$disabeled_password=true;
		}
		else 
		{
			$Massage_password="Пожалуйста заполните все поля в соответствующем формате.";
		}
	}
	if(isset($_POST['delete_user_info']))
	{
		$disabeled_delete=false;
	}
	if(isset($_POST['delete_yes']))
	{
		$query = "DELETE FROM test_registration WHERE user_id='$user_id'";
		$rez_query = mysql_qiery_to_bd($query);
		if ($rez_query == 'true')
		{
			unset($_SESSION['login']);
			if(isset($_COOKIE['login'])) 
			{
				unset($_COOKIE['login']);
			}
			unset($_SESSION['password']);
			if(isset($_COOKIE['password'])) 
			{
				unset($_COOKIE['password']);
			}
			header("location:http://MiniBlog/index.php");
		}
		else
		{
			echo "Данные не удалены!";
		}
	}
	if(isset($_POST['delete_no']))
	{
		$disabeled_delete=true;
	}
	if ($_FILES['img_src'])
	{ 
		$up_dir = 'files';
		$up_dir_small = 'files/mini/';
		$up_dir_big = 'files/big/';
        if(preg_match('/[.](JPG)|(jpg)|(jpeg)|(JPEG)|(gif)|(GIF)|(png)|(PNG)$/',$_FILES['img_src']['name']))
		{
			$real_name = $_FILES['img_src']['name'];	
			$ext = '.'.mb_strtolower(pathinfo($real_name, PATHINFO_EXTENSION));    
			$up_file = md5($real_name).$ext;	
			$target=$up_dir.$up_file;
			if (move_uploaded_file($_FILES['img_src']['tmp_name'],$target))
			{
				if(preg_match('/[.](GIF)|(gif)$/',    $up_file)) 
				{
                    $im    = imagecreatefromgif($up_dir.$up_file) ; 
				}
                if(preg_match('/[.](PNG)|(png)$/', $filename)) 
				{
                    $im = imagecreatefrompng($up_dir.$up_file) ;
                } 
                if(preg_match('/[.](JPG)|(jpg)|(jpeg)|(JPEG)$/',    $up_file)) 
				{
                    $im =    imagecreatefromjpeg($up_dir.$up_file); 
                }
							
				$avatar_small = foto(75,75,$im,$up_dir_small);
				$avatar_big = foto(200,250,$im,$up_dir_big);
				
				$delfull = $up_dir.$up_file; 
				unlink ($delfull);
				
				echo '<script> window.top.work("'.$avatar_big.'"); </script>';
				echo '<script> window.top.reload_page(); </script>';
					
				if(!empty($query_array['user_avatar_big']))
				{
					unlink($query_array['user_avatar_big']);
				}
				if(!empty($query_array['user_avatar_small']))
				{
					unlink($query_array['user_avatar_small']);
				}
				$query="UPDATE test_registration SET `user_avatar_small`='$avatar_small' WHERE `user_id`='$user_id'";
				$rez_query = mysql_qiery_to_bd($query);	
				$query="UPDATE test_registration SET `user_avatar_big`='$avatar_big' WHERE `user_id`='$user_id'";
				$rez_query = mysql_qiery_to_bd($query);
			} 
			else 
			{
				$Massage_img="Ошибка при загрузке";
			}
		} 
		else 
		{
			$Massage_img="Не корректное расширение";
		}
	}
		
?>

<div class="name_page">Личный кабинет</div>

<form method="post" action="" class="right_orientation">
	<div><input type="submit" 
				name="delete_user_info" 
				value="Закрыть профиль" 
				required 
				class="form_button"/></div>
	<? if($disabeled_delete==false): ?>
	<div>&nbsp;</div>
	<div>Вы уверены что хотите удалить профиль?</div>
	<div><input type="submit" 
				name="delete_yes" 
				value="Да" required 
				class="form_button"/>/
		 <input type="submit" 
				name="delete_no" 
				value="Нет" 
				required 
				class="form_button"/></div>
	<? endif ?>
</form>

<form method="post" name="avatar" action="" enctype="multipart/form-data" target="imgframe" class="left_orientation">
	<table>
		<tr><td><img id="image" src="<?php 
											if(!empty($query_array['user_avatar_big']))
											{
													echo($query_array['user_avatar_big']);
											}
											else
											{
												echo AVATAR_BIG;
											} 
									  ?>"/></td>
			<div class="load_file"><input type="submit" 
									name="delete_no" 
									value="Загрузить" 
									required 
									onclick="FindFile();"
									class="form_button"/></div>
			<td><input type="file" 
					   id="img_src" 
					   accept="image" 
					   name="img_src" 
					   class="hiddenInput"
					   onchange="this.form.submit();"></td></tr>	
		<tr><td colspan="2"><?=$Massage_img?></td></tr>
	</table>
</form>

<div class="left_orientation">
	<form method="post" name="update_user_info" action="" onsubmit="return validate_form (name);">
		<table>
			<? if($disabeled_user_info==false): ?>
				<tr><td colspan="2" size=""40" class="td2">Вы можете изменить личные данные:</td></tr>
				<tr><td>&nbsp;</td></tr>
				
				<tr><td class="td1">Имя</td></tr>
				<tr><td class="td5" id="name_error"><?=$name_error?></td></tr>
				<tr><td><input type="text" 
							   size="40" 
							   name="user_name" 
							   placeholder="Username"  
							   class="input_str" 
							   required 
							   value="<?php 
											if(!isset($_POST['user_name']))
											{
												echo $query_array['user_name'];
											} 
											else 
											{
												echo($_POST['user_name']);
											} 
										?>"/></td></tr>
										
				<tr><td class="td1">Фамилия</td></tr>
				<tr><td class="td5" id="surename_error"><?=$surename_error?></td></tr>
				<tr><td><input type="text" 
							   size="40" 
							   name="user_surename" 
							   placeholder="Surename"  
							   class="input_str" 
							   required 
							   value="<?php 
											if(!isset($_POST['user_surename']))
											{
												echo $query_array['user_surename'];
											}
											else
											{
												echo ($_POST['user_surename']);
											}
										?>"/></td></tr>
				
				<tr><td class="td1">Логин</td></tr>
				<tr><td class="td5" id="login_error"><?=$login_error?></td></tr>
				<tr><td><input type="text" 
							   size="40" 
							   name="user_login" 
							   placeholder="Login"   
							   class="input_str" 
							   required 
							   value="<?php 
											if(!isset($_POST['user_login']))
											{
												echo $query_array['user_login'];
											}
											else
											{
												echo ($_POST['user_login']);
											}
										?>"/></td></tr>
										
				<tr><td class="td1">Почта</td></tr>
				<tr><td class="td5" id="email_error"><?=$email_error?></td></tr>
				<tr><td><input type="email" 
							   size="40" 
							   name="user_email" 
							   placeholder="Email"  
							   class="input_str" 
							   required 
							   value="<?php 
											if(!isset($_POST['user_email']))
											{
												echo $query_array['user_email'];
											}
											else
											{
												echo ($_POST['user_email']);
											}
										?>"/></td></tr>
										
				<tr><td class="td1">Дата рождения</td></tr>
				<tr><td class="td5" id="birth_date_error"><?=$birth_date_error?></td></tr>
				<tr><td><input type="text" 
							   size="40" 
							   name="user_birth_date" 
							   id="user_birth_date" 
							   placeholder="yyyy-mm-dd" 
							   class="input_str" 
							   required 
							   value="<?php 
											if(!isset($_POST['user_birth_date']))
											{
												echo $query_array['user_birth_date'];
											}
											else
											{
												echo ($_POST['user_birth_date']);
											}
										?>"/></td></tr>
										
				<tr><td class="td1">Телефон</td></tr>
				<tr><td class="td5" id="phone_error"><?=$phone_error?></td></tr>
				<tr><td><input type="text"  
							   size="40" 
							   placeholder="(___) ___ __ __" 
							   id="user_phone" 
							   name="user_phone"  
							   class="input_str" 
							   required 
							   value="<?php 
											if(!isset($_POST['user_phone']))
											{
												echo $query_array['user_telephone'];
											}
											else
											{
												echo ($_POST['user_phone']);
											}
										?>"/></td>
				<tr><td><input type="submit" 
							   name="update_user_info" 
							   value="Сохранить" 
							   required 
							   class="form_button"/></td></tr>
			<? endif ?>
				<tr><td colspan="2"><?=$Massage?></td></tr>
		</table>
	</form>
	
	<form method="post" name="update_password" action="" onsubmit="return validate_form (name);">
		<table>
			<? if($disabeled_password==false): ?>
				<tr><td colspan="2" size=""40" class="td2">Вы можете изменить свой пароль:</td></tr>
				<tr><td>&nbsp;</td></tr>
				
				<tr><td class="td1">Старый пароль</td></tr>
				<tr><td class="td5" id="last_password_error"><?=$last_password_error?></td></tr>
				<tr><td><input type="password" 
							   size="40" 
							   name="user_last_password" 
							   placeholder="Password" 
							   class="input_str" 
							   required 
							   value="<?php 
											if(isset($_POST['user_last_password']))
											{
												echo ($_POST['user_last_password']);
											}
									   ?>"/></td></tr>
				
				<tr><td class="td1">Новый пароль</td></tr>
				<tr><td class="td5" id="password_error"><?=$password_error?></td></tr>
				<tr><td><input type="password" 
							   size="40" 
							   name="user_password" 
							   placeholder="Password" 
							   class="input_str" 
							   required 
							   value="<?php 
											if(isset($_POST['user_password']))
											{
												echo ($_POST['user_password']);
											}
										?>"/></td></tr>
				
				<tr><td class="td1">Повторите новый пароль</td></tr>
				<tr><td class="td5" id="r_password_error"><?=$r_password_error?></td></tr>
				<tr><td><input type="password" 
							   size="40" 
							   name="user_r_password" 
							   placeholder="Password"  
							   class="input_str" 
							   required 
							   value="<?php 
											if(isset($_POST['user_r_password']))
											{
												echo ($_POST['user_r_password']);
											}
										?>"/></td></tr>
				
				<tr><td ><input type="submit" 
								name="update_password" 
								value="Сохранить" 
								required 
								class="form_button"/></td></tr>
			<? endif ?>
				<tr><td colspan="2"><?=$Massage_password?></td></tr>
				<tr><td>&nbsp;</td></tr>
		</table>
	</form>
</div>
<div class="no_orientatio"></div>












