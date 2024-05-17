<?php
/** @var \MODX\Revolution\modX $modx */

if ($modx->services->has('mmxSuperShop')) {
    /** @var array $scriptProperties */
    return $modx->services->get('mmxSuperShop')->handleSnippet($scriptProperties);
}