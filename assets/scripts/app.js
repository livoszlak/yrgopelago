const days = document.querySelectorAll('td');

console.log(days);

days.forEach((day) => {
  if (parseInt(day.firstChild.innerHTML) < 10) {
    day.setAttribute('id', `2024-01-0${parseInt(day.firstChild.innerHTML)}`);
  } else {
    day.setAttribute('id', `2024-01-${parseInt(day.firstChild.innerHTML)}`);
  }
});

const bookingStep1 = document.getElementById('booking-step-1');
const features = document.getElementById('features-wrapper');
bookingStep1.addEventListener('click', () => {
  features.appendChild('div');
});

const accordion = document.getElementsByClassName('accordion');

for (let i = 0; i < accordion.length; i++) {
  accordion[i].addEventListener('click', function () {
    this.classList.toggle('active');

    const panel = this.nextElementSibling;
    if (panel.style.display === 'block') {
      panel.style.display = 'none';
    } else {
      panel.style.display = 'block';
    }
    if (panel.style.maxHeight) {
      panel.style.maxHeight = null;
    } else {
      panel.style.maxHeight = panel.scrollHeight + 'px';
    }
  });
}
