<?php

namespace wanghanwanghan\someUtils\utils;

class img
{
    //比例计算图片宽高
    static function calculateDimensions($width, $height, $maxWidth, $maxHeight)
    {
        if ($width != $height) {
            if ($width > $height) {
                $tWidth = $maxWidth;
                $tHeight = (($tWidth * $height) / $width);

                //fix height
                if ($tHeight > $maxHeight) {
                    $tHeight = $maxHeight;
                    $tWidth = (($width * $tHeight) / $height);
                }
            } else {
                $tHeight = $maxHeight;
                $tWidth = (($width * $tHeight) / $height);

                //fix width
                if ($tWidth > $maxWidth) {
                    $tWidth = $maxWidth;
                    $tHeight = (($tWidth * $height) / $width);
                }
            }
        } else {
            $tWidth = $tHeight = min($maxHeight, $maxWidth);
        }

        return ['height' => (int)$tHeight, 'width' => (int)$tWidth];
    }

    //图片转base64编码
    static function img2Base64($img_file, $needPrefix = false)
    {
        $img_base64 = '';

        if (file_exists($img_file)) {
            $app_img_file = $img_file; // 图片路径

            $img_info = getimagesize($app_img_file); // 取得图片的大小，类型等

            $fp = fopen($app_img_file, 'r'); // 图片是否可读权限

            if ($fp) {
                $fileSize = filesize($app_img_file);
                $content = fread($fp, $fileSize);
                $file_content = chunk_split(base64_encode($content)); // base64编码
                switch ($img_info[2]) {   //判读图片类型
                    case 1:
                        $img_type = 'gif';
                        break;
                    case 2:
                        $img_type = 'jpg';
                        break;
                    case 3:
                        $img_type = 'png';
                        break;
                }

                $needPrefix ?
                    $img_base64 = 'data:image/' . $img_type . ';base64,' . $file_content :
                    $img_base64 = $file_content;
            }
            fclose($fp);
        }

        return $img_base64; //返回图片的base64
    }

    //点是否在多边形内
    static function inArea(string $lat, string $lng, array $area): bool
    {
        $aLon = sprintf('%.6f', $lng) - 0;
        $aLat = sprintf('%.6f', $lat) - 0;

        $iSum = 0;

        $iCount = count($area);

        foreach ($area as $key => $row) {
            $pLon1 = $row[0];
            $pLat1 = $row[1];
            if ($key === $iCount - 1) {
                $pLon2 = $area[0][0];
                $pLat2 = $area[0][1];
            } else {
                $pLon2 = $area[$key + 1][0];
                $pLat2 = $area[$key + 1][1];
            }
            if ((($aLat >= $pLat1) && ($aLat < $pLat2)) || (($aLat >= $pLat2) && ($aLat < $pLat1))) {
                if (abs($pLat1 - $pLat2) > 0) {
                    $pLon = $pLon1 - (($pLon1 - $pLon2) * ($pLat1 - $aLat)) / ($pLat1 - $pLat2);
                    if ($pLon < $aLon) {
                        $iSum += 1;
                    }
                }
            }
        }

        return $iSum % 2 !== 0;
    }

    //取返色
    static function colorInverse($color): string
    {
        $color = str_replace('#', '', $color);

        $rgb = '#';

        for ($x = 0; $x < 3; $x++) {
            $c = 255 - hexdec(substr($color, (2 * $x), 2));
            $c = ($c < 0) ? 0 : dechex($c);
            $rgb .= (strlen($c) < 2) ? '0' . $c : $c;
        }

        return $rgb;
    }

}
