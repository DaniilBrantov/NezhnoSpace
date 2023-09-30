const currentUrl = window.location.host;
var slider = [
    {
    id: "slide1",
    cat: "Ежедневные Практики",
    title: "Society: Standards and Beauty Culture",
    text: "Quality life = fulfilling life that we deserve and are capable of living. Quality life is a resourceful state in which we are able to take care not only of ourselves, but also of our loved ones.",
    image: "https://i0.wp.com/nezhno.space/wp-content/uploads/2023/01/photo_-58-scaled.jpg?w=1706&ssl=1",
},
    {
    id: "slide2",
    cat: "Темы",
    title: "Health and Well-being",
    text: "Health is the greatest wealth we can have. Well-being is a state of harmony and satisfaction in all areas of life.",
    image: "https://nezhno.space/wp-content/uploads/2023/01/photo_-46-scaled.jpg",
    },
    {
        id: "slide3",
        cat: "Упражнения",
        title: "Health and Well-being",
        text: "Health is the greatest wealth we can have. Well-being is a state of harmony and satisfaction in all areas of life.",
        image: "https://nezhno.space/wp-content/uploads/2023/01/photo_-46-scaled.jpg",
    }
];
function createSlide(data) {
    var slide = document.createElement("div");
    slide.id = data.id;
    slide.className = "try_free_slide";
    var slideImage = document.createElement("div");
    slideImage.className = "slide_image";
    var slideImg = document.createElement("img");
    slideImg.className = "slide_img";
    slideImg.src = data.image;
    var slideCat = document.createElement("span");
    slideCat.className = "slide_cat";
    slideCat.textContent = data.cat;
    slideImage.appendChild(slideCat);
    slideImage.appendChild(slideImg);
    slide.appendChild(slideImage);
    var slideContent = document.createElement("div");
    slideContent.className = "slide_content";
    var slideTitle = document.createElement("span");
    slideTitle.className = "slide_title";
    slideTitle.textContent = data.title;
    slideContent.appendChild(slideTitle);
    var slideText = document.createElement("p");
    slideText.className = "slide_text";
    slideText.textContent = data.text;
    slideContent.appendChild(slideText);
    slide.appendChild(slideContent);
    var slideAudio = document.createElement("div");


    const playerHTML = `
        <div class="trial_audio">
            <div class="player">
                <div class="player__wrap">
                    <div class="info">
                        <span class="info-icon">
                            <svg width="32" height="32" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M21.5523 17 21 15C17 14.4477 16.5523 14 16 14H14C13.4477 14 13 14.4477 13 15C13 15.5523 13.4477 16 14 16C14.5523 16 15 16.4477 15 17V21C15 21.5523 14.5523 22 14 22H13C12.4477 22 12 22.4477 12 23C12 23.5523 12.4477 24 13 24H19C19.5523 24 20 23.5523 20 23C20 22.4477 19.5523 22 19 22H18ZM16 8C15.7033 8 15.4133 8.08797 15.1666 8.2528C14.92 8.41762 14.7277 8.65189 14.6142 8.92597C14.5006 9.20006 14.4709 9.50166 14.5288 9.79264C14.5867 10.0836 14.7296 10.3509 14.9393 10.5607C15.1491 10.7704 15.4164 10.9133 15.7074 10.9712C15.9983 11.0291 16.2999 11 16.574 10.8865C16.8481 10.773 17.0824 10.5808 17.2472 10.3342C17.412 10.0876 17.5 9.79762 17.5 9.50166C17.5 9.20571 17.412 8.91574 17.2472 8.66914C17.0824 8.42254 16.8481 8.23032 16.574 8.11678C16.2999 8.00324 15.9983 7.97453 15.7074 8.03242C15.4164 8.09031 15.1491 8.23319 14.9393 8.44296C14.7296 8.65273 14.5867 8.92003 14.5288 9.2108C14.4709 9.50166 14.5006 9.80326 14.6142 10.0784C14.7277 10.3525 14.92 10.5868 15.1666 10.7516C15.4133 10.9164 15.7033 11.0044 16 11.0044C16.297 11.0044 16.586 10.9164 16.8326 10.7516C17.0792 10.5868 17.2724 10.3525 17.3858 10.0784C17.4993 9.80326 17.529 9.50166 17.4711 9.2108C17.4132 8.91993 17.2703 8.65273 17.0606 8.44296C16.8509 8.23319 16.5836 8.09031 16.2939 8.03242C16.004 7.97453 15.7024 8.00324 15.4273 8.11678C15.1522 8.23032 14.9179 8.42254 14.7531 8.66914C14.5883 8.91574 14.5 9.20571 14.5 9.50166C14.5 9.79762 14.5883 10.0876 14.7531 10.3342C14.9179 10.5808 15.1522 10.773 15.4273 10.8865C15.7024 11 16.004 11.0291 16.2939 10.9712C16.5836 10.9133 16.8509 10.7704 17.0606 10.5607C17.2703 10.3509 17.4132 10.0836 17.4711 9.79264C17.529 9.50166 17.4993 9.20006 17.3858 8.92597C17.2724 8.65189 17.0792 8.41762 16.8326 8.2528C16.586 8.08797 16.297 8 16 8Z" fill="white" />
                                <path d="M16 30C13.2311 30 10.5243 29.1789 8.22202 27.6406C5.91973 26.1022 4.12532 23.9157 3.06569 21.3576C2.00607 18.7994 1.72882 15.9845 2.26901 13.2687C2.80921 10.553 4.14258 8.05845 6.10051 6.10051C8.05845 4.14258 10.553 2.80921 13.2687 2.26901C15.9845 1.72882 18.7994 2.00607 21.3576 3.06569C23.9157 4.12532 26.1022 5.91973 27.6406 8.22202C29.1789 10.5243 30 13.2311 30 16C30 19.713 28.525 23.274 25.8995 25.8995C23.274 28.525 19.713 30 16 30ZM16 4.00001C13.6266 4.00001 11.3066 4.70379 9.33316 6.02237C7.35977 7.34095 5.8217 9.21509 4.50312 11.1885C3.18454 13.1619 2.38076 15.4819 2.38076 17.8553C2.38076 20.2287 3.18454 22.5487 4.50312 24.5221C5.8217 26.4955 7.35977 28.3696 9.33316 29.6882C11.3066 31.0068 13.6266 31.7106 16 31.7106C18.3734 31.7106 20.6934 31.0068 22.6668 29.6882C24.6402 28.3696 26.1763 26.4955 27.4949 24.5221C28.8135 22.5487 29.6173 20.2287 29.6173 17.8553C29.6173 15.4819 28.8135 13.1619 27.4949 11.1885C26.1763 9.21509 24.6402 7.34095 22.6668 6.02237C20.6934 4.70379 18.3734 4.00001 16 4.00001Z" fill="white" />
                            </svg>
                        </span>
                        <div class="volume-box">
                            <span id="volume" class="volume active">
                                <svg width="22" height="20" viewBox="0 0 22 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M6.80801 22.012 13.217 18 17 21M1 12.959V7.04001C1 6.46601 1.448 6.00001 2 6.00001H5.586C5.71833 5.99954 5.84924 5.97232 5.97074 5.92768C6.09224 5.88304 6.20193 5.81699 6.29303 5.73099L9.29303 2.34299C9.92303 1.68699 11 2.15199 11 3.07899V16.921C11 17.847 9.91 18.308 9.284 17.639L6.294 14.27C6.20259 14.1713 6.09181 14.0925 5.96874 14.0385C5.84566 13.9845 5.71265 13.9564 5.57814 13.9564H2C1.448 13.9564 1 13.4904 1 12.9154V12.959Z" stroke="#7264AA" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </span>
                            <span class="volume-none">
                                <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M26 19L20 13M26 13L20 19" stroke="#7264AA" stroke-width="2" stroke-linecap="round" />
                                    <path d="M6 18.959V13.04C6 12.466 6.448 12 7 12H10.586C10.7183 11.9995 10.8492 11.9723 10.9707 11.9199C11.0922 11.8674 11.2019 11.791 11.293 11.695L14.293 8.30701C14.923 7.65101 16 8.11601 16 9.04301V22.957C16 23.891 14.91 24.352 14.284 23.683L11.294 20.314C11.2026 20.2153 11.0918 20.1365 10.9687 20.0825C10.8455 20.0285 10.7125 20.0004 10.578 20H7C6.448 20 6 19.534 6 18.959Z" stroke="#7264AA" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </span>
                            <input type="range" class="volume-range visually-hidden" step="1" value="80" min="0" max="100">
                        </div>
                        <span class="speed">1x</span>
                    </div>
                    <div class="title">
                        <p class="player_title_text" id="player_title_text">Подкаст - качество жизни</p>
                    </div>
                    <div class="player__box-wrap">
                        <span class="play">
                            <svg class="play-show" width="25" height="25" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M38.5 20C38.5 30.2173 30.2173 38.5 20 38.5C9.78273 38.5 1.5 30.2173 1.5 20C1.5 9.78273 9.78273 1.5 20 1.5C30.2173 1.5 38.5 9.78273 38.5 20Z" fill="#7264AA" stroke="#7264AA" stroke-width="3" />
                                <path d="M30.5 19.134C31.1667 19.5189 31.1667 20.4811 30.5 20.866L15.5 29.5263C14.8333 29.9112 14 29.4301 14 28.6603L14 11.3397C14 10.5699 14.8333 10.0888 15.5 10.4737L30.5 19.134Z" fill="white" />
                            </svg>
                            <svg class="pause-show" width="25" height="25" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="20" cy="20" r="20" fill="#7264AA" />
                                <rect x="14" y="10" width="4" height="21" rx="2" fill="white" />
                                <rect x="22" y="10" width="4" height="21" rx="2" fill="white" />
                            </svg>
                        </span>
                        <div class="player_box">
                            <div class="progress-container" id="progress-container">
                                <input type="range" class="progress" id="progress" max="100" value="0">
                            </div>
                            <div class="duration">
                                <span class="current-time">00:00</span>
                                <span class="duration-time">00:00</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <audio preload='metadata' class='audio' src='' loop></audio>
        `;
    slideAudio.innerHTML = playerHTML;
    slideAudio.className = "slide_audio";
    slide.appendChild(slideAudio);
    var slideButton = document.createElement("a");
    slideButton.className = "slide_btn";
    slideButton.innerHTML = "Купить";
    slideButton.href = "payment";
    slide.appendChild(slideButton);
    return slide;
}
if (document.querySelector(".try_free_slider")) {
    var sliderContainer = document.querySelector(".try_free_slider");
    slider.forEach(item => {
        var slide = createSlide(item);
        sliderContainer.appendChild(slide);
    });
    $(sliderContainer).slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        dots: true,
        autoplay: false,
        autoplaySpeed: 3000,
        responsive: [{
            breakpoint: 768,
            settings: {
                slidesToShow: 1,
            }
        }]
    });
}