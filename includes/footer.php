<?php
/* =============================================================
   共通フッター（<main> の閉じタグ 〜 </html>）

   header.php とセットで使う。各ページの最後で require する。

   サイトマップのリンクは header.php で定義した $nav_items を
   そのまま使い回す（リンクの定義をサイト内で1箇所に保つため）。
   ============================================================= */

// h()（出力用エスケープ）を使うため。すでに読み込まれていれば何も起きない
require_once __DIR__ . '/functions.php';

// header.php を通さずに読み込まれた場合でも落ちないようにしておく
$nav_items = $nav_items ?? [];
?>
    </main>

    <!-- ============================= 7. フッター ============================= -->
    <footer class="footer">
        <div class="footer__inner container">

            <!-- 1列目：会社情報 -->
            <div class="footer__col footer__col--info">
                <p class="footer__name">ダミー歯科クリニック</p>
                <p class="footer__address">
                    <i class="fa-solid fa-location-dot footer__icon" aria-hidden="true"></i>〒000-0000　東京都渋谷区〇〇1-2-3　サンプルビル2F
                </p>
                <p class="footer__info">
                    <i class="fa-solid fa-phone footer__icon" aria-hidden="true"></i><a class="footer__link" href="tel:0312345678">03-1234-5678</a>
                </p>
                <p class="footer__info">
                    <i class="fa-solid fa-clock footer__icon" aria-hidden="true"></i>平日 9:30〜19:00 ／ 土曜 9:30〜18:00
                </p>
                <p class="footer__info">
                    <i class="fa-solid fa-calendar-xmark footer__icon" aria-hidden="true"></i>休診日：日曜・祝日
                </p>
            </div>

            <!-- 2列目：サイトマップ（header.php の $nav_items を使い回す） -->
            <nav class="footer__col footer__col--nav" aria-label="サイトマップ">
                <p class="footer__heading">サイトマップ</p>
                <ul class="footer__menu">
                    <?php foreach ($nav_items as $item): ?>
                        <li class="footer__item">
                            <a class="footer__link" href="<?php echo h($item['href']); ?>"><?php echo h($item['label']); ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </nav>

            <!-- 3列目：SNS（Font Awesome のブランドアイコン。リンク先はダミーです） -->
            <div class="footer__col footer__col--sns">
                <p class="footer__heading">SNS</p>
                <ul class="footer__sns">
                    <li class="footer__sns-item">
                        <a class="footer__sns-link" href="https://www.instagram.com/" target="_blank" rel="noopener noreferrer" aria-label="Instagram（新しいタブで開きます）">
                            <i class="fa-brands fa-instagram footer__sns-icon" aria-hidden="true"></i>
                        </a>
                    </li>
                    <li class="footer__sns-item">
                        <a class="footer__sns-link" href="https://x.com/" target="_blank" rel="noopener noreferrer" aria-label="X（旧Twitter・新しいタブで開きます）">
                            <i class="fa-brands fa-x-twitter footer__sns-icon" aria-hidden="true"></i>
                        </a>
                    </li>
                    <li class="footer__sns-item">
                        <a class="footer__sns-link" href="https://line.me/" target="_blank" rel="noopener noreferrer" aria-label="LINE公式アカウント（新しいタブで開きます）">
                            <i class="fa-brands fa-line footer__sns-icon" aria-hidden="true"></i>
                        </a>
                    </li>
                </ul>
            </div>

        </div>

        <div class="footer__bottom container">
            <p class="footer__copyright">&copy; <?php echo date('Y'); ?> Dummy Dental Clinic. All rights reserved.</p>
        </div>
    </footer>

    <!-- ============================= 8. トップへ戻るボタン ============================= -->
    <!-- スクロール量に応じて js/main.js が .is-visible を付け外しします -->
    <button class="to-top" id="toTop" type="button" aria-label="ページの先頭へ戻る">
        <i class="fa-solid fa-chevron-up to-top__icon" aria-hidden="true"></i>
    </button>

    <script src="js/main.js"></script>
</body>
</html>
