<?php

use yii\helpers\Url;
?>

<main class="movie-page container">
    <div class="breadcrumbs">Главная <span>/</span> Каталог <span>/</span> Французский вестник</div>
    <div class="movie-detail-grid">
        <div class="detail-left">
            <div class="detail-poster"><img src="<?= Url::to("@web/images/movie-francuzskij-detail.jpeg") ?>" alt="Французский вестник"><span class="hit-label">ХИТ</span><button class="save-button" aria-label="Добавить в избранное"><i class="fa-regular fa-heart" aria-hidden="true"></i></button></div>
            <section class="detail-tabs">
                <div class="tab-list" role="tablist"><button class="tab is-active" role="tab" aria-selected="true" aria-controls="description-panel" data-tab="description-panel">Описание</button><button class="tab" role="tab" aria-selected="false" aria-controls="reviews-panel" data-tab="reviews-panel">Отзывы</button></div>
                <div class="tab-panel is-active" id="description-panel" role="tabpanel">
                    <h2>О фильме</h2>
                    <p>В небольшом французском городе журналисты готовят последний выпуск любимого журнала. На его страницах оживают истории о художниках, заключённых, студентках и небесном похищении.</p>
                    <p>Ироничное и визуально безупречное кино Уэса Андерсона — для вечера, когда хочется рассматривать каждый кадр и обсуждать детали после титров.</p>
                    <dl>
                        <div>
                            <dt>Режиссёр</dt>
                            <dd>Уэс Андерсон</dd>
                        </div>
                        <div>
                            <dt>Страна</dt>
                            <dd>США, Германия</dd>
                        </div>
                        <div>
                            <dt>В ролях</dt>
                            <dd>Билл Мюррей, Тильда Суинтон, Тимоти Шаламе, Фрэнсис Макдорманд</dd>
                        </div>
                    </dl>
                </div>
                <div class="tab-panel" id="reviews-panel" role="tabpanel" hidden>
                    <h2>Отзывы</h2>
                    <div class="review-item"><b><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i></b>
                        <p>«Очень красивое и уютное кино. Каждый кадр хочется поставить на заставку.В»</p><small>Алина, 2 дня назад</small>
                    </div>
                    <div class="review-item"><b><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-regular fa-star" aria-hidden="true"></i></b>
                        <p>«Отличный выбор для спокойного вечера.В»</p><small>Михаил, неделю назад</small>
                    </div>
                </div>
            </section>
        </div>
        <aside class="movie-summary">
            <span class="eyebrow">ВАШ ВЕЧЕР НАЧИНАЕТСЯ ЗДЕСЬ</span>
            <h1>Французский<br class="desktop-only"> вестник</h1>
            <p class="movie-meta">2021&nbsp; В· &nbsp;1 ч 48 мин&nbsp; В· &nbsp;18+</p>
            <div class="movie-tags"><span>Комедия</span><span>Драма</span></div>
            <div class="detail-rating"><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i> <strong>4.9</strong> <small>В· 125 оценок</small></div>
            <p class="summary-copy">Три истории из жизни редакции американского журнала в вымышленном французском городе. Признание в любви журналистике, искусству и людям с причудами.</p>
            <button class="button button-primary vote-button" onclick="window.location.href='votes'" data-movie="Французский вестник">Оценить</button>
            <button class="button button-secondary watched-button">Отметить как просмотренное</button>
            <div class="community-votes"><b>Голосов сообщества: 45</b><span class="vote-bar"><i></i></span><small>Выбираем вместе, что смотреть сегодня.</small></div>
        </aside>
    </div>
</main>