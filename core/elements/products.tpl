{foreach $products as $product}
    <p>
        {if $product.file}
            <img src="/mmx-super-shop/image/{$product.file.id}?w=100" alt="" />
        {/if}
        {$product.id} <a href="/shop/{$product.uri}">{$product.title}</a>
    </p>
{/foreach}