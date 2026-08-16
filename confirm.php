<?php
// HTMLを1文字も出力する前に読み込む。
// セッションの開始とリダイレクト（header関数）は、
// 出力が始まったあとでは行えないため
require_once __DIR__ . '/includes/form.php';

// POST以外（アドレス欄に直接入力された・ブックマークから来たなど）は
// 表示する内容が無いので入力画面へ戻す
// （redirect() の中で exit しているので、この先へは進まない）
if (!is_post()) {
    redirect('contact.php');
}

// 送られてきた値を定義どおりに取り出す（4項目以外は捨てられる）
$input = contact_input($_POST);

// 「修正する」で入力画面に戻ったときに値を復元できるよう保存しておく
$_SESSION['contact_input'] = $input;

// サーバー側で検証する。
// JavaScriptは切ることができるので、ここを通らずに送信されることはない
$errors = contact_validate($input);

if (!empty($errors)) {
    // 誤りがあれば確認画面は出さず、エラーを持たせて入力画面へ差し戻す
    $_SESSION['contact_errors'] = $errors;
    redirect('contact.php');
}

$page_title       = '入力内容の確認｜ダミー歯科クリニック';
$page_description = 'お問い合わせ内容の確認画面です。';

require __DIR__ . '/includes/header.php';
?>

        <!-- ============================= 入力内容の確認 ============================= -->
        <section class="contact section">
            <div class="container">
                <h1 class="section__title">入力内容の確認</h1>
                <p class="section__lead">
                    まだ送信は完了していません。<br>
                    内容をご確認のうえ「この内容で送信する」を押してください。
                </p>

                <!-- 送信先は thanks.php。値はセッションに預けてあるので送り直さない -->
                <form class="form" action="thanks.php" method="post">
                    <div class="form__confirm">
                        <!-- 項目の並びは CONTACT_FIELDS の定義順。入力欄と同じ順で並ぶ。
                             値は h() を通すので、入力値がHTMLとして解釈されることはない。
                             改行はCSSの white-space: pre-wrap がそのまま見せてくれる -->
                        <dl class="form__confirm-list">
                            <?php foreach (CONTACT_FIELDS as $name => $field): ?>
                                <dt class="form__confirm-term"><?php echo h($field['label']); ?></dt>
                                <?php if ($input[$name] === ''): ?>
                                    <dd class="form__confirm-desc form__confirm-desc--empty">（未入力）</dd>
                                <?php else: ?>
                                    <dd class="form__confirm-desc"><?php echo h($input[$name]); ?></dd>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </dl>

                        <div class="form__actions">
                            <a class="button button--outline" href="contact.php">修正する</a>
                            <button class="button button--primary" type="submit">この内容で送信する</button>
                        </div>
                    </div>
                </form>
            </div>
        </section>

<?php require __DIR__ . '/includes/footer.php'; ?>
