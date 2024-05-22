{foreach $categories as $category}
    <p>
        {$category.id} <a href="/shop/{$category.alias}">{$category.title}</a>
    </p>
{/foreach}