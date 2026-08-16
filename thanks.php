<?php
// HTMLより先に読み込む（セッションの開始とリダイレクトのため）
require_once __DIR__ . '/includes/form.php';


/* =============================================================
   1. 送信の処理（confirm.php から POST されたとき）
   ============================================================= */
if (is_post()) {

    // 確認画面を通っていれば、入力値がセッションに残っている。
    // 無い場合（直接POSTされた・時間が経ってセッションが切れた）は入力画面へ戻す
    $input = $_SESSION['contact_input'] ?? null;

    if ($input === null) {
        redirect('contact.php');
    }

    // 念のためここでも検証する。
    // confirm.php を経ずに直接送られてきた場合の保険
    $input  = contact_input($input);
    $errors = contact_validate($input);

    if (!empty($errors)) {
        $_SESSION['contact_errors'] = $errors;
        redirect('contact.php');
    }

    // TODO: ここで実際の送信処理を行う。
    //       メールで送るなら mail()、記録として残すならデータベースへの保存など。
    //       入力値は $input['name'] / ['email'] / ['tel'] / ['message'] に入っている。
    //       ローカルの php -S ではメールを送れないため、今回は未実装のままにしている。

    // 送信済みの内容はもう不要なので捨てる。
    // 残したままだと、次にフォームを開いたとき前回の内容が復元されてしまう
    unset($_SESSION['contact_input']);

    // 完了画面を表示してよい、という印を立てる
    $_SESSION['contact_done'] = true;

    // 自分自身へリダイレクトしてGETに切り替える（PRGパターン：POST→Redirect→Get）。
    // 完了画面をGETで表示しておくと、再読み込みしても
    // ブラウザに「フォームを再送信しますか？」と聞かれない＝二重送信を防げる
    redirect('thanks.php');
}


/* =============================================================
   2. 完了画面の表示（上のリダイレクトで GET されたとき）
   ============================================================= */

// 印が無ければ、送信していないのに完了画面だけ開かれたということなので入力画面へ
if (empty($_SESSION['contact_done'])) {
    redirect('contact.php');
}

// 印は一度きり。読んだら消す（あとから開き直しても完了画面は出ない）
unset($_SESSION['contact_done']);

$page_title       = '送信完了｜ダミー歯科クリニック';
$page_description = 'お問い合わせを承りました。2営業日以内にご返信いたします。';

require __DIR__ . '/includes/header.php';
?>

        <!-- ============================= 送信完了 ============================= -->
        <section class="contact section">
            <div class="container">
                <h1 class="section__title">
                    <i class="fa-solid fa-circle-check" aria-hidden="true"></i>
                    送信が完了しました
                </h1>
                <p class="section__lead">
                    お問い合わせありがとうございます。<br>
                    2営業日以内にご入力のメールアドレスへご返信いたします。
                </p>
                <p class="section__lead">
                    しばらく経っても返信が届かない場合は、
                    お手数ですが <a class="contact__link contact__link--tel" href="tel:0312345678">03-1234-5678</a> までお電話ください。
                </p>

                <p class="section__action">
                    <a class="button button--primary" href="index.php">トップページへ戻る</a>
                </p>
            </div>
        </section>

<?php require __DIR__ . '/includes/footer.php'; ?>
