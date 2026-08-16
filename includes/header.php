<?php
/* =============================================================
   共通ヘッダー（<!DOCTYPE> 〜 <main> の開始タグまで）

   使い方：各ページの先頭で $page_title / $page_description を
   設定してから require する。設定しなければトップページの値になる。

       <?php
       $page_title = '会社概要｜ダミー歯科クリニック';
       require __DIR__ . '/includes/header.php';
       ?>
   ============================================================= */

// h()（出力用エスケープ）などの共通関数。
// contact.php などは includes/form.php 経由ですでに読み込み済みだが、
// require_once なので二重に読み込まれることはない
require_once __DIR__ . '/functions.php';

// ?? は「左辺が未定義または null なら右辺を使う」演算子（null合体演算子）
$page_title       = $page_title       ?? 'ダミー歯科クリニック｜通いたくなる、やさしい歯医者さん';
$page_description = $page_description ?? 'ダミー歯科クリニックは、一般歯科・予防歯科・審美歯科を中心に、痛みの少ない治療とていねいなカウンセリングを心がける歯科医院です。';

// 表示中のファイル名（例：about.php）。ナビの現在地判定とog:urlに使う
$current_page = basename($_SERVER['PHP_SELF']);

// OGP用のURL（ドメインはダミー）。トップページだけファイル名を付けない
$page_url = 'https://dummy-dental.example.com/' . ($current_page === 'index.php' ? '' : $current_page);

/* ---- ナビゲーション定義 ----
   サイト内のリンクはここ1箇所だけ。ページを増やすときはこの配列に1行足す。
   footer.php のサイトマップもこの $nav_items を使い回す。

   current：そのページを開いているとき現在地として印を付けるファイル名の一覧。
            「診療内容」はトップページ内のリンクなので空にしてある
            （トップで「ホーム」と2つ同時に印が付いてしまうのを避けるため）。 */
$nav_items = [
    ['href' => 'index.php',          'label' => 'ホーム',       'current' => ['index.php']],
    ['href' => 'index.php#services', 'label' => '診療内容',     'current' => []],
    ['href' => 'about.php',          'label' => '会社概要',     'current' => ['about.php']],
    ['href' => 'contact.php',        'label' => 'コンタクト', 'current' => ['contact.php', 'confirm.php', 'thanks.php']],
];
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo h($page_title); ?></title>
    <meta name="description" content="<?php echo h($page_description); ?>">

    <!-- ファビコン（画像は img/ に後から配置してください） -->
    <link rel="icon" href="img/favicon.png" type="image/png" sizes="32x32">
    <link rel="icon" href="img/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="img/apple-touch-icon.png">

    <!-- OGP（SNSシェア時のカード表示用。URL・画像はダミーです） -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="ダミー歯科クリニック">
    <meta property="og:title" content="<?php echo h($page_title); ?>">
    <meta property="og:description" content="<?php echo h($page_description); ?>">
    <meta property="og:url" content="<?php echo h($page_url); ?>">
    <meta property="og:image" content="https://dummy-dental.example.com/img/ogp.jpg">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="ダミー歯科クリニックの外観">
    <meta property="og:locale" content="ja_JP">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo h($page_title); ?>">
    <meta name="twitter:description" content="<?php echo h($page_description); ?>">
    <meta name="twitter:image" content="https://dummy-dental.example.com/img/ogp.jpg">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Font Awesome Free（アイコンライブラリ／CSSのみ・JS不要） -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <!-- ============================= 1. ヘッダー（固定70px） ============================= -->
    <header class="header">
        <div class="header__inner container">
            <a class="header__logo" href="index.php">
                <img class="header__logo-img" src="img/logo.svg" alt="ダミー歯科クリニック" width="180" height="40">
            </a>

            <nav class="header__nav" id="global-nav" aria-label="メインナビゲーション">
                <ul class="header__menu">
                    <?php foreach ($nav_items as $item): ?>
                        <?php $is_current = in_array($current_page, $item['current'], true); ?>
                        <li class="header__item">
                            <a class="header__link<?php echo $is_current ? ' is-current' : ''; ?>"
                               href="<?php echo h($item['href']); ?>"
                               <?php echo $is_current ? 'aria-current="page"' : ''; ?>><?php echo h($item['label']); ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </nav>

            <!-- SP用ハンバーガー（開閉は js/main.js が制御） -->
            <button class="header__hamburger" id="hamburger" type="button" aria-label="メニューを開く" aria-expanded="false" aria-controls="global-nav">
                <span class="header__hamburger-line"></span>
                <span class="header__hamburger-line"></span>
                <span class="header__hamburger-line"></span>
            </button>
        </div>
    </header>

    <main id="top">
