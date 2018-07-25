<?php


namespace app\components;

use yii\base\Behavior;


class Translit extends Behavior
{
    public function translit($str, $fix_umlauts = false)
    {
        mb_regex_set_options('pd');
        mb_internal_encoding('UTF-8');

        $arr = array("/", "«", "»", "№");
        $str = str_replace($arr, "", $str);

        if (strtolower(mb_detect_encoding($str,
                'utf-8, windows-1251')) == 'windows-1251'
        ) {
            $str = mb_convert_encoding($str, 'utf-8', 'windows-1251');
        }

        $regexp1 = '(?=[A-Z0-9А-Я])';
        $regexp2 = '(?<=[A-Z0-9А-Я])';

        $rus = array(
            '/(Ё' . $regexp1 . ')|(' . $regexp2 . 'Ё)/u',
            '/(Ж' . $regexp1 . ')|(' . $regexp2 . 'Ж)/u',
            '/(Ч' . $regexp1 . ')|(' . $regexp2 . 'Ч)/u',
            '/(Ш' . $regexp1 . ')|(' . $regexp2 . 'Ш)/u',
            '/(Щ' . $regexp1 . ')|(' . $regexp2 . 'Щ)/u',
            '/(Ю' . $regexp1 . ')|(' . $regexp2 . 'Ю)/u',
            '/(Я' . $regexp1 . ')|(' . $regexp2 . 'Я)/u'
        );

        $eng = array(
            'YO', 'ZH', 'CH', 'SH', 'SCH', 'YU', 'YA'
        );

        $str = preg_replace($rus, $eng, $str);

        // Массивы для замены одиночных заглавных и строчных букв
        $rus = array(
            '/а/u', '/б/u', '/в/u', '/г/u', '/д/u', '/е/u', '/ё/u',
            '/ж/u', '/з/u', '/и/u', '/й/u', '/к/u', '/л/u', '/м/u',
            '/н/u', '/о/u', '/п/u', '/р/u', '/с/u', '/т/u', '/у/u',
            '/ф/u', '/х/u', '/ц/u', '/ч/u', '/ш/u', '/щ/u', '/ъ/u',
            '/ы/u', '/ь/u', '/э/u', '/ю/u', '/я/u',

            '/А/u', '/Б/u', '/В/u', '/Г/u', '/Д/u', '/Е/u', '/Ё/u',
            '/Ж/u', '/З/u', '/И/u', '/Й/u', '/К/u', '/Л/u', '/М/u',
            '/Н/u', '/О/u', '/П/u', '/Р/u', '/С/u', '/Т/u', '/У/u',
            '/Ф/u', '/Х/u', '/Ц/u', '/Ч/u', '/Ш/u', '/Щ/u', '/Ъ/u',
            '/Ы/u', '/Ь/u', '/Э/u', '/Ю/u', '/Я/u'
        );

        $eng = array(
            'a', 'b', 'v', 'g', 'd', 'e', 'yo',
            'zh', 'z', 'i', 'y', 'k', 'l', 'm',
            'n', 'o', 'p', 'r', 's', 't', 'u',
            'f', 'h', 'c', 'ch', 'sh', 'sch', '',
            'i', '', 'e', 'yu', 'ya',

            'A', 'B', 'V', 'G', 'D', 'E', 'Yo',
            'Zh', 'Z', 'I', 'Y', 'K', 'L', 'M',
            'N', 'O', 'P', 'R', 'S', 'T', 'U',
            'F', 'H', 'C', 'Ch', 'Sh', 'Sch', '',
            'I', '', 'E', 'Yu', 'Ya'
        );

        $str = preg_replace($rus, $eng, $str);
        $str = str_replace(['-', '–', '—', ',', ':', '\''], "", $str);
        $str = str_replace(" ", "-", $str); // заменяем пробелы знаком минус


        if ($fix_umlauts) {
            $str = preg_replace('/&(.)(tilde|uml);/', "$1",
                mb_convert_encoding($str, 'HTML-ENTITIES', 'utf-8'));
        }

        return $str;
    }

}