<?php

$_tmp = [
    'menu_name' => 'mmxSuperShop',
    'menu_desc' => 'Заготовка для создания нового mmx приложения',
    'actions' => [
        'create' => 'Создать',
        'edit' => 'Изменить',
        'submit' => 'Отправить',
        'cancel' => 'Отмена',
        'delete' => 'Удалить',
    ],
    'models' => [
        'category' => [
            'title_one' => 'Категория',
            'title_many' => 'Категории',
            'id' => 'Id',
            'title' => 'Название',
            'alias' => 'Псевдоним',
            'active' => 'Активно',
            'rank' => 'Сортировка',
            'created_at' => 'Создано',
            'updated_at' => 'Изменено',
        ],
        'product' => [
            'title_one' => 'Товар',
            'title_many' => 'Товары',
            'id' => 'Id',
            'title' => 'Название',
            'alias' => 'Псевдоним',
            'active' => 'Активно',
            'rank' => 'Сортировка',
            'created_at' => 'Создано',
            'updated_at' => 'Изменено',
            'gallery' => 'Галерея',
        ],
    ],
    'components' => [
        'no_data' => 'Нет данных для вывода',
        'no_results' => 'Результатов не найдено',
        'records' => 'Записей нет | {total} запись | {total} записи | {total} записей',
        'query' => 'Поиск...',
        'delete' => [
            'title' => 'Требуется подтверждение',
            'confirm' => 'Вы уверены, что хотите удалить эту запись?',
        ],
    ],
    'snippets' => [
        'nocss' => 'Не загружать собранный CSS',
    ],
    'errors' => [
        'item' => [
            'title_unique' => 'Заголовок предмета должен быть уникальным.',
        ],
        'gallery' => [
            'wrong_type' => 'Выберите картинку!',
        ],
    ],
];

/** @var array $_lang */
$_lang = array_merge($_lang, MMX\Super\Shop\App::prepareLexicon($_tmp, MMX\Super\Shop\App::NAMESPACE));

$_tmp = [
    'some-setting' => 'Какая-то настройка',
    'some-setting_desc' => 'Описание какой-то настройки',
];
$_lang = array_merge($_lang, MMX\Super\Shop\App::prepareLexicon($_tmp, 'setting_' . MMX\Super\Shop\App::NAMESPACE));

unset($_tmp);