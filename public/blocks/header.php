<header>
    <div class="container top-menu">
        <div class="nav">
            <a href="/">Главная</a>
        </div>
        <div class="auth-checkout">
            <?php if($_COOKIE['login'] == ''): ?>
                <a href="/user/auth"><button class="btn">Войти</button></a>
                <a href="/user/reg"><button class="btn">Регистрация</button></a>
            <?php else: ?>
                <a href="/user/dashboard">
                    <button class="btn dashboard">Кабинет пользователя</button>
                </a>
                <a href="/user/edit">
                    <button class="btn dashboard">Редактировать профиль</button>
                </a>
            <?php endif; ?>
        </div>
    </div>

</header>