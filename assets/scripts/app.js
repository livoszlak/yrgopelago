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

/* Sets id properties for td elements in availability calendar - might be needed at deployment, might not */

const days = document.querySelectorAll('td');

days.forEach((day) => {
  if (parseInt(day.firstChild.innerHTML) < 10) {
    day.setAttribute('id', `2024-01-0${parseInt(day.firstChild.innerHTML)}`);
  } else {
    day.setAttribute('id', `2024-01-${parseInt(day.firstChild.innerHTML)}`);
  }
});

/* Auto-scroll down to quote on room page */

document.addEventListener('DOMContentLoaded', function () {
  if (localStorage.getItem('bookingStep1Clicked') !== null) {
    var element = document.querySelector('.quote-wrapper');
    element.scrollIntoView({ behavior: 'smooth' });
    localStorage.removeItem('bookingStep1Clicked');
  }
});

document
  .getElementById('booking-step-1')
  .addEventListener('click', function () {
    localStorage.setItem('bookingStep1Clicked', true);
  });

/* Image slider/carousel */

let slideIndex = 0;
showSlides();

function showSlides() {
  let i;
  let slides = document.getElementsByClassName('mySlides');
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = 'none';
  }
  slideIndex++;
  if (slideIndex > slides.length) {
    slideIndex = 1;
  }
  slides[slideIndex - 1].style.display = 'block';
  setTimeout(showSlides, 2000);
}

let images = [
  '../assets/images/carousel/CAROUSEL-wren-meinberg-AL2-t0GrSko-unsplash.jpg',
  '../assets/images/carousel/CAROUSEL-tucker-good-i5wk7pPTarY-unsplash.jpg',
  '../assets/images/carousel/CAROUSEL-tran-mau-tri-tam-pfRES3CjcUM-unsplash.jpg',
  '../assets/images/carousel/CAROUSEL-samsung-memory-zFzbcadA0Ro-unsplash.jpg',
  '../assets/images/carousel/CAROUSEL-pexels-viktorya-sergeeva-🫂-10455928.jpg',
  '../assets/images/carousel/CAROUSEL-pexels-tranmautritam-2215599.jpg',
  '../assets/images/carousel/CAROUSEL-pexels-sam-lion-6002000.jpg',
  '../assets/images/carousel/CAROUSEL-pexels-pixabay-236606.jpg',
  '../assets/images/carousel/CAROUSEL-pexels-milda-puga-4862597.jpg',
  '../assets/images/carousel/CAROUSEL-pexels-helena-lopes-7980485.jpg',
  '../assets/images/carousel/CAROUSEL-pexels-cottonbro-studio-6869654.jpg',
  '../assets/images/carousel/CAROUSEL-nine-koepfer-lpgAlv8I7V8-unsplash (1).jpg',
  '../assets/images/carousel/CAROUSEL-artem-trubitsyn-oO0g3OfBQMw-unsplash.jpg',
  '../assets/images/carousel/CAROUSEL-paul-hanaoka-C0zDWAPFT9A-unsplash.jpg',
  '../assets/images/carousel/CAROUSEL-humberto-arellano-N_G2Sqdy9QY-unsplash.jpg',
  '../assets/images/carousel/CAROUSEL-pexels-daniela-constantini-5591700.jpg',
];

let currentImageIndex = 0;

function changeImage() {
  let sliderImage = document.getElementById('sliderImage');
  sliderImage.src = images[currentImageIndex];

  currentImageIndex++;
  if (currentImageIndex >= images.length) {
    currentImageIndex = 0;
  }
}

setInterval(changeImage, 3500);

/* Feature-click targeting script */

const features = document.getElementsByClassName('.feature');
const checkboxes = document.querySelectorAll("input[type='checkbox']");

for (let i = 0; i < features.length; i++) {
  features[i].addEventListener('click', function () {
    const checkbox = this.querySelector('input[type="checkbox"]');
    if (checkbox) checkbox.checked = true;
  });
}
