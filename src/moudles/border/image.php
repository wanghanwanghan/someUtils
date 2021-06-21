<?php

namespace wanghanwanghan\someUtils\moudles\border;

class image
{
    public $img;
    public $width = 0;
    public $height = 0;

    function gray($r, $g, $b): int
    {
        return 0.3 * $r + 0.59 * $g + 0.11 * $b;
    }

    function setImg($src): image
    {
        $data = file_get_contents($src);
        $this->img = imagecreatefromstring($data);
        $img_info = getimagesizefromstring($data);
        $this->width = intval($img_info[0]);
        $this->height = intval($img_info[1]);

        return $this;
    }

    function save($src = null): void
    {
        if ($src) {
            imagejpeg($this->img, $src, 90);
        } else {
            header('Content-Type: image/jpeg');
            imagejpeg($this->img);
        }
    }

    function getRgb($x, $y): array
    {
        $rgb = imagecolorat($this->img, $x, $y);
        return [
            ($rgb >> 16) & 0xFF,
            ($rgb >> 8) & 0xFF,
            $rgb & 0xFF,
        ];
    }

    function scale($w, $h): image
    {
        if ($this->width <= $w && $this->height <= $h) {
            return $this;
        }
        if ($this->width / $w > $this->height / $h) {
            $nw = $w;
            $nh = $w * $this->height / $this->width;
        } else {
            $nh = $h;
            $nw = $h * $this->width / $this->height;
        }
        $img = imagecreatetruecolor($nw, $nh);
        imagecopyresampled($img, $this->img, 0, 0, 0, 0, $nw, $nh, $this->width, $this->height);
        $this->img = $img;
        $this->width = intval($nw);
        $this->height = intval($nh);
        return $this;
    }

    function outline(): image
    {
        //创建一个黑色图像
        $new_img = imagecreatetruecolor($this->width, $this->height);

        $mx = $this->width;

        $my = $this->height;

        for ($x = 0; $x < $mx; $x++) {
            for ($y = 0; $y < $my; $y++) {
                $h1 = $this->gray(...$this->getRgb($x, $y));
                $h2 = $this->gray(...$this->getRgb($x + 1 >= $mx ? $x : $x + 1, $y));
                $h3 = $this->gray(...$this->getRgb($x, $y + 1 >= $my ? $y : $y + 1));
                $v = max(abs($h1 - $h2), abs($h1 - $h3));
                if ($v > 23) {
                    $c = 255;
                } else if ($v > 12) {
                    $c = 128;
                } else {
                    $c = 0;
                }
                $color = imageColorAllocate($this->img, $c, $c, $c);
                imagesetpixel($new_img, $x, $y, $color);
            }
        }

        $this->img = $new_img;

        return $this;
    }
}

//$img_path = '1.jpg';
//$img = new \OneImg\Border();
//$img->setImg($img_path)
//    ->scale(300, 300)
//    ->outline()
//    ->save(); //输出到浏览器
