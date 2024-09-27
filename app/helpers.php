<?php
namespace App\Helpers;


if (!function_exists('urlOlustur')) {
    function urlOlustur($string)
    {
        // Türkçe karakterleri İngilizce karşılıklarıyla değiştir
        $turkish = ['ı', 'İ', 'ş', 'Ş', 'ç', 'Ç', 'ğ', 'Ğ', 'ü', 'Ü', 'ö', 'Ö'];
        $english = ['i', 'I', 's', 'S', 'c', 'C', 'g', 'G', 'u', 'U', 'o', 'O'];
        $string = str_replace($turkish, $english, $string);

        // Boşlukları alt çizgi ile değiştir
        $string = str_replace(' ', '_', $string);

        // Diğer istenmeyen karakterleri kaldır
        $string = preg_replace('/[^A-Za-z0-9\-_]/', '', $string);

        return $string;
    }
}

