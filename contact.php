<?php
// フォーム共通処理。HTMLより先に読み込むことでセッションを開始する
// （関数の重複定義を避けるため require ではなく require_once を使う）
require_once __DIR__ . '/includes/form.php';

// 前回の入力値。確認画面から「修正する」で戻ったときはここに残っている。
// 何も無ければ全項目が空文字になる（初回表示）
$input = contact_input($_SESSION['contact_input'] ?? []);

// confirm.php が検証で差し戻したエラー。
// 一度表示したら消す（画面を再読み込みしたときに残り続けないように）
$errors = $_SESSION['contact_errors'] ?? [];
unset($_SESSION['contact_errors']);

$page_title       = 'お問い合わせ｜ダミー歯科クリニック';
$page_description = 'ダミー歯科クリニックへのご予約・ご相談はこちらのフォームからお送りください。2営業日以内にご返信いたします。';

require __DIR__ . '/includes/header.php';
?>

        <!-- ============================= お問い合わせフォーム ============================= -->
        <section class="contact section">
            <div class="container">
                <h1 class="section__title">お問い合わせ</h1>
                <p class="section__lead">
                    ご予約・ご相談は下記のフォームからお送りください。2営業日以内にご返信いたします。<br>
                    お急ぎの場合は <a class="contact__link contact__link--tel" href="tel:0312345678">03-1234-5678</a> までお電話ください。
                </p>

                <!-- novalidate：ブラウザ標準のエラー表示を止めて、自前の日本語エラーに一本化する -->
                <!-- 送信先は confirm.php。入力の可否を最終的に決めるのはサーバー側 -->
                <form class="form contact__form" id="contactForm" action="confirm.php" method="post" novalidate>

                    <p class="form__note">
                        <span class="form__required">必須</span> の項目は必ずご入力ください。
                    </p>

                    <!-- ---- お名前 ---- -->
                    <div class="form__group">
                        <label class="form__label" for="form-name">
                            お名前<span class="form__required">必須</span>
                        </label>
                        <input class="form__input<?php echo isset($errors['name']) ? ' is-error' : ''; ?>"
                               type="text" id="form-name" name="name"
                               value="<?php echo h($input['name']); ?>"
                               placeholder="歯科 花子" autocomplete="name" aria-describedby="error-name"
                               <?php echo isset($errors['name']) ? 'aria-invalid="true"' : ''; ?>>
                        <p class="form__error<?php echo isset($errors['name']) ? ' is-visible' : ''; ?>" id="error-name"><?php echo h($errors['name'] ?? ''); ?></p>
                    </div>

                    <!-- ---- メールアドレス ---- -->
                    <div class="form__group">
                        <label class="form__label" for="form-email">
                            メールアドレス<span class="form__required">必須</span>
                        </label>
                        <input class="form__input<?php echo isset($errors['email']) ? ' is-error' : ''; ?>"
                               type="email" id="form-email" name="email"
                               value="<?php echo h($input['email']); ?>"
                               placeholder="example@mail.com" autocomplete="email" aria-describedby="error-email"
                               <?php echo isset($errors['email']) ? 'aria-invalid="true"' : ''; ?>>
                        <p class="form__error<?php echo isset($errors['email']) ? ' is-visible' : ''; ?>" id="error-email"><?php echo h($errors['email'] ?? ''); ?></p>
                    </div>

                    <!-- ---- 電話番号（任意） ---- -->
                    <div class="form__group">
                        <label class="form__label" for="form-tel">
                            電話番号<span class="form__optional">任意</span>
                        </label>
                        <input class="form__input<?php echo isset($errors['tel']) ? ' is-error' : ''; ?>"
                               type="tel" id="form-tel" name="tel"
                               value="<?php echo h($input['tel']); ?>"
                               placeholder="03-1234-5678" autocomplete="tel" aria-describedby="error-tel"
                               <?php echo isset($errors['tel']) ? 'aria-invalid="true"' : ''; ?>>
                        <p class="form__error<?php echo isset($errors['tel']) ? ' is-visible' : ''; ?>" id="error-tel"><?php echo h($errors['tel'] ?? ''); ?></p>
                    </div>

                    <!-- ---- お問い合わせ内容 ---- -->
                    <div class="form__group">
                        <label class="form__label" for="form-message">
                            お問い合わせ内容<span class="form__required">必須</span>
                        </label>
                        <textarea class="form__textarea<?php echo isset($errors['message']) ? ' is-error' : ''; ?>"
                                  id="form-message" name="message" rows="6"
                                  placeholder="ご相談内容やご希望の日時をご記入ください。"
                                  aria-describedby="counter-message error-message"
                                  <?php echo isset($errors['message']) ? 'aria-invalid="true"' : ''; ?>><?php echo h($input['message']); ?></textarea>
                        <!-- 文字数カウンタ（初期値は js/main.js が入力値に合わせて書き換えます） -->
                        <p class="form__counter" id="counter-message">0 / <?php echo MAX_MESSAGE_LENGTH; ?></p>
                        <p class="form__error<?php echo isset($errors['message']) ? ' is-visible' : ''; ?>" id="error-message"><?php echo h($errors['message'] ?? ''); ?></p>
                    </div>

                    <!-- いきなり送信せず、まず confirm.php の確認画面へ進む -->
                    <button class="button button--primary button--lg form__submit" type="submit">入力内容を確認する</button>

                    <!-- 結果メッセージ。ページを開いた時点ではPHPが、入力中は js/main.js が書き込む -->
                    <p class="form__result<?php echo !empty($errors) ? ' is-error' : ''; ?>" id="formResult" role="status" aria-live="polite"><?php
                        echo !empty($errors) ? '入力内容に誤りがあります。赤色の項目をご確認ください。' : '';
                    ?></p>
                </form>
            </div>
        </section>

<?php require __DIR__ . '/includes/footer.php'; ?>
