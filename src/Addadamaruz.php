<?php
  namespace Yeghmorassen\Addadamaruz;

  use Illuminate\Translation\Translator;

  class Addadamaruz extends Translator {

    /**
     * Get the translation for the given key.
     *
     * @param  string  $key
     * @param  array   $replace
     * @param  string|null  $locale
     * @param  bool  $fallback
     * @return string|array
     */
    public function get($key, array $replace = [], $locale = null, $fallback = true)
    {

        [$namespace, $group, $item] = $this->parseKey($key);

        // Here we will get the locale that should be used for the language line. If one
        // was not passed, we will use the default locales which was given to us when
        // the translator was instantiated. Then, we can load the lines and return.
        $locales = $fallback ? $this->localeArray($locale)
                             : [$locale ?: $this->locale];
        
        foreach ($locales as $locale) {
            if (! is_null($line = $this->getLine(
                $namespace, $group, $locale, $item, $replace
            ))) {
                break;
            }
        }

        // If the line doesn't exist, we will return back the key which was requested as
        // that will be quick to spot in the UI if language keys are wrong or missing
        // from the application's language files. Otherwise we can return the line.
        if (isset($line)) {
            return $line;
        }

        return $key;
    }

  }
