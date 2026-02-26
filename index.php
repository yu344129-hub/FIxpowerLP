<?php
// スマホ・タブレットは sp.html、PCは pc.html を返す

$agent = getUserAgent(); // "sp" / "tablet" / "pc"

// 優先して返したいファイルを決める
$primary = ($agent === 'pc') ? 'pc.html' : 'sp.html';
$fallback = ($primary === 'pc.html') ? 'sp.html' : 'pc.html';

// ファイル読み込み（存在しない場合はフォールバック）
if (file_exists($primary)) {
    $html = file_get_contents($primary);
} elseif (file_exists($fallback)) {
    $html = file_get_contents($fallback);
} else {
    http_response_code(404);
    echo "Not Found";
    exit;
}

echo $html;
exit;

function getUserAgent()
{
    $ua = $_SERVER['HTTP_USER_AGENT'] ?? '';

    // iPadOS 13+ は UA が Mac っぽくなることがあるので、必要なら JS 併用が確実。
    // ここではシンプルにUA文字列ベースで判定。

    // ---- スマホ ----
    if (
        (strpos($ua, 'Android') !== false && strpos($ua, 'Mobile') !== false) ||
        (strpos($ua, 'iPhone') !== false) ||
        (strpos($ua, 'Windows Phone') !== false)
    ) {
        return "sp";
    }

    // ---- タブレット（Androidタブレット / iPad）----
    if (
        (strpos($ua, 'Android') !== false && strpos($ua, 'Mobile') === false) ||
        (strpos($ua, 'iPad') !== false)
    ) {
        return "tablet";
    }

    // ---- PC ----
    return "pc";
}