<?php

namespace wanghanwanghan\someUtils\utils;

class img
{
    //比例计算图片宽高
    public static function calculateDimensions($width,$height,$maxWidth,$maxHeight)
    {
        if ($width != $height)
        {
            if ($width > $height)
            {
                $tWidth = $maxWidth;
                $tHeight = (($tWidth * $height)/$width);

                //fix height
                if ($tHeight > $maxHeight)
                {
                    $tHeight = $maxHeight;
                    $tWidth = (($width * $tHeight)/$height);
                }

            }else
            {
                $tHeight = $maxHeight;
                $tWidth = (($width * $tHeight)/$height);

                //fix width
                if ($tWidth > $maxWidth)
                {
                    $tWidth = $maxWidth;
                    $tHeight = (($tWidth * $height)/$width);
                }
            }

        }else
        {
            $tWidth = $tHeight = min($maxHeight, $maxWidth);
        }

        return ['height'=>(int)$tHeight,'width'=>(int)$tWidth];
    }
}
