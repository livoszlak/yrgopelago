/* Auto-scroll */

document.addEventListener('DOMContentLoaded', function () {
  const element = document.querySelector('.headline');
  element.scrollIntoView({ behavior: 'smooth' });
});
