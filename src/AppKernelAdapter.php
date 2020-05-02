<?php

declare(strict_types=1);

namespace App;

use App\Kernel as ApplicationKernel;
use Drift\HttpKernel\AsyncKernel;
use Drift\Server\Adapter\KernelAdapter;
use Drift\Server\Watcher\ObservableKernel;

/**
 * Class AppKernelAdapter.
 */
class AppKernelAdapter implements KernelAdapter, ObservableKernel
{
    /**
     * Build AsyncKernel.
     */
    public static function buildKernel(
        string $environment,
        bool $debug
    ): AsyncKernel {
        return new ApplicationKernel($environment, $debug);
    }

    /**
     * Get static folder by kernel.
     *
     * @return string|null
     */
    public static function getStaticFolder(): ? string
    {
        return '/public';
    }

    /**
     * Get watcher folders.
     *
     * @return string[]
     */
    public static function getObservableFolders(): array
    {
        return ['config', 'src', 'public'];
    }

    /**
     * Get watcher folders.
     *
     * @return string[]
     */
    public static function getObservableExtensions(): array
    {
        return ['php', 'yml', 'yaml', 'xml', 'css', 'js', 'html', 'twig'];
    }

    /**
     * Get watcher ignoring folders.
     *
     * @return string[]
     */
    public static function getIgnorableFolders(): array
    {
        return [];
    }
}
