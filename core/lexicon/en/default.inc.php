<?php

$_tmp = [
    'menu_name' => 'mmxSuperShop',
    'menu_desc' => 'Template for creating a new mmx application',
    'actions' => [
        'create' => 'Create',
        'edit' => 'Edit',
        'submit' => 'Submit',
        'cancel' => 'Cancel',
        'delete' => 'Delete',
    ],
    'models' => [
        'category' => [
            'title_one' => 'Category',
            'title_many' => 'Categories',
            'id' => 'Id',
            'title' => 'Title',
            'alias' => 'Alias',
            'active' => 'Active',
            'rank' => 'Rank',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ],
        'product' => [
            'title_one' => 'Product',
            'title_many' => 'Products',
            'id' => 'Id',
            'title' => 'Title',
            'alias' => 'Alias',
            'active' => 'Active',
            'rank' => 'Rank',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'gallery' => 'Gallery',
        ],
    ],
    'components' => [
        'no_data' => 'Nothing to display',
        'no_results' => 'Nothing found',
        'records' => 'No records | 1 record | {total} records',
        'query' => 'Search...',
        'delete' => [
            'title' => 'Confirmation required',
            'confirm' => 'Are you sure you want to delete this entry?',
        ],
    ],
    'snippets' => [
        'nocss' => 'Do not load frontend styles',
    ],
    'errors' => [
        'item' => [
            'title_unique' => 'The item title must be unique.',
        ],
        'gallery' => [
            'wrong_type' => 'Please select image!',
        ],
    ],
];

/** @var array $_lang */
$_lang = array_merge($_lang, MMX\Super\Shop\App::prepareLexicon($_tmp, MMX\Super\Shop\App::NAMESPACE));

$_tmp = [
    'some-setting' => 'Setting title',
    'some-setting_desc' => 'Some setting description',
];
$_lang = array_merge($_lang, MMX\Super\Shop\App::prepareLexicon($_tmp, 'setting_' . MMX\Super\Shop\App::NAMESPACE));

unset($_tmp);