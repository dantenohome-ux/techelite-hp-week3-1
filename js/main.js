/* =============================================================
   ダミー歯科クリニック / main.js
   構成：1.ハンバーガーメニュー 2.ヘッダーのスクロール演出 3.診療内容タブ
         4.FAQアコーディオン 5.スクロールでのフェードイン
         6.トップへ戻る 7.フォームバリデーション
   ============================================================= */
(function () {
    'use strict';

    /* =============================================================
       1. SPハンバーガーメニュー
       ============================================================= */
    function initHamburger() {
        var hamburger = document.getElementById('hamburger');
        var nav = document.getElementById('global-nav');

        if (!hamburger || !nav) return;

        var mqPc = window.matchMedia('(min-width: 768px)');

        function openNav() {
            hamburger.classList.add('is-open');
            nav.classList.add('is-open');
            document.body.classList.add('is-nav-open');
            hamburger.setAttribute('aria-expanded', 'true');
            hamburger.setAttribute('aria-label', 'メニューを閉じる');
        }

        function closeNav() {
            hamburger.classList.remove('is-open');
            nav.classList.remove('is-open');
            document.body.classList.remove('is-nav-open');
            hamburger.setAttribute('aria-expanded', 'false');
            hamburger.setAttribute('aria-label', 'メニューを開く');
        }

        function isOpen() {
            return nav.classList.contains('is-open');
        }

        // ボタンで開閉
        hamburger.addEventListener('click', function () {
            if (isOpen()) {
                closeNav();
            } else {
                openNav();
            }
        });

        // ナビ内のリンクを押したら閉じる（イベント委譲で1つだけリスナーを持つ）
        nav.addEventListener('click', function (event) {
            if (event.target.closest('.header__link')) {
                closeNav();
            }
        });

        // Escキーで閉じる
        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && isOpen()) {
                closeNav();
                hamburger.focus();
            }
        });

        // PC幅になったら開きっぱなしを解除（resize連打より軽い）
        mqPc.addEventListener('change', function (event) {
            if (event.matches) closeNav();
        });
    }


    /* =============================================================
       2. ヘッダーのスクロール演出（背景・影）
       ============================================================= */
    function initHeaderScroll() {
        var header = document.querySelector('.header');

        if (!header) return;

        var CHANGE_POSITION = 10;   // 状態を切り替えるスクロール量(px)
        var ticking = false;        // 描画1フレームにつき1回だけ判定するためのフラグ

        function update() {
            header.classList.toggle('is-scrolled', window.scrollY > CHANGE_POSITION);
            ticking = false;
        }

        window.addEventListener('scroll', function () {
            if (ticking) return;
            ticking = true;
            window.requestAnimationFrame(update);
        }, { passive: true });

        // リロード時にページ途中にいても正しい表示になるよう初期判定しておく
        update();
    }


    /* =============================================================
       3. 診療内容のタブ切替
       ============================================================= */
    function initServiceTabs() {
        var tabs = document.getElementById('serviceTabs');

        if (!tabs) return;

        var tablist = tabs.querySelector('.services__tablist');
        var buttons = Array.prototype.slice.call(tabs.querySelectorAll('.services__tab'));

        if (!tablist || buttons.length === 0) return;

        // JSが動いたときだけタブUIにする（無効な環境では全パネルが並んだまま読める）
        tabs.classList.add('is-tabbed');

        function select(tab, moveFocus) {
            buttons.forEach(function (button) {
                var panel = document.getElementById(button.getAttribute('aria-controls'));
                var isActive = button === tab;

                button.classList.toggle('is-active', isActive);
                button.setAttribute('aria-selected', isActive ? 'true' : 'false');
                // 選択中のタブだけTabキーで拾わせ、タブ間は矢印キーで移動させる作法
                button.tabIndex = isActive ? 0 : -1;

                if (panel) panel.classList.toggle('is-active', isActive);
            });

            if (moveFocus) tab.focus();
        }

        // イベント委譲：タブリストに1つだけリスナーを付ける
        tablist.addEventListener('click', function (event) {
            var tab = event.target.closest('.services__tab');
            if (!tab || tab.classList.contains('is-active')) return;

            select(tab, false);
        });

        // 矢印キー／Home／Endでタブを移動する
        tablist.addEventListener('keydown', function (event) {
            var current = buttons.indexOf(document.activeElement);
            if (current === -1) return;

            var next;

            if (event.key === 'ArrowRight') {
                next = (current + 1) % buttons.length;          // 端まで来たら先頭へ戻る
            } else if (event.key === 'ArrowLeft') {
                next = (current - 1 + buttons.length) % buttons.length;
            } else if (event.key === 'Home') {
                next = 0;
            } else if (event.key === 'End') {
                next = buttons.length - 1;
            } else {
                return;
            }

            event.preventDefault();   // 矢印キーでのページスクロールを止める
            select(buttons[next], true);
        });

        // HTMLの初期状態（is-active）にaria属性とtabindexを揃えておく
        select(tabs.querySelector('.services__tab.is-active') || buttons[0], false);
    }


    /* =============================================================
       4. FAQアコーディオン
       ============================================================= */
    function initFaq() {
        var list = document.querySelector('.faq__list');

        if (!list) return;

        function open(item, question, answer) {
            item.classList.add('is-open');
            question.setAttribute('aria-expanded', 'true');
            // 回答文の長さに関わらず開ききるよう、実測値を入れる
            answer.style.maxHeight = answer.scrollHeight + 'px';
        }

        function close(item, question, answer) {
            item.classList.remove('is-open');
            question.setAttribute('aria-expanded', 'false');
            answer.style.maxHeight = '';   // CSSの max-height: 0 に戻す
        }

        // イベント委譲：リストに1つだけリスナーを付ける
        list.addEventListener('click', function (event) {
            var question = event.target.closest('.faq__question');
            if (!question) return;

            var item = question.closest('.faq__item');
            var answer = document.getElementById(question.getAttribute('aria-controls'));
            if (!item || !answer) return;

            if (item.classList.contains('is-open')) {
                close(item, question, answer);
            } else {
                open(item, question, answer);
            }
        });

        // リサイズで文字の折り返し行数が変わると高さが足りなくなるので再計算
        var resizeTimer = null;
        window.addEventListener('resize', function () {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function () {
                var openItems = list.querySelectorAll('.faq__item.is-open .faq__answer');
                Array.prototype.forEach.call(openItems, function (answer) {
                    // 一度解除してから測り直さないと、古い値が上限になってしまう
                    answer.style.maxHeight = 'none';
                    var height = answer.scrollHeight;
                    answer.style.maxHeight = height + 'px';
                });
            }, 200);
        });
    }


    /* =============================================================
       5. スクロールでのフェードイン
       ============================================================= */
    function initScrollReveal() {
        // 出現させる対象。同じ親を持つ要素どうしは順番に少し遅らせて出す
        var SELECTORS = [
            '.section__title',
            '.section__lead',
            '.services__item',
            '.overview__list',
            '.faq__item',
            '.contact__method',
            '.contact__form-title',
            '.form'
        ];
        var MAX_DELAY_STEP = 3;   // CSS側に用意した .fade-up--delay-3 まで

        var prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        // 非対応ブラウザやアニメを控える設定では、クラスを付けず最初から表示のままにする
        if (!('IntersectionObserver' in window) || prefersReducedMotion) return;

        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (!entry.isIntersecting) return;

                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);   // 一度出したら監視をやめる
            });
        }, {
            threshold: .15,
            rootMargin: '0px 0px -40px'   // 画面下ぎりぎりでは出さず、少し入ってから動かす
        });

        SELECTORS.forEach(function (selector) {
            var elements = document.querySelectorAll(selector);
            var lastParent = null;
            var indexInGroup = 0;

            Array.prototype.forEach.call(elements, function (element) {
                // 親が変わったら別グループとみなして遅延をリセットする
                // （タブのパネルごと・FAQのリストごとに 0 から数え直す）
                if (element.parentNode !== lastParent) {
                    lastParent = element.parentNode;
                    indexInGroup = 0;
                }

                var delayStep = Math.min(indexInGroup, MAX_DELAY_STEP);

                element.classList.add('fade-up');
                if (delayStep > 0) {
                    element.classList.add('fade-up--delay-' + delayStep);
                }

                observer.observe(element);
                indexInGroup++;
            });
        });
    }


    /* =============================================================
       6. トップへ戻るボタン
       ============================================================= */
    function initToTop() {
        var button = document.getElementById('toTop');

        if (!button) return;

        var SHOW_POSITION = 300;   // 表示を切り替えるスクロール量(px)
        var ticking = false;       // 描画1フレームにつき1回だけ判定するためのフラグ

        function update() {
            button.classList.toggle('is-visible', window.scrollY > SHOW_POSITION);
            ticking = false;
        }

        window.addEventListener('scroll', function () {
            if (ticking) return;
            ticking = true;
            window.requestAnimationFrame(update);
        }, { passive: true });

        button.addEventListener('click', function () {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        // リロード時にページ途中にいても正しい表示になるよう初期判定しておく
        update();
    }


    /* =============================================================
       7. お問い合わせフォームのバリデーション
       ============================================================= */
    function initContactForm() {
        var form = document.getElementById('contactForm');
        var result = document.getElementById('formResult');

        if (!form) return;

        // 入力内容の確認画面は confirm.php が担当する。
        // ここでの役割は「入力中に誤りへ気づいてもらう」ことだけで、
        // 送信してよいかどうかの最終判断はサーバー側（includes/form.php）が行う

        // RFC完全準拠は狙わない。厳しすぎる正規表現で正当なアドレスを弾く方が実害が大きい。
        // ただし a@a.a のような組み立てを通さないよう、次の3点は見る：
        //   ・@の前後がドットで始まったり終わったりせず、ドットも連続しない
        //   ・ドメインの各ラベルは英数字で始まり英数字で終わる（ハイフンは途中だけ）
        //   ・最後は英字2文字以上のトップレベルドメイン（.jp / .com など）
        var EMAIL_PATTERN = /^[^\s@.]+(\.[^\s@.]+)*@[A-Za-z0-9]([A-Za-z0-9-]*[A-Za-z0-9])?(\.[A-Za-z0-9]([A-Za-z0-9-]*[A-Za-z0-9])?)*\.[A-Za-z]{2,}$/;

        // 電話番号は「0で始まる3つの数字の組をハイフンで区切る」（03-1234-5678）か、
        // 「ハイフン無しで続ける」（0312345678）かの2通り。
        // 数字とハイフンが並んでいるだけの判定だと 0-0-0000000000 も通ってしまうため、
        // この形に加えて桁数も checkTel() で確かめる
        var TEL_PATTERN = /^0\d{1,3}-\d{1,4}-\d{4}$|^0\d{9,10}$/;
        var TEL_MESSAGE = '電話番号は市外局番から半角数字で入力してください（例：03-1234-5678）';

        var MAX_MESSAGE_LENGTH = 1000;

        // 電話番号だけは形と桁数の2段階で見るので、専用の判定関数にする。
        // 問題なければ空文字を返す（他の項目のエラー文と同じ扱いにするため）
        function checkTel(value) {
            // ハイフンを除いて10桁（固定電話）か11桁（携帯・IP電話）
            var digitCount = value.replace(/\D/g, '').length;

            if (!TEL_PATTERN.test(value) || digitCount < 10 || digitCount > 11) {
                return TEL_MESSAGE;
            }

            return '';
        }

        // 検証ルール（項目を増やすときはここに1行足すだけで済む形にしている）
        var rules = [
            {
                name: 'name',
                label: 'お名前',
                required: true
            },
            {
                name: 'email',
                label: 'メールアドレス',
                required: true,
                pattern: EMAIL_PATTERN,
                patternMessage: 'メールアドレスの形式が正しくありません'
            },
            {
                name: 'tel',
                label: '電話番号',
                required: false,   // 任意項目：未入力なら形式チェックもしない
                check: checkTel    // 正規表現1つでは足りないので専用の判定関数を使う
            },
            {
                name: 'message',
                label: 'お問い合わせ内容',
                required: true,
                maxLength: MAX_MESSAGE_LENGTH,
                maxLengthMessage: 'お問い合わせ内容は' + MAX_MESSAGE_LENGTH + '文字以内でご入力ください'
            }
        ];

        // 1項目を検証してエラー文言を返す（問題なければ空文字）
        function validateField(rule) {
            var field = form.elements[rule.name];
            var value = field.value.trim();

            if (rule.required && value === '') {
                return rule.label + 'を入力してください';
            }

            if (rule.maxLength && value.length > rule.maxLength) {
                return rule.maxLengthMessage;
            }

            // 任意項目が空のときは形式チェックをスキップする
            if (value !== '' && rule.pattern && !rule.pattern.test(value)) {
                return rule.patternMessage;
            }

            // 正規表現ひとつでは判定しきれない項目は専用の関数に任せる
            if (value !== '' && rule.check) {
                return rule.check(value);
            }

            return '';
        }

        function showError(rule, message) {
            var field = form.elements[rule.name];
            var errorBox = document.getElementById('error-' + rule.name);

            field.classList.add('is-error');
            field.classList.remove('is-valid');
            field.setAttribute('aria-invalid', 'true');
            errorBox.textContent = message;
            errorBox.classList.add('is-visible');
        }

        function clearError(rule) {
            var field = form.elements[rule.name];
            var errorBox = document.getElementById('error-' + rule.name);

            field.classList.remove('is-error');
            field.removeAttribute('aria-invalid');
            errorBox.textContent = '';
            errorBox.classList.remove('is-visible');
        }

        // お問い合わせ内容の文字数カウンタ
        function initMessageCounter() {
            var field = form.elements.message;
            var counter = document.getElementById('counter-message');

            if (!field || !counter) return;

            function update() {
                var length = field.value.length;

                counter.textContent = length + ' / ' + MAX_MESSAGE_LENGTH;
                counter.classList.toggle('is-error', length > MAX_MESSAGE_LENGTH);
            }

            field.addEventListener('input', update);
            update();   // 確認画面から戻って値が復元されている場合に備えて初期表示も合わせる
        }

        // 検証して結果を画面に反映する。エラーがなければ true
        function applyValidation(rule) {
            var field = form.elements[rule.name];
            var message = validateField(rule);

            if (message) {
                showError(rule, message);
                return false;
            }

            clearError(rule);
            // 何か入力されているときだけチェックを出す（空欄の任意項目に緑チェックは付けない）
            field.classList.toggle('is-valid', field.value.trim() !== '');
            return true;
        }

        function setResult(message, isError) {
            if (!result) return;
            result.textContent = message;
            result.classList.toggle('is-error', Boolean(isError));
        }

        initMessageCounter();

        // ---- 各項目のリアルタイム検証 ----
        rules.forEach(function (rule) {
            var field = form.elements[rule.name];
            if (!field) return;

            // 入力欄から離れたタイミングで検証する
            field.addEventListener('blur', function () {
                applyValidation(rule);
            });

            // 入力中はいきなり赤くしない。すでにエラーの項目だけ、直った瞬間に赤を消す
            field.addEventListener('input', function () {
                if (field.classList.contains('is-error')) {
                    applyValidation(rule);
                }
            });
        });

        // ---- 送信時のまとめ検証 ----
        // 誤りがあるときだけ送信を止める。
        // 問題がなければ preventDefault せず、そのまま confirm.php へ送信させる
        form.addEventListener('submit', function (event) {
            var firstInvalid = null;

            rules.forEach(function (rule) {
                if (!applyValidation(rule) && !firstInvalid) {
                    firstInvalid = form.elements[rule.name];
                }
            });

            if (firstInvalid) {
                event.preventDefault();
                setResult('入力内容に誤りがあります。赤色の項目をご確認ください。', true);
                firstInvalid.focus();
            }
        });
    }


    /* =============================================================
       初期化
       ============================================================= */
    initHamburger();
    initHeaderScroll();
    initServiceTabs();
    initFaq();
    initScrollReveal();
    initToTop();
    initContactForm();
})();
