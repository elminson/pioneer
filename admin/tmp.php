<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
	<style type="text/css">
		
	</style>
</head>
<body>
	<h1>Пользоваться google.ru МОЖНО!</h1>
	<ol start="1">
		<li>
			исправить html-код формы
			<?
				echo '<pre>'.htmlentities('
<form name="form1" method="GET">
		<input type="hidden" name="action" value="go_home">
		<select name="fruits" multiple size="4">
				<option name="o1" value="a">apple</option>
				<option name="o2" value=b selected>banana</option>
				<option id="o3" value="o">orange</option>
				<option name="o4" value="p">pear
		</select>
		<input type="file" name="my_file_to_upload">
</form>
				').'</pre>';
			?>
			</pre>
		</li>
		<li>
			Написать javascript-функцию, работающую с формой из предыдущего задания:
			<ul>
				<li>В результате работы функции в select-box'e 'fruits' должны быть выделены только два последних элемента.</li>
				<li>Функция должна работать и под IE, и под FF.</li>
				<li>Функция должна быть написана таким образом, чтобы не генерировать javascript-ошибки (не подавлять посредством try/catch).</li>
				<li>Учесть, что до вызова функции над select-box'ом могли "поработать" другие js-функции и/или пользователь.</li>
			</ul>
		</li>
		<li>
			Реализовать механизм хранения переменных сессий PHP в базе данных MySQL
		</li>
		<li>
			Есть таблица вида (способ хранения древовидной информации - NESTED SETS):
			<?
				$c = mysql_connect('83.102.242.66', 'root', '123456');
				mysql_query('set names utf8');
				mysql_selectdb('relvent', $c);
				$r = mysql_query("SELECT a.tree_name as name, a.tree_right_key as kright, a.tree_left_key as kleft, a.tree_description as description, a.tree_level as level FROM sys_tree a,  sys_tree b where b.tree_name = 'root' and a.tree_left_key > b.tree_left_key and a.tree_right_key < b.tree_right_key;", $c);
				echo '<table cellpadding="5" cellspacing="2" border="0"><tr><td>Наименование узла</td><td>Описание узла</td><td>Уровень узла</td><td>Правый ключ</td><td>Левый ключ</td></tr>';
				while ($row = mysql_fetch_object($r))
					echo "<tr><td>{$row->name}</td><td>{$row->description}</td><td>{$row->level}</td><td>{$row->kright}</td><td>{$row->kleft}</td></tr>";
				echo '</table>';
			?>
			Затем с помощью одного запроса вывести html-таблицу с полями: "Наименование узла", "Описание узла", "Уровень узла" только для children-ветки узла "Каталог"<br />
			Также требуется записать эту информацию в файл в формате csv.
		</li>
		<li>
			Описать разницу между конструкциями:
			<pre>
MyClass->Foo();
MyClass::Foo()

$i++;
++$i;

if($go == true) {}
if(true === $go) {}
			</pre>
		</li>
		<li>
			Описать простейший класс для получения текста (в конструкторе) и его вывода (метод), обеспечив совместимость с php 4.x.<br />
			Реализовать класс для версии 5.x
		</li>
		<li>
			Есть код (будет запускаться на версии php 5.x):
			 <pre>
$a = array('1', 2, 3);
$b = new stdClass();
$b->foo = "hello, world!";

function testA($a){
	$a[2] = 135;
}

function testB($b){
	$b->foo = "some text";
}

testA($a);
testB($b);

print_r($a);
print_r($b);
			 </pre>
			 Что будет выведено на экран в результате его выполнения?
		</li>
	</ol>
</body>
</html>