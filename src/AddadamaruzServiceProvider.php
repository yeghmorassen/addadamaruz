<?php

namespace Yeghmorassen\Addadamaruz;

use Illuminate\Translation\TranslationServiceProvider;
use Illuminate\Translation\Translator;


class AddadamaruzServiceProvider extends TranslationServiceProvider
{

    public function register()
    {
        $this->registerLoader();

        $this->app->singleton('translator', function ($app) {
            $loader = $app['translation.loader'];
            // When registering the translator component, we'll need to set the default
            // locale as well as the fallback locale. So, we'll grab the application
            // configuration so we can easily get both of these values from there.
            $locale = $app['config']['app.locale'];

            $trans = new Addadamaruz($loader, $locale);

            if($locale !== 'kab'){
              $trans = new Translator($loader, $locale);
            }

            $trans->setFallback($app['config']['app.fallback_locale']);

            return $trans;
        });
      }
}
