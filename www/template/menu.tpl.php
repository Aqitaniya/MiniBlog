<menu>
    <div><a class="button" href="index.php?page=main">Главная</a></div>
    <div><a class="button" href="index.php?page=contacts">Контакты</a></div>
	<? if (!empty($_SESSION['login']) and !empty($_SESSION['password'])): ?>
    <div><a class="button" href="index.php?page=personal_cabinet">Личный кабинет</a></div>
	<? endif ?>
    <div><a class="button" href="index.php?page=login_logout">Войти/Выйти</a></div>
</menu>