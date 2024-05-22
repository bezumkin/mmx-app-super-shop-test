<?php
use MMX\Super\Shop\Models\Product;

/** @var \MODX\Revolution\modX $modx */
/** @var array $scriptProperties */
/** @var \MMX\Super\Shop\App $app */

$tpl = $modx->getOption('tpl', $scriptProperties, 'tplProducts');
$category = $modx->getOption('category', $scriptProperties, '');
$app = $modx->services->get('mmxSuperShop');
$fenom = $app->fenom;

$c = Product::query()
    ->where('active', true)
    ->with('File:id,uuid,updated_at')
    ->orderBy('rank');
if ($category) {
    $c->where('category_id', $category);
}
$products = $c->get()->toArray();

return $fenom->render($tpl, ['products' => $products]);