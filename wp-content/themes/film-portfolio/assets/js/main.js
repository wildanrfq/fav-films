/**
 * Film Portfolio JavaScript
 * Handles client-side sorting and full review expansion.
 */

document.addEventListener('DOMContentLoaded', function () {
  const filmsGrid = document.getElementById('filmsGrid');
  const filterBtns = document.querySelectorAll('.filter-btn');

  // Expand / Collapse Review
  document.querySelectorAll('.read-more-btn').forEach(btn => {
    btn.addEventListener('click', function () {
      const card = this.closest('.film-card');
      if (!card) return;

      const isExpanded = card.classList.toggle('expanded');
      const textSpan = this.querySelector('span');
      if (textSpan) {
        textSpan.textContent = isExpanded ? 'Close Review' : 'Read Full Review';
      }
    });
  });

  // Client-side Sorting
  filterBtns.forEach(btn => {
    btn.addEventListener('click', function () {
      filterBtns.forEach(b => b.classList.remove('active'));
      this.classList.add('active');

      const sortMode = this.dataset.sort;
      if (!filmsGrid) return;

      const cards = Array.from(filmsGrid.children);

      if (sortMode === 'rating') {
        cards.sort((a, b) => {
          const ratingA = parseFloat(a.dataset.rating) || 0;
          const ratingB = parseFloat(b.dataset.rating) || 0;
          return ratingB - ratingA;
        });
      } else if (sortMode === 'watch') {
        cards.sort((a, b) => {
          const watchA = parseInt(a.dataset.watch) || 0;
          const watchB = parseInt(b.dataset.watch) || 0;
          return watchB - watchA;
        });
      } else {
        // Default order (original menu_order)
        cards.sort((a, b) => {
          const orderA = parseInt(a.dataset.order) || 0;
          const orderB = parseInt(b.dataset.order) || 0;
          return orderA - orderB;
        });
      }

      // Re-append in sorted order with a subtle fade
      filmsGrid.style.opacity = '0.5';
      setTimeout(() => {
        cards.forEach(card => filmsGrid.appendChild(card));
        filmsGrid.style.opacity = '1';
      }, 150);
    });
  });
});
