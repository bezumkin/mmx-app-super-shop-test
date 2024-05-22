<?php
use MMX\Super\Shop\Models\Category;

/** @var \MODX\Revolution\modX $modx */
/** @var array $scriptProperties */
/** @var \MMX\Super\Shop\App $app */

$tpl = $modx->getOption('tpl', $scriptProperties, 'tplCategories');
$app = $modx->services->get('mmxSuperShop');
$fenom = $app->fenom;

$categories = Category::query()
    ->where('active', true)
    ->orderBy('rank')
    ->get()
    ->toArray();

return $fenom->render($tpl, ['categories' => $categories]);