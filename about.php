<?php
$page_title       = '会社概要｜ダミー歯科クリニック';
$page_description = 'ダミー歯科クリニックの医院名・院長・所在地・アクセス・診療科目・診療時間・設備をご案内します。';

require __DIR__ . '/includes/header.php';
?>

        <!-- ============================= クリニック概要 ============================= -->
        <section class="overview section section--light">
            <div class="container">
                <!-- 各ページの見出しは h1。クラスは既存の .section__title を流用する -->
                <h1 class="section__title">会社概要</h1>
                <p class="section__lead">
                    駅から徒歩3分。土曜も18時まで診療しています。<br>
                    ご不明な点はお気軽におたずねください。
                </p>

                <dl class="overview__list">
                    <dt class="overview__term">医院名</dt>
                    <dd class="overview__desc">ダミー歯科クリニック</dd>

                    <dt class="overview__term">院長</dt>
                    <dd class="overview__desc">歯科 太郎（歯学博士）</dd>

                    <dt class="overview__term">所在地</dt>
                    <dd class="overview__desc">〒000-0000　東京都渋谷区〇〇1-2-3　サンプルビル2F</dd>

                    <dt class="overview__term">アクセス</dt>
                    <dd class="overview__desc">ダミー線「渋谷駅」東口より徒歩3分／提携駐車場3台あり</dd>

                    <dt class="overview__term">診療科目</dt>
                    <dd class="overview__desc">一般歯科／小児歯科／予防歯科／審美歯科／口腔外科</dd>

                    <dt class="overview__term">診療時間</dt>
                    <dd class="overview__desc">
                        平日 9:30〜13:00 / 14:30〜19:00<br>
                        土曜 9:30〜13:00 / 14:30〜18:00
                    </dd>

                    <dt class="overview__term">休診日</dt>
                    <dd class="overview__desc">日曜・祝日</dd>

                    <dt class="overview__term">設備</dt>
                    <dd class="overview__desc">歯科用CT／口腔内カメラ／個室診療室／バリアフリー対応</dd>
                </dl>

                <p class="section__action">
                    <a class="button button--primary" href="contact.php">お問い合わせはこちら</a>
                </p>
            </div>
        </section>

<?php require __DIR__ . '/includes/footer.php'; ?>
