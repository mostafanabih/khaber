<?php

namespace App\Helpers;

use Stichoza\GoogleTranslate\GoogleTranslate;

class TranslationHelper
{
    public static function translateText($text, $from = 'auto', $to = 'en')
    {
        $translator = new GoogleTranslate();
        $translator->setSource($from);
        $translator->setTarget($to);
        return $translator->translate($text);
    }
}