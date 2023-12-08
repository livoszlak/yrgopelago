const days = document.querySelectorAll('.cal-day-box');
console.log(days);
days.forEach((day) => {
  const date = parseInt(day.innerHTML);
  if (date < 10) {
    day.setAttribute('id', `2024-01-0${date}`);
  } else {
    day.setAttribute('id', `2024-01-${date}`);
  }
});

const checkAvailability = document.getElementById('submit');
checkAvailability.addEventListener('click', () => {});
