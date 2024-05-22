<?php
use MMX\Super\Shop\Models\Product;

/** @var \MODX\Revolution\modX $modx */
/** @var array $scriptProperties */
/** @var \MMX\Super\Shop\App $app */

$id = $modx->getOption('id', $scriptProperties, '');
$tpl = $modx->getOption('tpl', $scriptProperties, 'tplProducts');
$app = $modx->services->get('mmxSuperShop');
$fenom = $app->fenom;

$product = Product::query()
    ->where('active', true)
    ->with('File:id,uuid,updated_at')
    ->find($id);
if ($product) {
    return $fenom->render($tpl, ['product' => $product->toArray()]);
}

return '';