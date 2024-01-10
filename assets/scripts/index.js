/* Fade-in animation */

const items = document.querySelectorAll('.hotel-info');

const active = function (entries) {
  entries.forEach((entry) => {
    if (entry.isIntersecting) {
      entry.target.classList.add('inview');
    } else {
      entry.target.classList.remove('inview');
    }
  });
};
const io = new IntersectionObserver(active);
for (let i = 0; i < items.length; i++) {
  io.observe(items[i]);
}
