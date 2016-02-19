<?php
	function mysql_qiery_to_bd($query)
	{
		$db=mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
		if(!$db)
		{
            exit(mysql_error());
        }
		if(!mysql_select_db(DB_NAME,$db))
		{
            exit(mysql_error());
        }
        mysql_query("SET NAMES 'UTF8'");
		
		$rez_query=mysql_query($query);
		
		mysql_close($db);
		return $rez_query;
	}

    function render($path,$param=array())
	{
        extract($param);
        ob_start();
	
        if(!include($path.".php"))
		{
            exit("No this template");
        }

        return ob_get_clean();
    }
	
    function encrypt($password)
    {
        return md5(base64_encode($password) .'xCxKs7L');
    }
	
	function txt($input_text)
	{
		$input_text = strip_tags($input_text);
		$input_text = trim($input_text);
		$input_text = htmlspecialchars($input_text);
		$input_text = mysql_escape_string($input_text);
		return $input_text;
	}
	
	function send_mail($user_email, $user_name, $user_surename, $user_login)
	{
		$subject = 'Регистрация на сайте test1.ru';

		$message = '
		<html>
		<head>
		  <title>Регистрация</title>
		</head>
		<body>
		 <h1>Здравствуйте! Спасибо за регистрацию на test1.ru</h1>
		 <b>Ваш логин:'.$user_login.'</b>
		</body>
		</html>
		';

		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

		// Дополнительные заголовки
		$headers .= 'To:'. $user_name.' '.$user_surename . '<anastasiia.rashavchenko@gmail.com>'."\r\n";
		$headers .= 'From: Анастасия Рашавченко <anastasiia.rashavchenko@gmail.com>' . "\r\n";
		//$headers .= 'Cc: birthdayarchive@example.com' . "\r\n";
		//$headers .= 'Bcc: birthdaycheck@example.com' . "\r\n";
		$a=mail($user_email, $subject, $message, $headers);
	}
	
	function check_name($user_name)
	{
		$col_err=0;
		if (empty($user_name))
		{
			$name_error= 'Не введено имя';
			$col_err=$col_err+1;
		}
		elseif (!empty($user_name) && !preg_match("#^([A-zА-я\'])+$#ui", $user_name)) 
		{
			 $name_error = 'Запрещенные символы в имени. Разрешены символы A-zА-я,\'';
			 $col_err=$col_err+1;
		}
		else
		{
			 $name_error='';
		}
		return array ($col_err, $name_error);
	}
	
	function check_surename($user_surename)
	{
		$col_err=0;
		if (empty($user_surename))
		{
			$surename_error= 'Не введена фамилия';
			$col_err=$col_err+1;
		}
		elseif (!empty($user_surename) && !preg_match("#^([A-zА-я\'])+$#ui", $user_surename)) 
		{
			 $surename_error = 'Запрещенные символы в имени. Разрешены символы A-zА-я,\'';
			 $col_err=$col_err+1;
		}
		else
		{
			$surename_error='';
		}
		return array ($col_err, $surename_error);
	}
	
	function check_login($user_login,$user_id)
	{
		$col_err=0;
		if (empty($user_login)) 
		{
			$login_error= 'Не введен логин';
			$col_err=$col_err+1;
		}
		 elseif (!empty($user_login) && !preg_match("#^([A-zА-я0-9\-\_])+$#ui", $user_login)) 
		{
			 $login_error = 'Запрещенные символы в логине. Разрешены символы A-zА-я0-9-_.';
			 $col_err=$col_err+1;
		}
		elseif (empty($user_id) AND mysql_num_rows(mysql_qiery_to_bd("SELECT * FROM test_registration WHERE `user_login` = '$user_login'")) != 0)
		{
			$login_error = 'Логин ' . $user_login . ' занят. Выберите другой';  
			$Massage="Пожалуйста повторите попытку зарегистрироваться с другим логином";
			$col_err=$col_err+1;
		}
		elseif (!empty($user_id) AND mysql_num_rows(mysql_qiery_to_bd("SELECT * FROM test_registration WHERE `user_id`!='$user_id' and `user_login` = '$user_login'")) != 0)
		{
			$login_error = 'Логин  ' . $user_login . ' занят. Выберите другой';  
			$Massage="Пожалуйста повторите попытку зарегистрироваться с другим логином";
			$col_err=$col_err+1;
		}
		else
		{
			$login_error='';
		}
		return array ($col_err, $login_error);
	}
	
	function check_password($user_password,$user_r_password)
	{
		$col_err=0;
		if (empty($user_password))
		{
			$password_error= 'Не введен пароль';
			$col_err=$col_err+1;
		}
		elseif (!empty($user_password) && (strlen($user_password) < 6 || strlen($user_password) > 16)) 
		{
			$password_error= 'Неверная длина пароля. Допустимо от 6 до 16 символов';
			$col_err=$col_err+1;
		}
		else
		{
			$user_r_password=txt($_POST['user_r_password']);
			$password_error='';
			if (empty($user_password))
			{
				$r_password_error= 'Не введен повторно пароль';
				$col_err=$col_err+1;
			}
			elseif($user_password==$user_r_password)
			{
					$user_password_mail=$user_password;
					$user_password=encrypt($user_password);
					$r_password_error='';
			}
			else
			{	
				$r_password_error='Пароли не совпадают!';
				$col_err=$col_err+1;
			}
		}
		return array ($col_err, $password_error,$r_password_error,$user_password);
	}
	
	function check_last_password($user_last_password,$user_id)
	{
		$col_err=0;
		if (empty($user_last_password))
		{
			$last_password_error= 'Не введен пароль';
			$col_err=$col_err+1;
		}
		else
		{
			$query="SELECT user_password FROM test_registration WHERE `user_id`='$user_id'";
			$last_password_bd=mysql_qiery_to_bd($query);
			$last_password_bd=mysql_fetch_array($last_password_bd);
			$last_password_bd=$last_password_bd['user_password'];
			if($last_password_bd==encrypt($user_last_password))
			{
				$last_password_error= '';
			}
			else
			{
				$last_password_error= 'Вы ввели неверный старый пароль';
				$col_err=$col_err+1;
			}
		}
		return array ($col_err, $last_password_error);
	}
	
	function check_email($user_email)
	{
		$col_err=0;
		if (empty($user_email))
		{	$email_error= 'Не введен почтовый адрес';
			$col_err=$col_err+1;
		}
		elseif (!empty($user_email) && !preg_match("/[0-9a-z-_]+@[0-9a-z-_^\.]+\.[a-z]{2,4}/i", $user_email)) 
		{
			 $email_error = 'Запрещенные символы в почтовом адресе.';
			 $col_err=$col_err+1;
		}
		else
		{
			$email_error='';
		}
		return array ($col_err, $email_error);
	}
	
	function check_birth_date($user_birth_date)
	{
		$col_err=0;
		if (empty($user_birth_date)) 
		{
			$birth_date_error= 'Не введена дата рождения';
			$col_err=$col_err+1;
		}
		elseif (!preg_match("/(\d{4}-\d{2}-\d{2})/", $user_birth_date)) 
		{
			 $birth_date_error = 'Можно вводить только цифры и "-".';
			 $col_err=$col_err+1;
		}
		elseif (strlen($user_birth_date) <>10) 
		{
			$birth_date_error= 'Неверно введена дата рождения';
			$col_err=$col_err+1;
		}
		else
		{
			$birth_date_error='';
		}
		return array ($col_err, $birth_date_error);
	}	
	
	function check_phone($user_phone)
	{
		$col_err=0;
		if (empty($user_phone))
		{	$telephone_error= 'Не введен номер телефона';
			$col_err=$col_err+1;
		}
		elseif (!preg_match("/\((\d{3,5})\)\s+(\d{3}-\d{2}-\d{2})/", $user_phone)) 
		{
			 $telephone_error = 'Можно вводить только цифры, () и -.';
			 $col_err=$col_err+1;
		}
		elseif (strlen($user_phone) <>15) 
		{
			$telephone_error= 'Неверно введен номер телефона';
			$col_err=$col_err+1;
		}
		else
		{
			$telephone_error='';
		}
		return array ($col_err, $telephone_error);
	}
	
	function foto($height,$width,$im,$up_dir){
				
				//    dest - результирующее изображение 
				$w_src = imagesx($im); //вычисление ширины изображения
				$h_src = imagesy($im); //вычисления высоты изображения
				//    создаём пустую квадратную картинку 
				$dest = imagecreatetruecolor($height,$width); 
				
				//    вырезание по x, если фото горизонтальное 
				if ($w_src>$h_src) 
				{
                imagecopyresampled($dest, $im, 0, 0,
								   round((max($w_src,$h_src)-min($w_src,$h_src))/2),
                                   0, $height, $width,    min($w_src,$h_src), min($w_src,$h_src)); 
				}
				
				//    вырезание по y, если фото вертикальное  
				if ($w_src<$h_src) 
					imagecopyresampled($dest, $im, 0, 0, 0, 0, $height, $width,
									   min($w_src,$h_src),    min($w_src,$h_src)); 
				
				//    масщтабирование
				if ($w_src==$h_src)
					imagecopyresampled($dest, $im, 0, 0, 0, 0, $height, $width, $w_src, $w_src); 
				
				$date=time();
				//    сохраняем изображение формата jpg в папку (jpg занимает мало места + уничтожается анимирование gif)
				imagejpeg($dest, $up_dir.$date.".jpg");
				$avatar =    $up_dir.$date.".jpg";
                return $avatar;
	}
?>