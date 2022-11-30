<?
	if ($_POST['authorization_f']){
		if ($_POST['email'] != "" and $_POST['password'] != "") //если поля заполнены    
		{       
	    $email = $_POST['email']; 
	    $password = $_POST['password'];

	    $user = $CONNECT->query("SELECT * FROM user WHERE email = '$email'"); //запрашивается строка из базы данных с логином, введённым пользователем      
	    if (mysqli_num_rows($user) == 1) //если нашлась одна строка, значит такой юзер существует в базе данных       
	    {           
        $row_user = $user->fetch_assoc();             
        if ($row_user['password'] == $password) //сравнивается хэшированный пароль из базы данных с хэшированными паролем, введённым пользователем                        
        { 
	        //пишуться логин и хэшированный пароль в cookie, также создаётся переменная сессии
	        setcookie ("email", $row_user['email'], time() + 50000);  // записываем куки                       
	        setcookie ("password", /*md5*/($row_user['email'].$row_user['password']), time() + 50000);// записываем куки
	        $_SESSION['id'] = $row['id'];   //записываем в сессию id пользователя               

	        /*$id = $_SESSION['id']; */   
	        $_SESSION['id'] = 1;         
	        //go('admin/mainpage'); // редирект на главную админа          
	        exit('{"go": "admin/mainpage"}');          
		    }           
		    else //если пароли не совпали           
		    {                                                      
	        exit('{"text_error": "Неверный пароль"}');         
		    }       
			}       
	    else //если такого пользователя не найдено в базе данных        	    	
	    {                     
        exit('{"text_error": "Пользователь не найден"}');     
	    }   
		}   
	  else    
	  {                  
	    exit('{"text_error": "Поля не должны быть пустыми!"}');  
	  } 
	}

	

	elseif ($_POST['logout_f']){
		 $_SESSION['id'] = 0;
		 exit('{"go": "admin"}');
	}

	/*elseif ($_POST['category.edit_f']){
		exit('{"go": "admin"}');
	}*/
	
?>