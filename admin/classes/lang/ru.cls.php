<?php

/**
	* class En
	*
	* Description for class En
	*
	* @author:
	*/
class Ru extends Language {

	public $language_id = "ru";

	/**
		* Constructor.  
		*
		* @param 
		* @return 
		*/
	function Ru() {
		parent::__construct();
		
		/*document title*/
		$this->document_title = "Административная консоль RAC Core 2.3";
		
		/*wellcome screen*/
		$this->welcome_message = "Добро пожаловать, ";
		$this->welcome_info_data = "Последний вход ";
		$this->welcome_info_address = " с адреса ";
		$this->logout = "Выход из системы";
		
		/*main menu*/
		$this->development_menu_text = "Управление данными";
        $this->development_menu_desc = "";
		$this->development_structure_text = "Сайты и разделы";
        $this->development_structure_desc = "Управление сайтами, создание разделов, публикация данных и изменение шаблонов отображения.";
		$this->development_storages_text = "Хранилища материалов";
        $this->development_storages_desc = "Создание новых типов данных, управление свойствами, ввод и редактирование данных.";        
		$this->development_design_templates_text = "Дизайн макеты";
        $this->development_design_templates_desc = "Добавление, редактирование и удаление макетов дизайна";
		$this->development_repository_text = "Библиотеки";
        $this->development_repository_desc = "Добавление, редактирование и удаление библиотек";
		$this->development_design_and_templates_text = "Макеты и Коды";
        $this->management_text = "Разработка";
        $this->management_desc = "";
        
		$this->development_empty_propertylist = "Property list is empty. Use the site/folder editor to fill the list types";
		
		$this->tools_menu_text = "Инструменты";
        $this->tools_menu_desc = "Инструментарий администратора";
        $this->tools_exec_script = "Исполнить скрипт";
        $this->tools_exec_script_desc = "Исполнить скрипт";
        $this->tools_recompile_core = 'Перекомпилировать ядро';
        $this->tools_recompile_core_desc = 'Перекомпилировать ядро для ускорения работы';
		$this->tools_usermanager_text = "Управление пользователями";
        $this->tools_usermanager_desc = "Управление учетными записями пользователей, ролями, группами и т.д.";
		$this->tools_blobmanager_text = "Ресурсы";
        $this->tools_blobmanager_desc = "Фотографии и другие загруженные в базу данных файлы.";
        $this->tools_filemanager_text = "Файлы";
        $this->tools_filemanager_desc = "Фотографии и другие загруженные на диск файлы.";
		$this->tools_settings_text = "Системные настройки";
        $this->tools_settings_desc = "Настройки системы";
        $this->tools_logout_text = "Выход из системы";
        $this->tools_logout_desc = "";
		$this->tools_systemrestore_text = "Восстановление системы";
        $this->tools_systemrestore_desc = "Вы можете использовать режим восстановления системы для отмены некорректных изменений в систему и для восстановления быстродействия и настроек системы";
		$this->tools_statistics_all_text = "Статистика";
        $this->tools_statistics_all_desc = "";
		$this->tools_statistics_text = "Статистика системы";
        $this->tools_statistics_desc = "Скоростные характеристики системы";
		$this->tools_sitestats_text = "Статистика сайта";
        $this->tools_sitestats_desc = "Статистика посещений сайта";
		$this->tools_management_text = "Ресурсы";
		$this->tools_notices_text = "Сообщения";
        $this->tools_notices_desc = "Управление сообщениями отправляемыми системой и сайтом администрации и пользователям.";
		$this->tools_modules_text = "Менеджер модулей";
        $this->tools_modules_desc = "Добавление, редактирование и удаление модулей";
		$this->tech_menu_text = "Техническое обеспечение";
		$this->tech_badpost_text = "Оповестить об ошибке";
		$this->tech_support_text = "Сервис центр phpRAC";
		$this->tech_versionnumber = "Код проверки системы";
		
		/*modules*/
		$this->modules_non_exists  = "Модули не установлены";
		$this->modules_title = "Модули";
		$this->modules_edit = "Редактирование модуля";
		$this->modules_add = "Создание модуля";
		$this->modules_menu_text = "Модули";
        $this->modules_menu_desc = "";
		$this->modules_select_empty = "Пожалуйста выделите пункт в списке модулей";
		$this->modules_empty_list = "В данный момент в системе не установлен ни один модуль";
		$this->modules_version_info = "Совместимость с версиями: ";
		$this->modules_alias_text = "Наименование";
		$this->modules_version_text = "Версия";
		$this->modules_enabled_text = "Состояние";
		$this->modules_description_text = "Описание";
		$this->modules_add_text = "Укажите файл с инсталлятором модуля";
		$this->modules_install_success_text = "Модуль успешно установлен";
		$this->modules_install_fail_text = "Инсталляция модуля прервана";
		$this->modules_initialize_error = "Неудачная попытка инициализации модуля";
		
		$this->module_storage_nonexists = "Хранилище не существует";
		$this->module_library_nonexists = "Библиотека не существует";
		
        $this->modules_module_favorite = "Избранный";
		$this->modules_module_import_info = "
			Укажите файл инсталлятора модуля. Файл должен содержать данные в формате XML.
		";
		
		$this->modules_module_edit_info = "
			<strong>\"Тип\"</strong> - тип модуля<br />
			<strong>\"Редактор\"</strong> - наличие пользовательского редактора в административной консоли<br />
			<strong>\"Публикация\"</strong> - возможность опубликовать модуль<br />
			<strong>\"Точка входа\"</strong> - наименование мастер-класса, выступающего в роли инициализатора при запуске модуля.
			Должен быть наследован от класса CModule<br />
			<strong>\"Наименование\"</strong> - произвольное наименование модуля<br />
			<strong>\"Описание\"</strong> - произвольное описание модуля<br />
			<strong>\"Версия\"</strong> - текущая версия модуля. Задается в формате x.x<br />
			<strong>\"Совместимость с консолью\"</strong> - перечисление версий административной консоли, совместимых с модулем. Значения в списке должны быть разделены символом ','<br />
			<strong>\"Совместимость\"</strong> - перечисление совместимых ранних версий модуля. Значения в списке должны быть разделены символом ','<br />
			<strong>\"Исходный код\"</strong> - программный код модуля, реализующий логику работы<br />
			<strong>\"Хранилища\"</strong> - перечисление системных имен хранилищ модуля. Значения в списке должны быть разделены символом ','<br />
			<strong>\"Библиотеки\"</strong> - перечисление системных имен библиотек модуля. Значения в списке должны быть разделены символом ','
		";
		$this->modules_module_haseditor = "Редактор";
		$this->modules_module_publicated = "Публикация";
		$this->modules_module_entry = "Точка входа";
		$this->modules_module_title = "Наименование";
		$this->modules_module_description = "Описание";
		$this->modules_module_version = "Версия";
		$this->modules_module_admincompat = "Совместимость c консолью";
		$this->modules_module_compat = "Совместимость";
		$this->modules_module_code = "Исходный код";
		$this->modules_module_storages = "Хранилища";
		$this->modules_module_libraries = "Библиотеки";
		$this->modules_module_type = "Тип";
		$this->modules_module_iconpackname = "Пакет иконок";
		
		$this->modules_module_exportlink = "Скачать";
		$this->modules_module_exportwithdata = "Экспорт с данными";
		$this->modules_module_exportversion = "Обновление для версии";
		$this->modules_module_exportheader = "Дополнительная информация";
		
		/*error messages*/
        $this->error_file_to_big = "Вы пытаетесь загрузить в базу данных файл размером больше чем 200K.";
        
		$this->error_form_empty = "Пожалуйста заполните обязательные поля";
        
        $this->load_vseditor = "загрузить визуальный редактор";
		
		$this->error_message_box_title = "Центр поддержки";
		$this->error_select_node = "Пожалуйста выделите пункт в дереве.";
		$this->error_select_setting = "Пожалуйста выделите настройку";
		$this->error_select_notice = "Пожалуйста выделите сообщение";
		$this->error_select_data = "Пожалуйста выделите данные для публикации";
		$this->error_select_data_edit = "Пожалуйста выделите данные для редактирования";
		$this->error_select_data_copy = "Пожалуйста выделите данные для копирования";
		$this->error_cannotcopy = "Опибка копирования";
		$this->error_select_storage = "Пожалуйста выделите хранилище";
		$this->error_select_library = "Пожалуйста выделите библиотеку";
		$this->error_select_publication = "Пожалуйста выделите публикацию";
		$this->error_select_item = "Пожалуйста выделите одну строчку в списке";
		$this->error_select_atleast2pubs = "Вы должны выбрать две публикации";
		$this->error_multiple_select_not_allowed = "Пакетная обработка данных не возможна.";
		$this->error_operation_not_permitted = "У Вас нет прав на выполнение данной операции. Пожалуйста свяжитесь с администратором.";
		$this->error_emailnotsupllied = "Вы должны ввести адрес электронной почты.";
		$this->error_incorrectemail = "Электронный адрес который вы ввели некорректен.";
		$this->error_cannotedit = "Вы не можете редактировать эти данные.";
		$this->error_cannotdelete = "Произошла системная ошибка при удалении раздела/сайта!\nПожалуйста свяжитесь с администратором или разработчиком для исправления ошибки";
		$this->error_cannotmove = "Опибка при попытке перемещения раздела";
		$this->error_cannotsave = "Произошла ошибка при сохранении раздела/сайта.";
		$this->error_module_install_file = "Этот файл не является инсталлятором модуля";
		$this->error_module_bad = "Некорректный формат определения модуля";
		$this->error_incorrect_move = "Вы не можете перенести раздел/папку саму в себя";
		$this->error_unknown = "Неизвестная ошибка";
		$this->error_storage_in_onetomany_link = "Данное хранилище находится в связке и может быть редактировано только через нее";
		$this->error_select_user = "Пожалуйста выделите пользователя";
		$this->error_select_group = "Пожалуйста выделите группу";		
		$this->error_select_role = "Пожалуйста выделите роль";		
		$this->error_can_not_delete_logged_user = "Вы не можете удалить активную учтную запись. Для ее удаления вам необходимо перезайти в систему под другим именем";
		$this->error_operation_not_supported = "Операция не поддерживается с выбранным типом данных";
        $this->error_nameisrequired = 'Наименование Сайта/Раздела необходимо';
        $this->error_namedublicated = 'Наименование Сайта/Раздела не должно повторяться на одном уровне';
        
        $this->error_cannotcreatefolder = 'Невозможно создать директорию';
        
		
		/*titles*/
		$this->general_title = "Авторизация";
		$this->development_title = "Управление";
		$this->development_structure = "Структура";
		$this->development_storages = "Хранилища";
		$this->development_designtemplates = "Макеты дизайнов";
		$this->development_repository = "Библиотека";

		$this->tools_title = "Инструменты";
		$this->tech_title = "Поддержка";

		/*sub titles*/
		$this->development_structure_view = "Список сайтов и разделов";
		$this->development_structure_addsite = "Добавить сайт/раздел";
		$this->development_structure_editsite = "Редактировать сайт/раздел";
		$this->development_structure_content = "Публикации из раздела ";
		$this->development_structure_addpublish = "Данные: Публикация в раздел ";
		$this->development_structure_editdata = "Редактировать данные";
		$this->development_structure_adddata = "Ввод данных в ";
		$this->development_structure_adddubdata = "Копирование данных в ";
		$this->development_structure_moveto = "Перенос раздела/папки ";
		$this->development_structure_movepubs = "Перенос публикаций из раздела ";
		
		$this->tech_bugreport = "Отправить сообщение об ошибке";
		$this->tools_blobmanager_browse = "Показать файлы";
		$this->tools_usermanager_view = "Группы";
		$this->tools_usermanager_addedit = "Добавить/Редактировать группу";
		$this->tools_usermanager_listall = "Список всех пользователей";
		$this->tools_usermanager_listungrouped = "Список пользователей без группы";
		$this->tools_usermanager_listin = "Список пользователей из группы ";
		$this->tool_usermanager_adduser = "Добавить/Редактировать пользователя";
		$this->tool_usermanager_permissions = "Права на ";
		
		
		$this->setpermissions_title = "Выставление прав";
		
		/*development page*/
		$this->development_storages_message_ok_1 = "Список хранилищ";
		$this->development_storages_message_ok_2 = "Данные из ";
		$this->development_storages_view = "Список хранилищ";
		$this->development_storages_addeditstorage = "Добавить/Изменить хранилище";
		$this->development_storages_listfields = "Список свойств для ";
		$this->development_storages_addfield = "Добавить свойство в ";
		$this->development_storages_editfield = "Редактировать свойство ";
		$this->development_storages_listtemplates = "Шаблоны хранилища ";
		$this->development_storages_addtemplate = "Добавить шаблон для ";
		$this->development_storages_edittemplate = "Редактировать шаблон ";
		$this->development_storages_browse = "Данные из ";
		$this->development_storages_addeditdata = "Добавить/Редактировать данные из ";
        $this->development_storages_copystorage = "Копирование хранилища";
		$this->development_designtemplates_view = "Список макетов дизайна";
		$this->development_designtemplates_addedit = "Добавить/Редактировать макет ";
		$this->development_repository_view = "Список библиотек";
		$this->development_repository_addedit = "Добавить/Редактировать библиотеку ";
		
		$this->expand_collapse_children_message = "Показать/Не показывать дочерние публикации";
        
        $this->in_file = "Состояние";
		
		/*forms*/
		$this->addbatch = "Добавить";
		$this->save = "Сохранить";
		$this->clear = "Очистить";
		$this->accept = "Принять";
		$this->apply = "Применить";		
		$this->edit_subtable = "Редактировать";
		$this->remove = "Удалить";		
		$this->remove_current = "Удалить текущий";
		$this->cancel = "Отменить";
		$this->import = "Импорт";
		$this->export = "Экспорт";
		$this->note = "Заметки";
		$this->setpermissions = "Выставить права";
		$this->reset = "Сбросить форму";
		$this->createpoint = "Создать точку";
		$this->restorerac = "Восстановить";
		$this->toolbar_copyrows = "Копировать строчки";
        $this->toolbar_exec = "Исполнить PHP script";
        $this->script_text = "Скрипт";
		$this->copies = "Количество копий";
		$this->copy_ = "Копировать";
        $this->moveto_ = "Перенести";
        $this->copy_storage = "Копировать хранилище";

		$this->development_name = "Наименование";
		$this->development_publications = "Публикации";
		$this->development_select_storage = "Выбор хранилища";
		$this->development_select_order = "Сорт.";
		$this->development_select_orderby = "Сортировать по: ";
		$this->development_select_direction = "Порядок: ";
		$this->development_select_multifield = "Выбор поля";
		$this->development_nopubs = "Публикаций не найдено";
		$this->development_nodata = "Информация отсутствует";		
		$this->development_notemplates = "Список макетов пуст";
		$this->development_nolibs = "Список библиотек пуст";
		
		
		$this->development_published = "Опубликован";
		$this->development_sitename = "Наименование сайта";
		$this->development_foldername = "Наименование раздела";
		$this->development_moveto = "Перенести в ";
		$this->development_copy = "Копировать";
		$this->development_domainname = "Адрес сайта";
		$this->development_keyword = "Ключевое слово (используется в url)";
		$this->development_description = "Описание";
		$this->development_language = "Язык сайта";
		$this->development_template = "Макет дизайна";
		$this->development_notes = "Заметки";
		$this->development_properties = "Добавочные поля";
		$this->development_headerinfo = "Информация о заголовке";
		/*  header info texts will be added later */

		
        $this->development_storage_default_group = "Основные хранилища";
		$this->development_storage_description = "Описание хранилища";
		$this->development_storage_table = "Таблица в БД";
        $this->development_storage_copy_fields = "Копировать поля";
        $this->development_storage_copy_templates = "Копировать шаблоны";
        $this->development_storage_copy_data = "Копировать данные";
        $this->development_storage_table_new = "Название новой таблицы в БД";
		$this->development_usedtostoredata = "используется для хранения в БД";
		$this->development_storage_color = "Цвет в отображении в CMS";
        $this->development_storage_parent  = "Основное хранилище";
        $this->development_storage_group = "Группа хранилища";
        $this->development_storage_istree = "Дерево";
		
		$this->development_lookup_table = "Таблица для выборки";
		$this->development_lookup_field_list = "Запрашиваемые поля";
		$this->development_lookup_field_id = "Имя ключевого поля запрашиваемой таблицы";
		$this->development_lookup_field_view_list = "Отображаемые поля";
		$this->development_lookup_field_cond = "Дополнительные условия в выборке";
		$this->development_lookup_field_query = "Текст запроса";
        $this->development_lookup_field_order = "Сортировка";
		
		$this->development_field_name = "Наименование";
		$this->development_field_type = "Тип";
        $this->development_field_group = "Группа";
		$this->development_field_description = "Описание";
		$this->development_field_description_desc = "Поле в БД";
		$this->development_field_default = "Значение по умолчанию";
		$this->development_field_values = "Возможные значения";
		$this->development_field_values_desc = "Список значений данного типа.<br>Список разделен переводом строки. Формат значения &lt;value&gt;: &lt;visible text&gt;";
		$this->development_field_default_desc = "используется если в поле ничего не введено";
		$this->development_field_required = "Обязательное поле";
		$this->development_field_required_desc = "показывает необходимость введения значения в данное поле";
		$this->development_field_viewindeftempl = "Включить в шаблонепо умолчанию";
		$this->development_field_viewindeftempl_desc = "включает в шаблон по умолчанию";
        $this->development_field_comment = "Коментарий на поле";
        $this->development_field_comment_desc = "ваш коментарий";
		$this->development_field_lookup = "Выборка";
		$this->development_field_lookup_desc = "Используется для создания выборки в данное поле. <br>
			Обязательные поля: \"Таблица для выборки\", \"Запрашиваемые поля\", \"Имя ключевого поля\", \"Отображаемые поля\"<br>
			\"Запрашиваемые поля\" - список запрашиваемых полей в SQL-запросе к таблице<br>
			\"Отображаемые поля\" - список полей связанной таблицы, отображаемых в редакторе данных для данного поля. Имеет следующий формат - <поле1, поле2, ...><br>
			\"Текст запроса\" - значение будет использовано как приоритетное по отношению к значениям остальных полей. <br />
            Обязательные поля: \"Запрашиваемые поля\", \"Имя ключевого поля запрашиваемой таблицы\", \"Отображаемые поля\""; 
			//<br>формат следующего вида: [select query]:[idfield]<br>[select query] - sql команда в которой можно использовать \$currentrow обьект (текущая строка), \$idfield - поке которое надо возвратить.<br>например: select * from news order by news_title:id
		$this->development_field_onetomany = "Один ко многим";
		$this->development_field_onetomany_desc = "создание связки один ко многим автоматически отключает возможность ввода свободных данных в выбранное хранилище. выбранное хранилище должно быть пустым";
		

		$this->development_storages_template_admin = "Административный шаблон";
		$this->development_storages_template_default = "Шаблон по умолчанию";
		$this->development_storages_template_custom = "Свой шаблон";
		$this->development_storages_template_composite = "Составной";
		$this->development_storages_template_cache = "Кэширование";
		$this->development_storages_template_cachecheck = "Параметры кэширования";
		
		$this->development_storages_template_type = "Тип шаблона";
		$this->development_storages_template_name = "Название шаблона";
		$this->development_storages_template_description = "Описание шаблона";
		$this->development_storages_template_properties = "Доп. поля";
		$this->development_storages_template_list = "Вывод";
		$this->development_storages_template_styles = "Стили";
		$this->development_storages_template_create = "Создание";
		$this->development_storages_template_operation_list = "операция вывода";
		$this->development_storages_template_operation_before = "код выполняемый перед операцией";
		$this->development_storages_template_operation_form = "форма операции";
		$this->development_storages_template_operation_after = "код выполняемый после операцией";
		$this->development_storages_template_delete = "Удаление";
		$this->development_storages_template_modify = "Редактирование";
		$this->development_storages_template_email = "Форма эл.почты";
		$this->development_storages_template_templ = "шаблон эл.почты";
		$this->development_storages_template_note = "\$args-&gt;datarow - текущая строка данных <br> \$args-&gt;storage - хранилище <br> \$args-&gt;fields - список свойств (т.е. \$storage-&gt;fields) <br> \$ret - возвращаемое значение (вы должны возвратить весь вывод на страницы в строковую переменную \$ret)</span>";
		$this->development_storages_template_default = "Шаблон по умолчанию";
		$this->development_storages_template_empty = "Пустой шаблон";
		
		$this->development_designtemplate_name = "Название макета";
		$this->development_designtemplate_libs = "Вставки библиотек(include) (список разделенный запятой)";
		$this->development_designtemplate_doctype = "Тип документа (HTML DocType)";
		$this->development_designtemplate_title = "Заголовок документа";
		$this->development_designtemplate_mkeywords = "Ключевые слова";
		$this->development_designtemplate_mdescription = "Описание";
		$this->development_designtemplate_shortcuticon = "Иконка";
		$this->development_designtemplate_baseurl = "Основный путь";
		$this->development_designtemplate_styles = "Стили";
		$this->development_designtemplate_scripts = "Скрипты";
		$this->development_designtemplate_ad = "Добавочные тэги";
		$this->development_designtemplate_header = "PHP код внутри head тэга";
		$this->development_designtemplate_body = "Тело макета";
		
		$this->development_repository_name = "Название библиотеки";
		$this->development_repository_codetype = "Тип бибилиотеки";
		$this->development_repository_body = "Тело";
		$this->development_repository_export = "Пакет сохранен в папке upload.<br><br>Для загрузки файла кликните";
		$this->development_repository_export_link = "сюда";
		
		$this->development_repository_choosemulti = "Выбор информации из хранилища в поле ";
				

		/*toolbars*/
		$this->toolbar_modules_import = "Импорт";
		$this->toolbar_modules_export = "Экспорт";
		$this->toolbar_modules_listtemplates = "Шаблоны";
        $this->toolbar_modules_dumpscript = "Выгрузить модуль в PHP скрипт";
		
		$this->toolbar_unique = "№";
		
		$this->toolbar_canceledit = "Отменить редактирование";
		$this->toolbar_saveedit = "Сохранить изменения";
		$this->toolbar_select = "Выбрать";
		$this->toolbar_close = "Закрыть окно";
		$this->toolbar_deselect = "Снять выделение";
		$this->toolbar_selectall = "Выбрать все";
		$this->toolbar_changestate = "Вкл/выкл";
		$this->toolbar_enable = "Включить";
		$this->toolbar_disable = "Отключить";
		$this->toolbar_create = "Создать";
		$this->toolbar_add = "Добавить";
		$this->toolbar_adddata = "Добавить данные";
        $this->toolbar_movetodata = "Перенести данные";
        $this->toolbar_moveupdata = "Вверх";
        $this->toolbar_movedowndata = "Вниз";
		$this->toolbar_addstorage = "Добавить хранилище";
		$this->toolbar_addfield = "Добавить свойство";
		$this->toolbar_addtemplate = "Добавить шаблон";
		$this->toolbar_addlibrary = "Добавить библиотеку";
		$this->toolbar_edit = "Редактировать";
		$this->toolbar_properties = "Редактировать доп.свойства";
		$this->toolbar_editselected = "Редактировать выбранные";
		$this->toolbar_editmulti = "Редактировать связанные данные";
		$this->toolbar_import = "Импортировать данные";
		$this->toolbar_editstorage = "Редактировать хранилище";
		$this->toolbar_editfields = "Список свойств";
		$this->toolbar_editfield = "Редактировать свойство";
		$this->toolbar_edittemplate = "Редактировать шаблон";
		$this->toolbar_edittemplates = "Список шаблонов";
		$this->toolbar_removestorage = "Удалить хранилище";
		$this->toolbar_removefield = "Удалить свойство";
		$this->toolbar_removetemplate = "Удалить шаблон";
		$this->toolbar_remove = "Удалить";
		$this->toolbar_removeselected = "Удалить выбранные";
		$this->toolbar_removemessage = "Вы действительно хотите удалить выбранное?";
		$this->toolbar_recreatemessage = "Вы действительно хотите перестроить кэш системы безопасности?";
		$this->toolbar_recompilemessage = "При проведении данной операции данные из хранилища будут удалены! Вы уверены?";
		$this->toolbar_browse_publications = "Просмотр публикаций";
		$this->toolbar_browse_files = "Просмотр файлов";
		$this->toolbar_browse_publications_info = "№: %s, хранилище/модуль: %s, дата публикации: %s<br />Шаблон: %s";
		$this->toolbar_stoarge_data_id = "№";
        $this->toolbar_stoarge_node_level = 'уровень';
        $this->toolbar_stoarge_data_publishedto = "опубликован в";
        $this->toolbar_stoarge_data_datecreated = "дата создания";
		$this->toolbar_preview = "Предпросмотр раздела";
		$this->toolbar_addpublish = "Опубликовать данные";
		$this->toolbar_removepublication = "Удалить публикацию";
		$this->toolbar_move = "Перенести";
		$this->toolbar_moveup = "Вверх";
		$this->toolbar_movedown = "Вниз";
		$this->toolbar_changeorder = "Поменять местами";
        $this->toolbar_addpublished = "Добавить и опубликовать данные в раздел";
		$this->toolbar_editpublished = "Редактировать данные";
		$this->toolbar_publish = "Опубликовать";
		$this->toolbar_publishunpublish = "Опубликовать/Снять с публикации";
		$this->toolbar_choosemulti = "Выбрать";
		$this->toolbar_backtofolders = "Вернуться к разделам";
		$this->toolbar_backtofilefolders = "Вернуться к папкам";		
		$this->toolbar_backtomodules = "Вернуться к модулям";
		$this->toolbar_backtopublish = "Вернуться к публикациям";
        $this->toolbar_back = "Вернуться";
		$this->toolbar_cancelchoose = "Вернуться к списку";
		$this->toolbar_backtostorages = "Вернуться к хранилищам";
		$this->toolbar_backtogroups = "Вернуться к группам";
		$this->toolbar_backtomultilink = "Вернуться к редактированию";
		$this->toolbar_publish = "Опубликовать";
		$this->toolbar_recompile = "Компилировать";
		$this->toolbar_browse = "Данные";
		$this->toolbar_createinstall = "Пакетизировать";
		$this->toolbar_install = "Инсталлировать";
		$this->toolbar_permissions = "Проставить права";
		$this->toolbar_viewusers = "Список пользователей";
		$this->toolbar_refresh = "Обновить";
		$this->toolbar_permissions = "Права";
		$this->toolbar_open = "Открыть";
		$this->toolbar_backtoblobcategories = "Вернуться к категориям";
		$this->toolbar_addblob = "Добавить ресурсс";
		$this->toolbar_editblob = "Редактировать";
		$this->toolbar_removeblob = "Удалить выбранное";
		$this->toolbar_expand = "Развернуть";
		$this->toolbar_collapse = "Свернуть";
		$this->toolbar_clear = "Очистить";
		$this->toolbar_next = "Вперед";
		$this->toolbar_prev = "Назад";


		$this->toolbar_rows_text = "Записей";
		$this->toolbar_pages_text = "Стрниц";
		
		$this->toolbar_sort = "Сортировать список";
		$this->toolbar_sortasc = "Сортировать список по возрастанию";
		$this->toolbar_sortdesc = "Сортировать список по убыванию";
        
        $this->toolbar_export = "Экспорт/Импорт";
        $this->toolbar_exportmessage = "Подтвердите операцию!";
		
		
		$this->template_default_name = "Шаблон по умолчанию";
		

		/*general page*/
		$this->authorization = "Форма авторизации";
		$this->general_user_name = "Имя пользователя";
		$this->general_password = "Пароль";
		$this->general_login = "Войти";
		
		
		/*tech page*/		
		$this->tech_bug_report_sent = "Сообщение отправлено.";
		
		$this->tech_full_name = "Полное имя";
		$this->tech_email = "Электронный адрес";
		$this->tech_message = "Сообщение";
		$this->tech_send_report = "Отправить";

		/*tools page*/
		$this->tools_cron_setscheduler = "Планировщик";
		$this->tools_cron_setscheduler_desc = "У вас есть возможность настроить план создания точек восстановления.";
		
		$this->tools_usermanager_groupname = "Название группы";
		$this->tools_usermanager_groupdescription = "Описание группы";
		$this->tools_usermanager_rolename = "Название роли";
		$this->tools_usermanager_roledescription = "Описание роли";
		$this->tools_usermanager_roleoperations = "Операции";
		$this->tools_usermanager_allusers = "Все пользователи";
		$this->tools_usermanager_ungroupedusers = "Пользователи без группы";
		
		$this->tools_usermanager_permissions_users = "Пользователи и группы";
		
		$this->tools_nogroups = "Нет определенных групп";
		$this->tools_users_removeselection = "очистить выбранное";		

		$this->tools_users_password = "Пароль";
		$this->tools_users_disabled = "Деактивирован";
		$this->tools_users_developer = "Пользователь разработчик";
		$this->tools_users_selectgroups = "Выбрать группы";
		$this->tools_users_email = "Эл.адрес";
		$this->tools_users_created = "Создан";
		$this->tools_users_lastlogged = "Последний вход";
		
		$this->tools_users_name = "Имя пользователя/Логин";
		$this->tools_users_groups = "Группы";
		$this->tools_users_roles = "Роли";
		$this->tools_users_info = "Информация";
		
		$this->tools_usermanager_users = "Пользователи";
		$this->tools_usermanager_users_edit = "Редактирование пользователя ";
		$this->tools_usermanager_users_add = "Ввод нового пользователя";
		
		$this->tools_users_recompile = "Пересоздать кэш операций и ролей";	
        
        $this->tools_foldername = "Название папки";
		
		
		$this->tools_blobs = "Ресурсы";
		$this->tools_noblobs = "В данной категории нет ресурсов";
		$this->tools_blobs_category_edit = "Редактировать категорию ";
		$this->tools_blobs_category_add = "Добавить категорию ресурсов";
		$this->tools_blobs_category_name = "Название категории";
		$this->tools_blobs_category_content = "Ресурсы в категории ";
		$this->tools_blobs_category_content_nocategory = "Ресурсы вне категорий";
		$this->tools_blobs_file = "Выберите файл";
		$this->tools_blobs_url = "Введите URL файла";
		$this->tools_blobs_alt = "Введите alt текст";
		$this->tools_blobs_category = "Выберите категорию";
		$this->tools_blobs_addresources = "Ввод ресурсов";
		$this->tools_blobs_editresource = "Редактировать ресурс ";
		$this->tools_blobs_selectresource = "Выбрать ресурс ";		
		$this->tools_blobs_addresources_note = "
			Ввод партии ресурсов<br>
			Для добавления ресурса щелкните на кнопке 'Добавить'<br>
			При вводе ресурса есть возможность либо выбрать файл с диска (поле 'Выберите файл') <br>
			либо указать URL файла в интернете (поле 'Введите URL файла').
		";
        
        $this->toolbar_upload = "Загрузить файл";
        $this->tools_files_upload_form = "
            Ввод партии файлов<br>
            Используйте кнопку добавить для загрузки нескольких файлов одновременно.
        ";
        
        $this->tools_selectsitefeature = "Выбрать ";
		
		$this->tools_permissions_sitefolder = "Сайт/Раздел";
		$this->tools_permissions_inherit = "Наследовать";
		$this->tools_permissions_view = "Отображение";
		$this->tools_permissions_create = "Создание";
		$this->tools_permissions_delete = "Удаление";
		$this->tools_permissions_modify = "Редактирование";
		$this->tools_permissions_deny = "Запретить";
		$this->tools_permissions_allstructure = "Вся структура";
		$this->tools_permissions_storages = "Хранилища";
		
		$this->tools_statistics = "Статистика системы";
		$this->tools_statistics_message = "Данный раздел находится в разработке.";
        //<td align=right>Размер в байтах</td>
		$this->tools_statistics_info = "<h4 style='margin-bottom:0px'>Информация о разделах:</h4>
										<div class='statinfo'>Количество разделов/категорий: <b>%d</b></div>
										<div class='statinfo'>Время прохода (Nested sets): <b>%.3f ms</b></div>
										<div class='statinfo'>Время прохода пшо рекурсии: <b>%.3f ms</b></div>
										<br>
										<h4 style='margin-bottom:0px'>Публикации</h4>
										<div class='statinfo'>Количество публикаций в системе: <b>%d</b></div>
										<div class='statinfo'>Максимальная вложенность: <b>%d</b></div>
										<div class='statinfo'>Время прохода по рекурсии: <b>%.3f ms</b></div>
										<br>
										<h4 style='margin-bottom:0px'>Хранилища</h4>
										<div class='statinfo'>Количество хранилищь: %d</div>
										<div class='statinfo'>
										<table cellpadding=0 cellspacing=0 border=0 class='content-table'><tr class=title><td width='50%%'><b>Хранилище (таблица)</b></td><td align=center>Свойства</td><td align=right>Строки</td><td align=right>Шаблоны</td><td align=right>Время прохода</td></tr>
										%s
										</div>
										<br>
										<br>
										<br>
										";
		
		
		$this->tools_system_restore = "Восстановление системы";
		$this->tools_system_restore_message1 = "Процесс восстановления системы";
		$this->tools_system_restore_message2 = "<span class=warning-title>Внимание:</span> <span class=warning>Нажатие клавишы F5 (т.е. обновление страницы) приведет к повторному восстановлению базы.</span><p>";
		$this->tools_system_restore_message3 = "Пожалуйста подождите окончания процесса...<p>";
		$this->tools_system_restore_message4 = "файл создан, пожалуйста перейдите по ссылке <a href=\"%s\" target=\"_blank\">%s</a> для запуска процесса восстановления";
		$this->tools_system_restore_message5 = "Точка восстановления не указана, либо произошла ошибка при исполнении.<br>Пожалуйста вернитесь <a href='javascript: history.back();'>назад</a> и выберите точку восстановления";
		$this->tools_system_restore_message6 = "Создание точки восстановления ...";
		$this->tools_system_restore_message7 = "<span class=warning-title>Внимание:</span> <span class=warning>Нажатие клавишы F5 (т.е. обновление страницы) приведет к повторному созданию точку восстановления.</span><p>";
		$this->tools_system_restore_message8 = "Пожалуйста подождите окончания процесса...<p>";
		$this->tools_system_restore_message9 = "Точка восстановления успешно создана...<br>";
		$this->tools_system_restore_message10 = "Точка восстановления ";
		$this->tools_system_restore_message11 = "<p>Кликните <a href='javascript: history.back();'>здесь</a> для возврата на страницу восстановления системы";
		
		$this->tools_settings_view = "Список настроек";
		$this->tools_settings_addedit = "Добавить/Редактировать настройку ";

		$this->tools_notice_view = "Список макетов сообщений";
		$this->tools_notice_addedit = "Добавить/Редактировать макет ";
		
		$this->tools_system_restore_message = "Вы можете использовать режим восстановления системы для отмены некорректных изменений в систему и для восстановления быстродействия и настроек системы. Режим восстановления возвращает системы в раннее состояние (называнимое Точка восстановления).<br><br>Количество точек восстановления как созданных вручную так и созданных посредством планировщика ограничено системной настройкой SYSTEM_RESTORE_CRON_MAX. <br><br>Во избежание переполнения квоты не выставляйте значение -1 (не ограничивать).";
		$this->tools_restoremyrac = "Восстановить систему";
		$this->tools_select_restorepoint = "Выберите точку восстановления";
		
		$this->tools_setting_name = "Наименование";
		$this->tools_setting_value = "Значение";
		$this->tools_setting_type = "Тип значения";
		$this->tools_setting_settingtype = "Уровень доступа";
		$this->tools_setting_category = "Категория";

		$this->tools_notice_keyword = "Ключ";
		$this->tools_notice_subject = "Тема";
		$this->tools_notice_encoding = "Кодировка";
		$this->tools_notice_body = "Макет";

		
		$this->tools_log = "Лог";
		$this->tools_view_access_log = "Лог запросов";
		$this->tools_view_error_log = "Лог ошибок";
		
		$this->rowsonpage = "По: ";
		$this->pages = "Стр.: ";
        $this->rows = "Всего: ";

		$this->move_to_other_issue = "Переход в другой раздел";
				
		$this->filter_title = "Фильтр";
		$this->filter_go = "Применить";
		$this->filter_text = "Отфильтровать список";
		$this->filter_multilink = "Показать все ";
		
		$this->advanced_operations = "Дополнительные операции";
		
		$this->are_you_sure_message = "Пожалуйста подтвердите опреацию";
		
		$this->incorrect_lookup = " -- неверная ссылка -- ";
		$this->empty_lookup = " -- не задано -- ";
		$this->incorrect_multilink = "-- неверная множественная ссылка --";
		$this->empty_multilink = " -- не задано -- ";
        
        $this->filter_fulltextsearch = "Запрос: ";
        $this->filter_fulltextsearch_desc = "Полнотекстовый поиск ведется по всем текстовым полям (TEXT, MEMO, HTML)";
        $this->filter_dates = "Дата модификации: ";
        $this->filter_field_contains = "содержит";
        $this->filter_field_equals = "равен";
        $this->filter_fulltext = "Полнотекстовый поиск";
        $this->filter_datesearch = "Поиск по дате модификации";
        $this->filter_fields = "Поиск по полям";
        
        $this->amonth = array("января", "февраля", "марта", "апреля", "мая", "июня", "июля", "августа", "сентября", "октября", "ноября", "декабря");

        $this->publication_children = "Дочерние публикации, кол.: %s";
        
        $this->toolbarlabel_quickedit = "Ввод данных";
        
	}
}

?>
