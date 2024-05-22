<?php

namespace MMX\Super\Shop;

use DI\Bridge\Slim\Bridge;
use DI\Container;
use Illuminate\Database\Eloquent\Builder;
use MMX\Database\Models\Resource;
use MMX\Super\Shop\Models\Category;
use MMX\Super\Shop\Models\Product;
use MODX\Revolution\modResource;
use MODX\Revolution\modSystemEvent;
use MODX\Revolution\modX;
use Psr\Container\ContainerInterface;
use Slim\Routing\RouteCollectorProxy;

class App
{
    public const NAME = 'mmxSuperShop';
    public const NAMESPACE = 'mmx-super-shop';
    public \MMX\Fenom\App $fenom;

    protected modX $modx;
    protected static ContainerInterface $container;
    protected string $shopRoot = '/shop/';

    public function __construct(modX $modx)
    {
        $this->modx = $modx;

        if (!$this->modx->services->has('mmxDatabase')) {
            $this->modx->log(modX::LOG_LEVEL_ERROR, 'Please install "mmx/database" package to use mmxSuperShop');
        }
        if (!$this->modx->services->has('mmxFenom')) {
            $this->modx->log(modX::LOG_LEVEL_ERROR, 'Please install "mmx/fenom" package to use mmxSuperShop');
        } else {
            $this->fenom = $this->modx->services->get('mmxFenom');
        }

        $container = new Container();
        $container->set(modX::class, $this->modx);
        $container->set('modx', $this->modx);
        static::$container = $container;
    }

    public static function getContainer(): ContainerInterface
    {
        return static::$container;
    }

    public function handleEvent(?modSystemEvent $event): void
    {
        if (!$event) {
            return;
        }

        if ($event->name === 'OnManagerPageInit' && $event->params['namespace'] === $this::NAMESPACE) {
            class_alias(Controllers\Modx\Home::class, '\MODX\Revolution\Controllers\Home');
        }
        if ($event->name === 'OnHandleRequest') {
            if (str_starts_with($_SERVER['REQUEST_URI'], '/' . $this::NAMESPACE)) {
                $this->run();
                exit();
            }

            if (str_starts_with($_SERVER['REQUEST_URI'], $this->shopRoot)) {
                $uri = substr($_SERVER['REQUEST_URI'], strlen($this->shopRoot));
                /** @var Resource $resource */
                /** @var Category $category */
                if ($category = Category::query()->where(['alias' => $uri, 'active' => true])->first()) {
                    $resource = Resource::query()
                        ->whereHas('Parent', function (Builder $c) {
                            $c->where('alias', trim($this->shopRoot, '/'));
                        })
                        ->where('alias', 'category')
                        ->first();

                    if ($resource) {
                        $this->modx->resource = new modResource($this->modx);
                        $this->modx->resource->fromArray($resource->toArray());
                        $this->modx->resource->id = $category->id;
                        $this->modx->resource->pagetitle = $category->title;
                        $this->modx->resource->template = $resource->template;
                        $this->modx->resource->alias = $category->alias;
                        $this->modx->resource->isfolder = true;
                        $this->modx->resource->uri = $this->shopRoot . $category->alias;
                        $this->modx->resource->content = '';

                        if ($this->modx->getResponse()) {
                            $this->modx->response->outputContent();
                        }
                    }
                } elseif ($product = Product::query()->where(['uri' => $uri, 'active' => true])->first()) {
                    /** @var Product $product */
                    $resource = Resource::query()
                        ->whereHas('Parent', function (Builder $c) {
                            $c->where('alias', trim($this->shopRoot, '/'));
                        })
                        ->where('alias', 'product')
                        ->first();
                    if ($resource) {
                        $this->modx->resource = new modResource($this->modx);
                        $this->modx->resource->fromArray($resource->toArray());
                        $this->modx->resource->id = $product->id;
                        $this->modx->resource->pagetitle = $product->title;
                        $this->modx->resource->template = $resource->template;
                        $this->modx->resource->alias = $product->alias;
                        $this->modx->resource->isfolder = true;
                        $this->modx->resource->uri = $this->shopRoot . $product->uri;
                        $this->modx->resource->content = '';

                        if ($this->modx->getResponse()) {
                            $this->modx->response->outputContent();
                        }
                    }
                }
            }
        }
        if ($event->name === 'OnWebPagePrerender') {
            $tpl = $this->compileTemplate($this->modx->resource->_output);
            $this->modx->resource->_output = $tpl->fetch([]);

            if ($parser = $this->modx->getParser()) {
                $parser->processElementTags('', $this->modx->resource->_output, false, false, '[[', ']]', [], 10);
            }

        }
    }

    /*
    public function handleSnippet(array $properties): string
    {
        $keys = array_map('strtolower', array_keys($properties));
        $properties = array_combine($keys, array_values($properties));

        $this::registerAssets($this->modx, !empty($properties['nocss']));
        $locale = $this->modx->context->getOption('cultureKey') ?: 'en';
        $data = [
            'locale' => $locale,
            'lexicon' => $this->getLexicon($locale, ['errors']),
        ];
        $this->modx->regClientHTMLBlock('<script>' . self::NAME . '=' . json_encode($data) . '</script>');

        return '<div id="mmx-super-shop-root"></div>';
    }*/

    public function run(): void
    {
        $app = Bridge::create($this::getContainer());
        $app->addBodyParsingMiddleware();
        $app->addRoutingMiddleware();
        $app->setBasePath('/' . $this::NAMESPACE);
        $this::setRoutes($app);

        try {
            $_SERVER['QUERY_STRING'] = html_entity_decode($_SERVER['QUERY_STRING']);
            $app->run();
        } catch (\Throwable $e) {
            $code = $e->getCode();
            http_response_code(is_numeric($code) ? $code : 500);
            echo json_encode($e->getMessage());
        }
    }

    protected static function setRoutes(\Slim\App $app): void
    {
        $app->get('/image/{id}', Controllers\Image::class);

        $app->group(
            '/mgr',
            static function (RouteCollectorProxy $group) {
                $group->any('/categories[/{id:\d+}]', Controllers\Mgr\Categories::class);
                $group->any('/products[/{id:\d+}]', Controllers\Mgr\Products::class);
                $group->any('/product/{product_id}/files[/{file_id}]', Controllers\Mgr\Product\Files::class);
            }
        )->add(Middlewares\Mgr::class);

        $app->group(
            '/web',
            static function (RouteCollectorProxy $group) {
                // $group->map(['OPTIONS', 'GET'], '/items[/{id:\d+}]', Controllers\Web\Items::class);
            }
        );
    }

    public static function registerAssets($instance, bool $noCss = false): void
    {
        $context = $instance instanceof modX ? 'web' : 'mgr';
        $assets = self::getAssetsFromManifest($context);
        if ($assets) {
            // Production mode
            $jsMethod = $context === 'mgr' ? 'addHtml' : 'regClientHTMLBlock';
            $cssMethod = $context === 'mgr' ? 'addCss' : 'regClientCss';
            foreach ($assets as $file) {
                if (str_ends_with($file, '.js')) {
                    $instance->$jsMethod('<script type="module" src="' . $file . '"></script>');
                } elseif (!$noCss) {
                    $instance->$cssMethod($file);
                }
            }
        } else {
            // Development mode
            $port = getenv('NODE_DEV_PORT') ?: '9090';
            $connection = @fsockopen('node', $port);
            if (@is_resource($connection)) {
                $server = explode(':', MODX_HTTP_HOST);
                $baseUrl = MODX_ASSETS_URL . 'components/' . self::NAMESPACE . '/';
                $vite = MODX_URL_SCHEME . $server[0] . ':' . $port . $baseUrl;
                if ($instance instanceof modX) {
                    $instance->regClientHTMLBlock('<script type="module" src="' . $vite . '@vite/client"></script>');
                    $instance->regClientHTMLBlock('<script type="module" src="' . $vite . 'src/web.ts"></script>');
                } else {
                    $instance->addHtml('<script type="module" src="' . $vite . '@vite/client"></script>');
                    $instance->addHtml('<script type="module" src="' . $vite . 'src/mgr.ts"></script>');
                }
            }
        }
    }

    protected static function getAssetsFromManifest(string $context): ?array
    {
        $script = 'src/' . $context . '.ts';
        $baseUrl = MODX_ASSETS_URL . 'components/' . self::NAMESPACE . '/';
        $manifest = MODX_ASSETS_PATH . 'components/' . self::NAMESPACE . '/manifest.json';

        if (file_exists($manifest) && $files = json_decode(file_get_contents($manifest), true)) {
            $assets = [];
            if (!empty($files[$script])) {
                $file = $files[$script];
                $assets[] = $baseUrl . $file['file'];
                foreach ($file['css'] as $css) {
                    $assets[] = $baseUrl . $css;
                }

                return $assets;
            }
        }

        return null;
    }

    public static function prepareLexicon(array $arr, string $prefix = ''): array
    {
        $out = [];
        foreach ($arr as $k => $v) {
            $key = !$prefix ? $k : "{$prefix}.{$k}";
            if (is_array($v)) {
                $out += self::prepareLexicon($v, $key);
            } else {
                $out[$key] = $v;
            }
        }

        return $out;
    }

    public function getLexicon(string $locale = 'en', $prefixes = []): array
    {
        $namespace = $this::NAMESPACE;
        $this->modx->lexicon->load($locale . ':' . $namespace . ':default');
        $entries = [];

        if ($prefixes) {
            if (!is_array($prefixes)) {
                $prefixes = [$prefixes];
            }
            foreach ($prefixes as $prefix) {
                $entries += $this->modx->lexicon->fetch($namespace . '.' . $prefix);
            }
        } else {
            $entries = $this->modx->lexicon->fetch($namespace);
        }

        $keys = array_map(static function ($key) use ($namespace) {
            return str_replace($namespace . '.', '', $key);
        }, array_keys($entries));

        return array_combine($keys, array_values($entries));
    }

    protected function compileTemplate(string $content): \Fenom\Template
    {
        $name = sha1($content);
        try {
            return $this->fenom->getRawTemplate()->source($name, $content, true);
        } catch (\Throwable $e) {
            $this->modx->log(modX::LOG_LEVEL_ERROR, $e->getMessage());
            $this->modx->log(modX::LOG_LEVEL_INFO, $content);

            return $this->fenom->getRawTemplate()->source($name, '', false);
        }
    }
}