<?php

namespace core;

class Utils
{
    public static function timecomp($a, $b)
    {
        return  strtotime($b['date']) - strtotime($a['date']);
    }

    public static function toShortTime($timeLong): string
    {
        $date = new \DateTime($timeLong);
        $time = $date->diff(new \DateTime());
        $temp = '';
        if ($time->days + $time->h + $time->i == 0)
            $temp = "$time->s second";
        elseif ($time->days + $time->h == 0)
            $temp = "$time->i minute";
        elseif ($time->days == 0)
            $temp = "$time->h hour";
        elseif ($time->y + $time->m == 0)
            $temp = "$time->d day";
        elseif ($time->y == 0)
            $temp = "$time->d month";
        else
            $temp = "$time->y year";

        if (intval(explode(' ', $temp)[0]) != 1)
            $temp .= 's';
        $temp .= ' ago';

        return $temp;
    }

    public static function deleteParams($arr, $params): array
    {
        for ($i = 0; $i < count($arr); $i++) {
            foreach ($params as $param)
                unset($arr[$i][$param]);
        }
        return $arr;
    }
}