<?php

namespace app\traits;

trait DateConverter
{
    public function convert($date): string
    {
        if (!$date = date_create($date)) {
            return '';
        }
        return $date->format('Y.m.d H:i:s');
    }
}
