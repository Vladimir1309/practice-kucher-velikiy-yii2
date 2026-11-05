document.addEventListener('DOMContentLoaded', () => {
  // --- 1. МОБИЛЬНОЕ МЕНЮ ---
  const menuToggle = document.querySelector('.menu-toggle');
  const nav = document.querySelector('.primary-nav');
  menuToggle?.addEventListener('click', () => {
    const expanded = menuToggle.getAttribute('aria-expanded') === 'true';
    menuToggle.setAttribute('aria-expanded', String(!expanded));
    nav.classList.toggle('is-open', !expanded);
  });

  // --- 2. МОДАЛЬНЫЕ ОКНА (ОТКРЫТИЕ/ЗАКРЫТИЕ) ---
  const openModal = (modal) => modal?.classList.add('is-open');
  const closeModal = (modal) => modal?.classList.remove('is-open');
  
  document.querySelectorAll('.modal').forEach((modal) => {
    modal.addEventListener('click', (event) => {
      if (event.target === modal || event.target.closest('.modal-close')) closeModal(modal);
    });
  });
  document.querySelectorAll('.modal-close-action').forEach((button) => {
    button.addEventListener('click', () => closeModal(button.closest('.modal')));
  });
  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
        document.querySelectorAll('.modal.is-open').forEach(closeModal);
        setFiltersOpen?.(false); // Закрываем фильтры по Esc
    }
  });

  // --- 3. КАРТОЧКИ ФИЛЬМОВ И ССЫЛКИ (АДАПТАЦИЯ ПОД YII2) ---
  document.querySelectorAll('.movie-card').forEach((card) => {
    card.addEventListener('click', (event) => {
      if (event.target.closest('button')) return;
      // В Yii2 ссылка будет формироваться через PHP. 
      // Пока оставляем заглушку, но если карточка обернута в <a>, этот JS не нужен.
      // window.location.href = '/site/movie'; 
    });
  });

  document.querySelectorAll('.review-button').forEach((button) => {
    button.addEventListener('click', () => {
      window.location.href = '/site/votes';
    });
  });
  document.querySelector('.vote-button')?.addEventListener('click', () => {
    window.location.href = '/site/votes';
  });

  // --- 4. ИНТЕРАКТИВ (ИЗБРАННОЕ И ПРОСМОТРЕННОЕ) ---
  // Позже сюда добавим AJAX-запросы к Yii2, чтобы сохранять в БД.
  document.querySelectorAll('.save-button').forEach((button) => {
    button.addEventListener('click', () => {
      const active = button.classList.toggle('active');
      const icon = button.querySelector('i');
      icon?.classList.toggle('fa-regular', !active);
      icon?.classList.toggle('fa-solid', active);
    });
  });

  document.querySelector('.watched-button')?.addEventListener('click', (event) => {
    const button = event.currentTarget;
    const watched = button.classList.toggle('watched-active');
    button.textContent = watched ? 'Просмотрено ✓' : 'Отметить как просмотренное';
  });

  // --- 5. ТАБЫ И ЗВЕЗДОЧКИ ---
  document.querySelectorAll('.tab').forEach((tab) => {
    tab.addEventListener('click', () => {
      document.querySelectorAll('.tab').forEach((item) => {
        item.classList.toggle('is-active', item === tab);
        item.setAttribute('aria-selected', String(item === tab));
      });
      document.querySelectorAll('.tab-panel').forEach((panel) => {
        panel.hidden = panel.id !== tab.dataset.tab;
        panel.classList.toggle('is-active', panel.id === tab.dataset.tab);
      });
    });
  });

  document.querySelectorAll('.stars button').forEach((star, index, stars) => {
    star.addEventListener('click', () => stars.forEach((item, itemIndex) => {
      item.style.opacity = itemIndex <= index ? '1' : '.35';
    }));
  });

  document.querySelectorAll('.vote-stars button').forEach((star, index, stars) => {
    star.addEventListener('click', () => stars.forEach((item, itemIndex) => item.classList.toggle('is-selected', itemIndex <= index)));
  });

  // --- 6. ПОКАЗ ПАРОЛЯ ---
  document.querySelectorAll('.password-toggle').forEach((toggle) => {
    toggle.addEventListener('click', () => {
      const input = toggle.parentElement.querySelector('input');
      const visible = input.type === 'text';
      input.type = visible ? 'password' : 'text';
      toggle.textContent = visible ? '◉' : '◎';
    });
  });

  // --- 7. ФИЛЬТРЫ КАТАЛОГА ---
  const filterToggle = document.querySelector('.filter-toggle');
  const filterPanel = document.querySelector('.catalog-filters');
  const filterClose = document.querySelector('.filter-close');
  const setFiltersOpen = (open) => {
    if (!filterPanel || !filterToggle) return;
    filterPanel.classList.toggle('is-open', open);
    filterToggle.setAttribute('aria-expanded', String(open));
  };
  filterToggle?.addEventListener('click', () => setFiltersOpen(!filterPanel.classList.contains('is-open')));
  filterClose?.addEventListener('click', () => setFiltersOpen(false));

  // --- 8. МОДАЛКА ВЫХОДА И "МНЕ ПОВЕЗЕТ" ---
  const logoutModal = document.querySelector('#logout-modal');
  document.querySelector('.logout-button')?.addEventListener('click', () => openModal(logoutModal));

  const cards = [...document.querySelectorAll('.movie-card')];
  const pickRandomMovie = () => {
    const movie = cards[Math.floor(Math.random() * cards.length)];
    if (!movie) return;
    const title = movie.querySelector('h3')?.textContent || movie.dataset.title;
    const resultElement = document.querySelector('.lucky-result');
    if (resultElement) resultElement.textContent = title;
    openModal(document.querySelector('#lucky-modal'));
  };
  document.querySelector('#lucky-button')?.addEventListener('click', pickRandomMovie);
  document.querySelector('#hero-lucky-button')?.addEventListener('click', pickRandomMovie);

  // ВАЖНО: Блоки с event.preventDefault() для форм (логин, регистрация, профиль) УДАЛЕНЫ.
  // Теперь Yii2 берет управление отправкой форм на себя!
});