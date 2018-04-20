<?php

namespace common\helpers;

class Formater {
    const DATE_FORMAT_INPUT = 'php:Y-m-d';
    const DATETIME_FORMAT_INPUT = 'php:Y-m-d H:i:s';
    const TIME_FORMAT_INPUT = 'php:H:i:s';
    
    const DATE_FORMAT_OUTPUT = 'dd.MM.yyyy';
    const DATETIME_FORMAT_OUTPUT = 'dd.MM.yyyy H:i:s';
    const TIME_FORMAT_OUTPUT = 'H:i:s';

    public static function convertInput($dateStr, $type='date', $format = null) {
        if ($type === 'datetime') {
              $fmt = ($format == null) ? self::DATETIME_FORMAT_INPUT : $format;
        }
        elseif ($type === 'time') {
              $fmt = ($format == null) ? self::TIME_FORMAT_INPUT : $format;
        }
        else {
              $fmt = ($format == null) ? self::DATE_FORMAT_INPUT : $format;
        }
        if ($dateStr) {
            return \Yii::$app->formatter->asDate($dateStr, $fmt);
        } else {
            return $dateStr;
        }
    }

    public static function convertOutput($dateStr, $type='date', $format = null) {
        if ($type === 'datetime') {
              $fmt = ($format == null) ? self::DATETIME_FORMAT_OUTPUT : $format;
        }
        elseif ($type === 'time') {
              $fmt = ($format == null) ? self::DATE_FORMAT_OUTPUT : $format;
        }
        else {
              $fmt = ($format == null) ? self::DATE_FORMAT_OUTPUT : $format;
        }
        if ($dateStr) {
            return \Yii::$app->formatter->asDate($dateStr, $fmt);
        } else {
            return $dateStr;
        }
    }

}