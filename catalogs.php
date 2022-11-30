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
				.url-add{
					text-decoration: none;
					color: black;
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
			</style>
		</head>
		<body style="position: relative;margin:0;padding:0;width: 100%;height: 100%;">
	';
	if ( file_exists('admin/html/menu_admin.html')) include 'admin/html/menu_admin.html';
	else exit('error');

echo '<div class = "div_table_center_screen">';
echo '<table>';
	if ($page1[1] == 'catalogs' and $page1[2] == ''){

		// ВЫВОДИМ КАТЕГОРИИ 1-ГО УРОВНЯ
		echo '<tr><th>id категории 1-го уровня</th><th>название</th></tr>';
		$result_category_one_lvl = $CONNECT->query("SELECT * FROM one_category"); // запрос на выборку
		while($row_category_one_lvl = $result_category_one_lvl->fetch_assoc())// получаем все строки в цикле по одной
		{
		    echo '
		    	<tr>
		    		<td>'.$row_category_one_lvl['id'].'</td>
		    		<td><a href="/admin/catalogs/category-id:'.$row_category_one_lvl['id'].'">'.$row_category_one_lvl['name'].'</a></td>
		    	</tr>
		    ';	
		}
	}

	// ВЫВОДИМ КАТЕГОРИИ 2-ГО УРОВНЯ ИЛИ ТОВАРЫ
	elseif ($page1[1] == 'catalogs' and $page1[2] != ''){
		$url_inquiry = explode(":", $page1[2]);
		$url_inquiry_type = $url_inquiry[0];
		$url_inquiry_id = $url_inquiry[1];

		// ВЫВОДИМ КАТЕГОРИИ 2-ГО УРОВНЯ
		if ($url_inquiry_type == 'category-id'){
			echo '<tr><th><a class="url-add" href="/admin/transformation/add:category"><div class="btn-add">Добавить категорию</div></a></th><th>id категории 2-го уровня</th><th>название</th><th>изображение на главной</th><th>изображение на странице</th><th>url адрес</th></tr>';
			$result_category_two_lvl = $CONNECT->query("SELECT * FROM two_category WHERE id_one_category ='$url_inquiry_id'"); // запрос на выборку
			while($row_category_two_lvl = $result_category_two_lvl->fetch_assoc())// получаем все строки в цикле по одной
			{
			    echo '
			    	<tr>
			    		<td><a class="url-edit" href="/admin/transformation/edit:category:'.$row_category_two_lvl['id'].'"><div class="btn-edit">Редактировать категорию</div></a></td>
			    		<td>'.$row_category_two_lvl['id'].'</td>
			    		<td><a href="/admin/catalogs/products-id:'.$row_category_two_lvl['id'].'">'.$row_category_two_lvl['name'].'</a></td>
			    		<td>'.$row_category_two_lvl['imgMinCategory'].'</td>
			    		<td>'.$row_category_two_lvl['imgMaxCategory'].'</td>
			    		<td>'.$row_category_two_lvl['urlCategory'].'</td>
			    		<td><a class="url-delete" href=""><div class="btn-delete">Удалить</div></a></td>
			    	</tr>
			    ';	
			}
		}

		// ВЫВОДИМ ТОВАРЫ
		elseif ($url_inquiry_type == 'products-id'){			
			echo '<tr><th>id товара</th><th>название</th><th>цена</th><th>закупочная цена</th><th>остаток на складе</th></tr>';
			$result_products = $CONNECT->query("SELECT * FROM products WHERE id_category ='$url_inquiry_id'"); // запрос на выборку
			while($row_products = $result_products->fetch_assoc())// получаем все строки в цикле по одной
			{
			    echo '
			    	<tr>
			    		<td>'.$row_products['id'].'</td>
			    		<td><a href="/admin/catalogs/product-id:'.$row_products['id'].'">'.$row_products['name'].'</a></td>
			    		<td>'.$row_products['price'].'</td>
			    		<td>'.$row_products['price_purchasing'].'</td>
			    		<td>'.$row_products['leftovers'].'</td>
			    	</tr>
			    ';	
			}
		}
		else{
			echo 'ошибка вывода';
		}

	}
	else{
		echo 'системная ошибка ';
	}



		echo '
				</table>
			</div>
		</body>
		</html>
	';



?>