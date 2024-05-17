<?php

namespace MMX\Super\Shop\Console\Command;


use GuzzleHttp\Client;
use MMX\Super\Shop\Models\File;
use MMX\Super\Shop\Models\Product;
use MODX\Revolution\modX;
use Slim\Psr7\Stream;
use Slim\Psr7\UploadedFile;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FileTest extends Command
{
    protected static $defaultName = 'file-test';
    protected static $defaultDescription = 'Test file uploading to products';
    protected modX $modx;

    protected const IMAGE = 'https://placehold.co/600x400.png';

    public function __construct(modX $modx, ?string $name = null)
    {
        parent::__construct($name);
        $this->modx = $modx;
    }

    public function run(InputInterface $input, OutputInterface $output): void
    {
        /** @var Product $product */
        $product = Product::query()->first();
        if (!$product) {
            $output->writeln('<error>Could not find any products!</error>');
            exit(1);
        }

        $client = new Client();
        $response = $client->get(self::IMAGE);
        if ($response->getStatusCode() === 200) {
            $tmp = tempnam(MODX_CORE_PATH . 'cache/', 'mmx_');
            file_put_contents($tmp, (string)$response->getBody());

            $stream = new Stream(fopen($tmp, 'rb'));
            $data = new UploadedFile(
                $stream,
                basename(self::IMAGE),
                mime_content_type($tmp),
                filesize($tmp)
            );

            $file = new File();
            $file->uploadFile($data);
            unlink($tmp);

            $product->productFiles()->create(['file_id' => $file->id]);
        }


        // $output->writeln('<info>Hello World!</info>');

    }
}