<?php

// デバイス判定
$agent = getUserAgent();

if ($agent === 'pc') {
    if (file_exists('pc.html')) {
        $html = file_get_contents('pc.html');
    } else {
        if (file_exists('sp.html')) {
            $html = file_get_contents('sp.html');
        }
    }
} else {
    if (file_exists('sp.html')) {
        $html = file_get_contents('sp.html');
    } else {
        if (file_exists('pc.html')) {
            $html = file_get_contents('pc.html');
        }
    }
}

echo $html;
exit();

function getUserAgent()
{
    //ユーザーエージェントの取得
    $ua = $_SERVER['HTTP_USER_AGENT'];

    //スマホ（iPhone、Android、WindowsPhone）
    if ((strpos($ua, 'Android') !== false) &&
        (strpos($ua, 'Mobile') !== false) ||
        (strpos($ua, 'iPhone') !== false) ||
        (strpos($ua, 'Windows Phone') !== false)) {
        return "sp";
    } elseif ((strpos($ua, 'Android') !== false) ||
        (strpos($ua, 'iPad') !== false)) {
        return 'tablet';
    } else {
        return "pc";
    }
}
