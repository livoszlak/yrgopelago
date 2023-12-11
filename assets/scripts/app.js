const days = document.querySelectorAll('td');
// const dates = document.querySelectorAll('.cal-day-box');
// const dates = [];
// for (let i = 1; i < 32; i++) {
//   if (i < 10) {
//     dates[i] = '0' + i;
//   } else {
//     dates[i] = i;
//   }
// }
console.log(days);

days.forEach((day) => {
  if (parseInt(day.firstChild.innerHTML) < 10) {
    day.setAttribute('id', `2024-01-0${parseInt(day.firstChild.innerHTML)}`);
  } else {
    day.setAttribute('id', `2024-01-${parseInt(day.firstChild.innerHTML)}`);
  }
});

const checkAvailability = document.getElementById('submit');
checkAvailability.addEventListener('click', () => {});
