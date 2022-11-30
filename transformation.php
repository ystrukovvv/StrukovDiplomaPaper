<?
	echo '
		<!DOCTYPE html>
		<html lang="en">
		<head>
			<meta charset="UTF-8">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<title>Администрирование</title>
			<style>
				.btn-add{
					background: #DFDFDF;
					text-align: center;
					height: 40px;
					line-height: 40px;
					width: 200px;
				}
				.btn-add:hover{
					background: #4F4C4C;
					color: #fff;
					cursor: pointer;
				}
				.url-edit{
					font-size: 16px;
					float: right;
				}
				.btn-edit{
					background: #DFDFDF;
					padding: 3px;
					color: black;
				}
				.btn-edit:hover{
					background: #4F4C4C;
					color: #fff;
					cursor: pointer;
				}
				.btn-delete{
					background: #DFDFDF;
					padding: 3px;
					font-size: 16px;
					float: left;
					color: black;
				}
				.btn-delete:hover{
					background: #4F4C4C;
					color: #fff;
					cursor: pointer;
				}
				.div-form-add-edit{
					margin-top: 130px;
					display: flex;
					flex-direction: column;
					width: 100%;
					position: absolute;
					align-items: center;
					font-size: 20px;
				}
				.form-add-edit{
					width: 500px;
					text-align: center;
				}
				.div-img-admin-update{
					width: 500px;
					padding: 10px;
					border: 1px solid black;
					text-align: center;
				}
				.img-form-container{
					width: 200px;
				}
				.img-admin-update{
					width: 100%;
				  object-fit: contain;
				}
				.div-margin-top{
					margin-top: 30px;
				}
				.div-margin-bottom{
					margin-bottom: 100px;
				}
				.btn-save{
					width: 200px;
					height: 50px;
					background-color: #DFDFDF;
					color: black;
					text-align: center;
					line-height: 50px;
					border-radius: 10px;
				}
				.btn-save:hover{
					background-color: #4F4C4C;
					color: white;
					cursor: pointer;
				}
				input{
					width: 500px;
					text-align: center;
					font-size: 16px;
					line-height: 18px;
				}
				select{
					width: 500px;
					font-size: 16px;
					line-height: 18px;
					text-align: center;
				}
			</style>
			<script type="text/javascript" src="../add-edit.js"></script>
			<script
			  src="https://code.jquery.com/jquery-1.12.4.js"
			  integrity="sha256-Qw82+bXyGq6MydymqBxNPYTaUXXq7c8v3CwiYwLLNXU="
			  crossorigin="anonymous">
			 </script>
		</head>
		<body style="position: relative;margin:0;padding:0;width: 100%;height: 100%;">
	';
	if ( file_exists('admin/html/menu_admin.html')) include 'admin/html/menu_admin.html';
	else exit('error');


	if ($page1[1] == 'transformation' and $page[2] != ''){
		$url_transformation = explode(":", $page1[2]);

		$transformation_add_edit = $url_transformation[0];
		$transformation_type = $url_transformation[1];
		$transformation_id = $url_transformation[2];

		if ($transformation_add_edit == 'edit'){
			if ($transformation_type == 'category'){
			$result_category_two_lvl = $CONNECT->query("SELECT * FROM two_category WHERE id ='$transformation_id'");
			$row_category = $result_category_two_lvl->fetch_assoc();

				echo '
				<div class="div-form-add-edit">
					<form method="POST" name="form_edit_category" class="form-add-edit">
							<div>id текущей категории: '.$row_category['id'].'</div>

							<div class="div-margin-top">Категория 1-го уровня</div>
							<select name="id_one_category">';
								$result_category_one_lvl = $CONNECT->query("SELECT * FROM one_category");
								while($row_caregory_one = $result_category_one_lvl->fetch_assoc())// получаем все строки в цикле по одной
									{
										if ($row_caregory_one == $row_category['id_one_category']){
									  	echo '<option selected>'.$row_caregory_one['name'].'</option>';
										}
										else{
											echo '<option>'.$row_caregory_one['name'].'</option>';
										}
									}
						
						  
						echo '</select>
						<div class="div-margin-top">
							<div>Название категории</div>
					  	<input name="name" value="'.$row_category['name'].'" type="text">
					  </div>

					  <div class="div-img-admin-update div-margin-top">
					  	<div>Изображение категории на главной</div>
					  	<div class="img-form-container"><img class="img-admin-update" src="../../img/category/min/'.$row_category['imgMinCategory'].'"></div>
							<div>Название: '.$row_category['imgMinCategory'].'</div>
						  <div class="div-margin-top">Для смены изображения</div>
						  <div><input type="file" name="imgMinCategory" accept="image/jpeg,image/png"></div>
						  <div>длинной не более 450px</div>
					  </div>

					  <div class="div-img-admin-update div-margin-top">
					  	<div>Изображение категории в каталоге</div>
					  	<div class="img-form-container"><img class="img-admin-update" src="../../img/category/max/'.$row_category['imgMaxCategory'].'"></div>
							<div>Название: '.$row_category['imgMaxCategory'].'</div>
						  <div class="div-margin-top">Для смены изображения</div>
						  <div><input type="file" name="imgMaxCategory" accept="image/jpeg,image/png"></div>
						  <div>размером не более 1920x500 px</div>
					  </div>
					  
					  <div class="div-margin-top">URL категории</div>
					  <input name="urlCategory" value="'.$row_category['urlCategory'].'" type="text">
					  
					  <div class="div-margin-top div-margin-bottom btn-save" onclick="btn_edit_category(`inquiry.ajax`, `category.edit`, `id_one_category.name.urlCategory`	); return false">
					  	Сохранить
					  </div>
				 
				';
			}
			elseif ($transformation_type == 'product'){
				
			}
			else{
				echo 'error';
			}
		}
		elseif ($transformation_add_edit == 'add'){
			if ($transformation_type == 'category'){
				echo '
				<div class="div-form-add-edit">
					<form method="POST" name="form_add_category" onsubmit="return false;" class="form-add-edit">
							<div class="div-margin-top">Категория 1-го уровня</div>
							<select name="id_one_category">';
								$result_category_one_lvl = $CONNECT->query("SELECT * FROM one_category");
								while($row_caregory_one = $result_category_one_lvl->fetch_assoc())// получаем все строки в цикле по одной
									{
											echo '<option>'.$row_caregory_one['name'].'</option>';
									}

						echo '</select>
						<div class="div-margin-top">
							<div>Название категории</div>
					  	<input name="name" type="text">
					  </div>

					  <div class="div-img-admin-update div-margin-top">
					  	<div>Изображение категории на главной</div>
						  <div class="div-margin-top">Для смены изображения</div>
						  <div><input type="file" name="imgMinCategory" accept="image/jpeg,image/png"></div>
						  <div>длинной не более 450px</div>
					  </div>

					  <div class="div-img-admin-update div-margin-top">
					  	<div>Изображение категории в каталоге</div>
						  <div class="div-margin-top">Для смены изображения</div>
						  <div><input type="file" name="imgMaxCategory" accept="image/jpeg,image/png"></div>
						  <div>размером не более 1920x500 px</div>
					  </div>
					  
					  <div class="div-margin-top">URL категории</div>
					  <input name="urlCategory" type="text">
					  
					  <div class="div-margin-top div-margin-bottom btn-save">
					  	<button type="submit" name="submit">Сохранить</button>
					  </div>
				 
				';
			}
			elseif ($transformation_type == 'product'){
				
			}
			else{
				echo 'error';
			}
		}
		else{
			echo 'error';
		}
	}

		echo '
				</form>
			</div>
		</body>
		</html>
	';


?>