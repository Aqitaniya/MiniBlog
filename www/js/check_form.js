function validate_form(name)
{			
		var col_err=0;
		if(name=='registration')
		{
			col_err=check_name()
						+check_surename()
						+check_login()
						+check_password()
						+check_email()
						+check_birth_date()
						+check_phone()
						+check_captcha();
		}
		if(name=='update_user_info')
		{
			col_err=check_name()
						+check_surename()
						+check_login()
						+check_email()
						+check_birth_date()
						+check_phone();
		}
		if(name=='update_password')
		{
			col_err=check_password()
						+check_last_password();
		}
		
		if(col_err==0)
			return true;
		else
			return false;
}
function check_name()
{	var col_err=0;
	var check_name = document.getElementsByName('user_name');
	if(check_name.item(0).value=="")
	{
		document.getElementById('name_error').innerHTML ="Нужно заполнить это поле";
		col_err=col_err+1;
	}
	else
	{
		var reg=/^[A-zА-я\']+$/;
		if(reg.test(check_name.item(0).value)==false)
		{
			document.getElementById('name_error').innerHTML ="Поле может содержать только буквы и ' .";
			col_err=col_err+1;
		}
		else
			document.getElementById('name_error').innerHTML ="";
	}
	return col_err;
}
function check_surename()
{
	var col_err=0;
	var check_surename = document.getElementsByName('user_surename');
	if(check_surename.item(0).value=="")
	{
		document.getElementById('surename_error').innerHTML ="Нужно заполнить это поле";
		col_err=col_err+1;
	}
	else
	{
		var reg=/^[A-zА-я\']+$/;
		if(reg.test(check_surename.item(0).value)==false)
		{
			document.getElementById('surename_error').innerHTML ="Поле может содержать только буквы и ' .";
			col_err=col_err+1;
		}
		else
			document.getElementById('surename_error').innerHTML ="";
	}
	return col_err;
}
function check_login()
{
	var col_err=0;
	var check_login = document.getElementsByName('user_login');
	if(check_login.item(0).value=="")
	{
		document.getElementById('login_error').innerHTML ="Нужно заполнить это поле";
		col_err=col_err+1;
	}
	else
	{
		var reg=/^[A-zА-я0-9\-\_]+$/;
		if(reg.test(check_login.item(0).value)==false)
		{
			document.getElementById('login_error').innerHTML ="Поле может содержать только: буквы, цифры, - , _.";
			col_err=col_err+1;
		}
		else
		document.getElementById('login_error').innerHTML ="";
	}
	return col_err;
}
function check_password()
{
	var col_err=0;
	var check_password = document.getElementsByName('user_password');
	if(check_password.item(0).value=="")
	{
		document.getElementById('password_error').innerHTML ="Нужно заполнить это поле";
		col_err=col_err+1;
	}
	else
	{
		var len=check_password.item(0).value.length;
		if(len<6 || len>16)
		{
			document.getElementById('password_error').innerHTML ="Неверная длина пароля. Допустимо от 6 до 16 символов";
			col_err=col_err+1;
		}
		else
			document.getElementById('password_error').innerHTML ="";
		
		var check_r_password = document.getElementsByName('user_r_password');
		if(check_r_password.item(0).value==""){
			document.getElementById('r_password_error').innerHTML ="Нужно заполнить это поле";
			col_err=col_err+1;
		}
		else
		{
			if(check_password.item(0).value!=check_r_password.item(0).value)
			{
				document.getElementById('r_password_error').innerHTML ="Пароли не совпадают";
				col_err=col_err+1;
			}
			else
				document.getElementById('r_password_error').innerHTML ="";
		}
		
	}
		return col_err;
}
function check_last_password()
{
	var col_err=0;
	var check_password = document.getElementsByName('user_last_password');
	if(check_password.item(0).value=="")
	{
		document.getElementById('last_password_error').innerHTML ="Нужно заполнить это поле";
		col_err=col_err+1;
	}
	return col_err;
}
function check_email()
{
	var col_err=0;
	var check_email = document.getElementsByName('user_email');	
	if(check_email.item(0).value=="")
	{
		document.getElementById('email_error').innerHTML ="Нужно заполнить это поле";
		col_err=col_err+1;	
	}
	else
	{
		var reg=/^[\w\.\d-_]+@[\w^\.\d-_]+\.\w{2,4}$/i;
		if(reg.test(check_email.item(0).value)==false)
		{
			document.getElementById('email_error').innerHTML ="Почтовы адресс введен некорректрно.";
			col_err=col_err+1;
		}
		else
		{
			document.getElementById('email_error').innerHTML ="";
		}
	}	
	return col_err;
}
function check_birth_date()
{
	var col_err=0;
	var check_birth_date = document.getElementsByName('user_birth_date');
	if(check_birth_date.item(0).value=="")
	{
		document.getElementById('birth_date_error').innerHTML ="Нужно заполнить это поле";
		col_err=col_err+1;
	}
	else
	{
		document.getElementById('birth_date_error').innerHTML ="";
	}
	return col_err;
}
function check_phone()
{
	var col_err=0;
	var check_phone = document.getElementsByName('user_phone');
	if(check_phone.item(0).value=="")
	{
		document.getElementById('phone_error').innerHTML ="Нужно заполнить это поле";
		col_err=col_err+1;
	}
	else
	{
		document.getElementById('phone_error').innerHTML ="";
	}
	return col_err;
}
function check_captcha()
{
	var col_err=0;
	var check_captcha = document.getElementsByName('captcha');    
	if(check_captcha.item(0).value=="")
	{
		document.getElementById('captcha_error').innerHTML ="Нужно заполнить это поле";
		col_err=col_err+1;
	}
	else
	{
		document.getElementById('captcha_error').innerHTML ="";
	}
	return col_err;
}