<?php
// NOT THE ACTUAL CALENDAR ON WEBSITE. This is one I tried to make work for me, but had to abandon at some point. Left here in case I want to implement it later.


declare(strict_types=1);

?>

<div class="calendar">
    <div class="calendar-top">
        <div class="month">
            <span class="month-name">January 2024</span>
        </div>
    </div>
    <div class="calendar-contents">
        <span class="day">Mo</span>
        <span class="day">Tu</span>
        <span class="day">We</span>
        <span class="day">Th</span>
        <span class="day">Fr</span>
        <span class="day">Sa</span>
        <span class="day">Su</span>
        <button class="date">1</button>
        <button class="date">2</button>
        <button class="date">3</button>
        <button class="date">4</button>
        <button class="date">5</button>
        <button class="date">6</button>
        <button class="date">7</button>
        <button class="date">8</button>
        <button class="date">9</button>
        <button class="date">10</button>
        <button class="date">11</button>
        <button class="date">12</button>
        <button class="date">13</button>
        <button class="date">14</button>
        <button class="date">15</button>
        <button class="date">16</button>
        <button class="date">17</button>
        <button class="date">18</button>
        <button class="date">19</button>
        <button class="date">20</button>
        <button class="date">21</button>
        <button class="date">22</button>
        <button class="date">23</button>
        <button class="date">24</button>
        <button class="date">25</button>
        <button class="date">26</button>
        <button class="date">27</button>
        <button class="date">28</button>
        <button class="date">29</button>
        <button class="date">30</button>
        <button class="date">31</button>
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');

    *,
    *:after,
    *:before {
        box-sizing: border-box;
    }

    :root {
        --c-theme-primary: #008FFD;
        --c-theme-primary-accent: #CBE8FF;
        --c-bg-primary: #D6DAE0;
        --c-bg-secondary: #EAEBEC;
        --c-bg-tertiary: #FDFDFD;
        --c-text-primary: #1F1F25;
        --c-text-secondary: #999FA6;
    }

    body {
        font-family: "Inter", sans-serif;
        line-height: 1.5;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: var(--c-bg-primary);
        color: var(--c-text-primary);
    }

    button {
        font: inherit;
        cursor: pointer;

        &:focus {
            outline: 0;
        }
    }

    .calendar {
        width: 95%;
        max-width: 350px;
        background-color: var(--c-bg-tertiary);
        border-radius: 10px;
        box-shadow: 0 0 2px 0 rgba(#000, .2), 0 5px 10px 0 rgba(#000, .1);
        padding: 1rem;
    }

    .calendar-top {
        margin-bottom: 1rem;
    }

    .month {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .month-name {
        font-weight: 600;
    }

    .calendar-contents {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        grid-row-gap: 1rem;
    }

    .day,
    .date {
        justify-self: center;
    }

    .day {
        color: var(--c-text-secondary);
        font-size: .875em;
        font-weight: 500;
        justify-self: center;
    }

    .date {
        border: 0;
        padding: 0;
        width: 2.25rem;
        height: 2.25rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        font-weight: 600;
        border: 2px solid transparent;
        background-color: transparent;
        cursor: pointer;

        &:focus {
            outline: 0;
            color: var(--c-theme-primary);
            border: 2px solid var(--c-theme-primary-accent);
        }
    }

    .faded {
        color: var(--c-text-secondary);
    }

    .selected {
        color: #FFF;
        border-color: var(--c-theme-primary);
        background-color: var(--c-theme-primary);

        &:focus {
            background-color: var(--c-theme-primary-accent);
        }
    }
</style>

<script>
    let arrival = null;
    let departure = null;
    const days = Array.from(document.querySelectorAll('.date'));

    days.forEach(day => {
        day.addEventListener('click', function() {
            if (arrival === null) {
                arrival = this;
                this.classList.add('selected');
            } else if (departure === null) {
                departure = this;
                this.classList.add('selected');

                let arrivalIndex = days.indexOf(arrival);
                let departureIndex = days.indexOf(departure);
                while (arrivalIndex < departureIndex) {
                    arrivalIndex++;
                    days[arrivalIndex].classList.add('selected');
                }
                days[departureIndex].classList.add('selected');
            } else {
                arrival = null;
                departure = null;
                document.querySelectorAll('.date').forEach(day => {
                    day.classList.remove('selected');
                });
            }
        });
    });

    days.forEach(day => {
        if (day.innerHTML < 10) {
            day.setAttribute('id', `2024-01-0${day.innerHTML}`);
        } else {
            day.setAttribute('id', `2024-01-${day.innerHTML}`);

        }
    })
</script>