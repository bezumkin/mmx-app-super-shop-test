<?php

namespace MMX\Super\Shop\Console;

use MMX\Super\Shop\App;
use MMX\Super\Shop\Console\Command\FileTest;
use MMX\Super\Shop\Console\Command\Install;
use MMX\Super\Shop\Console\Command\Remove;
use MODX\Revolution\modX;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\ListCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Console extends Application
{
    protected modX $modx;
    protected App $app;

    public function __construct(modX $modx)
    {
        parent::__construct(App::NAME);
        $this->modx = $modx;
        $this->app = new App($modx);
    }

    public function doRun(InputInterface $input, OutputInterface $output)
    {
        if (!$this->modx->services->has('mmxDatabase')) {
            try {
                new \MMX\Database\App($this->modx);
                $install = new \MMX\Database\Console\Command\Install($this->modx);
                $output->writeln('<info>Trying to install mmx/database...</info>');
                $install->run($input, $output);
            } catch (\Throwable $e) {
                $output->writeln('<error>Could not load mmxDatabase service</error>');
                $output->writeln('<info>Please run "composer exec mmx-database install"</info>');
                exit;
            }
        }
        if (!$this->modx->services->has('mmxFenom')) {
            try {
                new \MMX\Fenom\App($this->modx);
                $install = new \MMX\Fenom\Console\Command\Install($this->modx);
                $output->writeln('<info>Trying to install mmx/fenom...</info>');
                $install->run($input, $output);
            } catch (\Throwable $e) {
                $output->writeln('<error>Could not load mmxFenom service</error>');
                $output->writeln('<info>Please run "composer exec mmx-fenom install"</info>');
                exit;
            }
        }

        return parent::doRun($input, $output);
    }

    protected function getDefaultCommands(): array
    {
        return [
            new ListCommand(),
            new Install($this->modx),
            new Remove($this->modx),
            new FileTest($this->modx),
        ];
    }
}
