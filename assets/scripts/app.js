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

// let arrival = null;
// let departure = null;

// days.forEach(function (day) {
//   day.addEventListener('click', function () {
//     if (arrival === null) {
//       arrival = this.id;
//       this.classList.add('selected');
//       document.getElementById('arrival').value = arrival;
//       document.getElementById('calendar-form').submit();
//     } else if (arrival !== null && departure === null) {
//       departure = this.id;
//       this.classList.add('selected');
//       document.getElementById('departure').value = departure;
//       document.getElementById('calendar-form').submit();
//     }

//   let arrivalIndex = days.indexOf(arrival);
//   let departureIndex = days.indexOf(departure);
//   while (arrivalIndex < departureIndex) {
//     arrivalIndex++;
//     days[arrivalIndex].classList.add('selected');
//   }
//   days[departureIndex].classList.add('selected');
// } else {
//   arrival = null;
//   departure = null;
//   document.querySelectorAll('.date').forEach((day) => {
//     day.classList.remove('selected');
//   });
// });
