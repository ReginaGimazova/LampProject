<?php
/**
 * Created by PhpStorm.
 * User: regagim
 * Date: 19.12.18
 * Time: 0:53
 */

namespace App\providers;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\Formatter\MessageFormatter;
use Symfony\Component\Translation\Loader\ArrayLoader;
use Symfony\Component\HttpKernel\EventListener\TranslatorListener;

class TranslationProvider implements ServiceProviderInterface
{

    /**
     * Registers services on the given container.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     *
     * @param Container $pimple A container instance
     */
    public function register(Container $pimple)
    {
        // TODO: Implement register() method.
    }
}