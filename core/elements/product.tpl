
<div class="row">
    <div id="mmx-gallery" class="col col-md-6">
        {foreach $product.product_files as $file}
            <a href="/mmx-super-shop/image/{$file.file.id}" class="glightbox">
                <img src="/mmx-super-shop/image/{$file.file.id}?w=100" alt="" />
            </a>
        {/foreach}
    </div>
    <div class="col col-md-6">
        {$product | print}
    </div>
</div>