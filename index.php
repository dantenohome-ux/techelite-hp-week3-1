<?php
$page_title       = 'ダミー歯科クリニック｜通いたくなる、やさしい歯医者さん';
$page_description = 'ダミー歯科クリニックは、一般歯科・予防歯科・審美歯科を中心に、痛みの少ない治療とていねいなカウンセリングを心がける歯科医院です。';

// include ではなく require を使う（読み込めなければページとして成立しないため）
// __DIR__ はこのファイルがあるディレクトリ。基準を固定してパスのずれを防ぐ
require __DIR__ . '/includes/header.php';
?>

        <!-- ============================= 2. ヒーロー ============================= -->
        <section class="hero">
            <div class="hero__inner container">
                <p class="hero__eyebrow">DUMMY DENTAL CLINIC</p>
                <h1 class="hero__title">通いたくなる、<br>やさしい歯医者さん。</h1>
                <p class="hero__lead">
                    痛みの少ない治療と、納得できるまでのカウンセリング。<br>
                    お子さまからご年配の方まで、地域のみなさまのお口の健康を支えます。
                </p>
                <a class="button button--primary button--lg hero__cta" href="contact.php">初診のご予約</a>
            </div>
        </section>

        <!-- ============================= 3. 診療内容 ============================= -->
        <section class="services section" id="services">
            <div class="container">
                <h2 class="section__title">診療内容</h2>
                <p class="section__lead">
                    保険診療から自由診療まで、一人ひとりのお口の状態に合わせた治療をご提案します。
                </p>

                <!-- タブ切替（切替は js/main.js が制御）                              -->
                <!-- JSが動かない場合は3つのパネルがそのまま縦に並び、内容はすべて読めます -->
                <div class="services__tabs" id="serviceTabs">

                    <div class="services__tablist" role="tablist" aria-label="診療内容の切り替え">
                        <button class="services__tab is-active" id="tab-general" type="button" role="tab"
                                aria-selected="true" aria-controls="panel-general">一般歯科</button>
                        <button class="services__tab" id="tab-prevention" type="button" role="tab"
                                aria-selected="false" aria-controls="panel-prevention">予防・クリーニング</button>
                        <button class="services__tab" id="tab-esthetic" type="button" role="tab"
                                aria-selected="false" aria-controls="panel-esthetic">審美・ホワイトニング</button>
                    </div>

                    <!-- パネル1：一般歯科 -->
                    <div class="services__panel is-active" id="panel-general" role="tabpanel"
                         aria-labelledby="tab-general" tabindex="0">
                        <ul class="services__list">
                            <li class="services__item">
                                <article class="card">
                                    <img class="card__thumb" src="img/service-01.jpg" alt="一般歯科の診療風景" width="800" height="600">
                                    <div class="card__body">
                                        <h3 class="card__title">一般歯科</h3>
                                        <p class="card__text">
                                            むし歯・歯周病の治療を中心に、できるだけ歯を削らず・抜かない治療を心がけています。
                                            治療前には必ず内容と費用をご説明します。
                                        </p>
                                    </div>
                                </article>
                            </li>

                            <li class="services__item">
                                <article class="card">
                                    <img class="card__thumb" src="img/service-04.jpg" alt="診療台で治療を受けるお子さん" width="800" height="600">
                                    <div class="card__body">
                                        <h3 class="card__title">小児歯科</h3>
                                        <p class="card__text">
                                            まずは歯医者さんに慣れることから。お子さまの年齢や性格に合わせて、
                                            無理に押さえつけない、少しずつ進める治療を大切にしています。
                                        </p>
                                    </div>
                                </article>
                            </li>
                        </ul>
                    </div>

                    <!-- パネル2：予防・クリーニング -->
                    <div class="services__panel" id="panel-prevention" role="tabpanel"
                         aria-labelledby="tab-prevention" tabindex="0">
                        <ul class="services__list">
                            <li class="services__item">
                                <article class="card">
                                    <img class="card__thumb" src="img/service-02.jpg" alt="歯のクリーニングを受ける患者さん" width="800" height="600">
                                    <div class="card__body">
                                        <h3 class="card__title">予防・クリーニング</h3>
                                        <p class="card__text">
                                            歯科衛生士による定期的なクリーニングとブラッシング指導で、
                                            「治す」から「守る」へ。3〜6か月ごとの検診をおすすめしています。
                                        </p>
                                    </div>
                                </article>
                            </li>

                            <li class="services__item">
                                <article class="card">
                                    <img class="card__thumb" src="img/service-05.jpg" alt="口腔内カメラでお口の中を確認する様子" width="800" height="600">
                                    <div class="card__body">
                                        <h3 class="card__title">定期検診・フッ素塗布</h3>
                                        <p class="card__text">
                                            初期のむし歯や歯周病は、痛みなどの自覚症状がほとんどありません。
                                            検診で早めに見つけ、フッ素塗布で歯そのものを強くしていきます。
                                        </p>
                                    </div>
                                </article>
                            </li>
                        </ul>
                    </div>

                    <!-- パネル3：審美・ホワイトニング -->
                    <div class="services__panel" id="panel-esthetic" role="tabpanel"
                         aria-labelledby="tab-esthetic" tabindex="0">
                        <ul class="services__list">
                            <li class="services__item">
                                <article class="card">
                                    <img class="card__thumb" src="img/service-03.jpg" alt="ホワイトニング後の白い歯" width="800" height="600">
                                    <div class="card__body">
                                        <h3 class="card__title">審美・ホワイトニング</h3>
                                        <p class="card__text">
                                            白く自然な見た目を目指すセラミック治療やホワイトニング。
                                            ご希望とご予算をうかがいながら、無理のないプランをご提案します。
                                        </p>
                                    </div>
                                </article>
                            </li>

                            <li class="services__item">
                                <article class="card">
                                    <img class="card__thumb" src="img/service-06.jpg" alt="セラミックの詰め物のサンプル" width="800" height="600">
                                    <div class="card__body">
                                        <h3 class="card__title">セラミック治療</h3>
                                        <p class="card__text">
                                            銀歯の見た目が気になる方へ。天然の歯に近い色味と質感のセラミックで、
                                            白さと噛み心地の両立を目指します。素材ごとの特徴と費用をくらべてお選びいただけます。
                                        </p>
                                    </div>
                                </article>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
        </section>

        <!-- ============================= 4. クリニック概要（抜粋） ============================= -->
        <!-- くわしい情報は about.php にまとめてあります -->
        <section class="overview section section--light" id="overview">
            <div class="container">
                <h2 class="section__title">クリニック概要</h2>
                <p class="section__lead">
                    駅から徒歩3分。土曜も18時まで診療しています。
                </p>

                <dl class="overview__list">
                    <dt class="overview__term">所在地</dt>
                    <dd class="overview__desc">〒000-0000　東京都渋谷区〇〇1-2-3　サンプルビル2F</dd>

                    <dt class="overview__term">診療時間</dt>
                    <dd class="overview__desc">
                        平日 9:30〜13:00 / 14:30〜19:00<br>
                        土曜 9:30〜13:00 / 14:30〜18:00
                    </dd>

                    <dt class="overview__term">休診日</dt>
                    <dd class="overview__desc">日曜・祝日</dd>
                </dl>

                <p class="section__action">
                    <a class="button button--outline" href="about.php">会社概要をくわしく見る</a>
                </p>
            </div>
        </section>

        <!-- ============================= 5. よくある質問（アコーディオン） ============================= -->
        <section class="faq section" id="faq">
            <div class="container">
                <h2 class="section__title">よくある質問</h2>
                <p class="section__lead">
                    ご来院前によくいただくご質問をまとめました。<br>
                    ここにないことは、お電話でお気軽におたずねください。
                </p>

                <dl class="faq__list">
                    <div class="faq__item">
                        <dt class="faq__term">
                            <button class="faq__question" type="button" aria-expanded="false" aria-controls="faq-answer-01">
                                <span class="faq__question-text">予約は必要ですか？</span>
                                <i class="fa-solid fa-chevron-down faq__icon" aria-hidden="true"></i>
                            </button>
                        </dt>
                        <dd class="faq__answer" id="faq-answer-01">
                            <div class="faq__answer-inner">
                                ご予約なしでも診察は可能ですが、お待ちいただく時間が長くなることがあります。
                                お電話またはメールでご予約いただくとスムーズにご案内できます。
                                痛みが強いなどお急ぎの場合は、その旨をお伝えください。
                            </div>
                        </dd>
                    </div>

                    <div class="faq__item">
                        <dt class="faq__term">
                            <button class="faq__question" type="button" aria-expanded="false" aria-controls="faq-answer-02">
                                <span class="faq__question-text">保険は使えますか？</span>
                                <i class="fa-solid fa-chevron-down faq__icon" aria-hidden="true"></i>
                            </button>
                        </dt>
                        <dd class="faq__answer" id="faq-answer-02">
                            <div class="faq__answer-inner">
                                むし歯・歯周病の治療をはじめ、多くの診療は健康保険が適用されます。
                                ホワイトニングやセラミック治療などの自由診療は保険適用外となりますが、
                                治療を始める前に必ず費用をご説明しますのでご安心ください。
                                初診時は保険証をお持ちください。
                            </div>
                        </dd>
                    </div>

                    <div class="faq__item">
                        <dt class="faq__term">
                            <button class="faq__question" type="button" aria-expanded="false" aria-controls="faq-answer-03">
                                <span class="faq__question-text">支払い方法は何が使えますか？</span>
                                <i class="fa-solid fa-chevron-down faq__icon" aria-hidden="true"></i>
                            </button>
                        </dt>
                        <dd class="faq__answer" id="faq-answer-03">
                            <div class="faq__answer-inner">
                                現金のほか、各種クレジットカード・電子マネー・QRコード決済がご利用いただけます。
                                自由診療については分割でのお支払いにも対応しておりますので、
                                ご希望の方は受付までご相談ください。
                            </div>
                        </dd>
                    </div>

                    <div class="faq__item">
                        <dt class="faq__term">
                            <button class="faq__question" type="button" aria-expanded="false" aria-controls="faq-answer-04">
                                <span class="faq__question-text">子どもを連れて行っても大丈夫ですか？</span>
                                <i class="fa-solid fa-chevron-down faq__icon" aria-hidden="true"></i>
                            </button>
                        </dt>
                        <dd class="faq__answer" id="faq-answer-04">
                            <div class="faq__answer-inner">
                                はい、お子さま連れでのご来院も歓迎しています。
                                キッズスペースをご用意しているほか、ベビーカーのまま入れるバリアフリー設計です。
                                保護者の方が治療を受けている間、スタッフがお子さまをお預かりすることもできます。
                            </div>
                        </dd>
                    </div>

                    <div class="faq__item">
                        <dt class="faq__term">
                            <button class="faq__question" type="button" aria-expanded="false" aria-controls="faq-answer-05">
                                <span class="faq__question-text">駐車場はありますか？</span>
                                <i class="fa-solid fa-chevron-down faq__icon" aria-hidden="true"></i>
                            </button>
                        </dt>
                        <dd class="faq__answer" id="faq-answer-05">
                            <div class="faq__answer-inner">
                                提携駐車場を3台分ご用意しています。
                                受付で駐車券をご提示いただくと、治療時間に応じて無料サービス券をお渡しします。
                                満車の場合は近隣のコインパーキングをご案内いたします。
                            </div>
                        </dd>
                    </div>
                </dl>
            </div>
        </section>

        <!-- ============================= 6. お問い合わせ導線 ============================= -->
        <!-- 入力フォームそのものは contact.php にあります -->
        <section class="contact section" id="contact">
            <div class="container">
                <h2 class="section__title">お問い合わせ</h2>
                <p class="section__lead">
                    ご予約・ご相談はお電話またはメールで承ります。<br>
                    「相談だけ」でもお気軽にどうぞ。
                </p>

                <div class="contact__methods">
                    <div class="contact__method">
                        <p class="contact__label">
                            <i class="fa-solid fa-phone contact__icon" aria-hidden="true"></i>お電話でのご予約
                        </p>
                        <a class="contact__link contact__link--tel" href="tel:0312345678">03-1234-5678</a>
                        <p class="contact__note">受付時間：平日 9:30〜19:00／土曜 9:30〜18:00</p>
                    </div>

                    <div class="contact__method">
                        <p class="contact__label">
                            <i class="fa-solid fa-envelope contact__icon" aria-hidden="true"></i>メールでのお問い合わせ
                        </p>
                        <a class="contact__link contact__link--mail" href="mailto:info@dummy-dental.example.com">info@dummy-dental.example.com</a>
                        <p class="contact__note">2営業日以内にご返信いたします</p>
                    </div>
                </div>

                <p class="section__action">
                    <a class="button button--primary button--lg" href="contact.php">フォームでお問い合わせ</a>
                </p>
            </div>
        </section>

<?php require __DIR__ . '/includes/footer.php'; ?>
