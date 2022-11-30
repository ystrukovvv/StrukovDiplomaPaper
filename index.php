<?
if ( $_SERVER['REQUEST_URI'] == '/') $page = 'home';//открываем домашнюю, если в url ничего нет
else{
	$page =  substr($_SERVER['REQUEST_URI'], 1);//убираем / в конце

	//if( !preg_match('/^[A-z0-9]{3,15}$/', $page) ) exit('error url');//валидность url
}
$page1 = explode("/", $page);// разделяем url на массив

//ПОДКЛЮЧАЕМ БД
$db_host='localhost'; // ваш хост
$db_user=''; // пользователь бд
$db_pass=''; // пароль к бд
$db_name=''; // ваша бд
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);// включаем сообщения об ошибках
$CONNECT = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
$CONNECT->set_charset("utf8mb4"); // задаем кодировку
if ($CONNECT == false){
    print("Error MySQL " . mysqli_connect_error());
}



session_start();
// ЕСЛИ СТРАНИЦА СУЩЕСТВУЕТ, то открываем
// если открыта главная страница
if ($page1[0] == 'home') {// ГЛАВНАЯ СТРАНИЦЫ
	if ($page1[1] == ''){
		if ( file_exists('home/home.php') ) include 'home/home.php';
		else exit('404');
	}
}

// если открыт каталог
elseif ( $page1[0] == 'catalog' ) {
	if($page1[1] != ''){
		if ( file_exists('catalog/catalog.php')) include 'catalog/catalog.php';
		else{echo 'error catalog';}
	}

	elseif ($page1[1] == ''){
		if ( file_exists('home/home.php') ) include 'home/home.php';
		else exit('404');
		echo "error print";
	}
	else{
		echo 'error catalog';
	}
}

// если открыта корзина
elseif ( $page1[0] == 'basket' ) {
	if($page1[1] == ''){
		if ( file_exists('catalog/basket.php')) include 'catalog/basket.php';
		else{echo 'error basket';}
	}
	/*elseif ($page1[1] != ''){
		if ( file_exists('catalog/basket.php') ) echo "<script type='text/javascript'>window.location.href ='/basket';</script>";
		else exit('404 err');
	}*/
	else{
		echo 'error basket';
	}
}
elseif ($page1[0] == 'inquiry.ajax' and file_exists('admin/inquiry.ajax.php')) include 'admin/inquiry.ajax.php';
elseif ($page1[0] == 'basket-ajax' and file_exists('catalog/basket-ajax.php')) include 'catalog/basket-ajax.php';

// если админ не авторизован, то открываем авторизацию
elseif ( $page1[0] == 'admin' and file_exists('admin/admin.php')){

	if ( $_SESSION['id'] != 1  and $page1[1] == '') include 'admin/admin.php'; 

	// если админ авторизован, то открываем главную админа
	elseif ( $page1[0] == 'admin' and $_SESSION['id'] == 1){
		if ( $page1[1] == ''){
			echo "<script type='text/javascript'>window.location.href ='/admin/mainpage';</script>";
		}
		elseif($page1[1] != ''){
			$const_url = ':';
			$flag_url = strpos($page[2], $const_url);
			if (file_exists('admin/pages/'.$page1[1].'.php') ){
				if ($flag_url === false or $page[2] == ''){
					include 'admin/pages/'.$page1[1].'.php';
				}			
				else {
					echo 'error admin';
				}	
			} 
			else {
				echo 'error admin';
			}
		}
	}

	else exit('error admin ' and $_SESSION['id']);
}

else ("404 not fold");





//РЕДИРЕКТ ПОСЛЕ АВТОРИЗАЦИИ
/*function go( $url ){
	exit('{"go" : '.$url.'}');
}*/


//ГЕНЕРАТОР ТОКЕНА
/*function random_token( $num=30){
	return substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, $num);
}
?>*/