<?php
use Illuminate\Database\Eloquent\Relations\HasMany;
use MMX\Super\Shop\Models\Product;

/** @var \MODX\Revolution\modX $modx */
/** @var array $scriptProperties */
/** @var \MMX\Super\Shop\App $app */

$id = $modx->getOption('id', $scriptProperties, '');
$tpl = $modx->getOption('tpl', $scriptProperties, 'tplProducts');
$app = $modx->services->get('mmxSuperShop');
$fenom = $app->fenom;

$app::registerAssets($modx);
// var_dump($modx->getRegisteredClientScripts());die;

$product = Product::query()
    ->where('active', true)
    ->with(['productFiles' => static function(HasMany $c) {
        $c->select('product_id', 'file_id');
        $c->where('active', true);
        $c->orderBy('rank');
        $c->with('file:id,uuid,updated_at');
    }])
    ->find($id);
if ($product) {
    return $fenom->render($tpl, ['product' => $product->toArray()]);
}

return '';