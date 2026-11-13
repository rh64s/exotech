<template>
    <footer>
        <div class="footer_content">
            <div class="footer__top">
                <div class="footer__brand">
                    <span class="footer__logo">ЭКЗО</span>
                    <span class="footer__tagline">
                        Технология под ваше движение.
                    </span>
                </div>

                <nav class="footer__nav" aria-label="Подвал">
                    <a href="#">Конфигуратор</a>
                    <a href="#">Каталог</a>
                    <a href="#">О проекте</a>
                </nav>
            </div>

            <div class="footer__bottom">
                <span>© 2026 ЭКЗО</span>
                <a href="#">Политика конфиденциальности</a>
            </div>
        </div>
    </footer>
</template>

<style scoped>
footer {
    width: 100%;
    min-height: 0;
    background-color: transparent;
    color: var(--color-second);
}

.footer_content {
    position: relative;
    padding: 32px 64px 24px;
}

.footer_content::before {
    position: absolute;
    top: 0;
    right: 64px;
    left: 64px;
    height: 1px;
    background-color: var(--color-disabled);
    content: '';
}

.footer__top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 32px;
    margin-bottom: 40px;
}

.footer__brand {
    display: flex;
    align-items: baseline;
    gap: 12px;
}

.footer__logo {
    color: var(--color-primary);
    font-family: 'Manrope', 'Arial';
    font-size: 3.2rem;
    font-weight: 700;
    line-height: 4.2rem;
}

.footer__tagline {
    color: var(--color-second);
    font-size: 1.4rem;
    line-height: 1.8rem;
}

.footer__nav {
    display: flex;
    flex-wrap: wrap;
    gap: 40px;
}

.footer__nav a {
    color: var(--color-primary);
    font-family: 'Manrope', 'Arial';
    font-size: 1.4rem;
    font-weight: 500;
    line-height: 1.8rem;
    text-decoration: none;
    transition: color 0.2s ease;
}

.footer__nav a:hover {
    color: var(--color-accent);
}

.footer__bottom {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 24px;
    color: var(--color-second);
    font-size: 1.2rem;
    line-height: 1.6rem;
}

.footer__bottom a {
    color: var(--color-second);
    text-decoration: none;
    transition: color 0.2s ease;
}

.footer__bottom a:hover {
    color: var(--color-accent);
}

@media (max-width: 768px) {
    .footer_content {
        padding: 24px;
    }

    .footer_content::before {
        right: 24px;
        left: 24px;
    }

    .footer__top {
        flex-direction: column;
        align-items: flex-start;
        margin-bottom: 24px;
    }

    .footer__nav {
        gap: 24px;
    }

    .footer__bottom {
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
    }
}
</style>
