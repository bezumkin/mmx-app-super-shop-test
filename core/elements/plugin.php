<?php
/** @var \MODX\Revolution\modX $modx */

if ($modx->services->has('mmxSuperShop')) {
    $modx->services->get('mmxSuperShop')->handleEvent($modx->event);
}