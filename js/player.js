(() => {

  const musicList = ["coldplay-paradise"];
  let index = 0;
  const audio = new Audio(
    `wp-content/themes/my-theme/audio/${musicList[index]}.mp3`
  );
  audio.className = 'audio';
  document.body.append(audio);
  const audioPlayer = document.querySelector(".player");
  const playBtn = document.querySelector(".player__box-wrap .play");
  const seekSlider = document.querySelector("#progress.progress");

  // const next = document.querySelector(".next");
  // const prev = document.querySelector(".prev");
  //const titleDesktop = document.querySelector('.title-desktop')

  const volumeBtn = document.querySelector(".volume");
  const volumeNoneBtn = document.querySelector(".volume-none");
  const volumeRange = document.querySelector(".volume-range");
  const speed = document.querySelector(".speed");

  const info = document.querySelector(".info");

  if (audioPlayer) {
    //progress audio (google chrome)
    const setSliderMax = () => {
      seekSlider.max = Math.floor(audio.duration);
    };

    const showRangeProgress = (rangeInput) => {
      audioPlayer.style.setProperty(
        "--seek-before-width",
        (rangeInput.value / rangeInput.max) * 100 + "%"
      );
      setSliderMax();
    };

    seekSlider.addEventListener("input", (e) => {
      e.preventDefault();
      showRangeProgress(e.target);
      musicPlay();
    });

    seekSlider.addEventListener("change", (e) => {
      e.preventDefault();
      musicPlay();
    });

    //duration audio

    audio.addEventListener(
      "loadeddata",
      () => {
        audioPlayer.querySelector(".player_box .duration-time").textContent =
          getTimeCodeFromNum(audio.duration);
        audio.volume = 1;
      },
      false
    );

    setInterval(() => {
      setSliderMax();
      audioPlayer.style.setProperty(
        "--seek-before-width",
        (seekSlider.value / seekSlider.max) * 100 + "%"
      );
      audioPlayer.querySelector(".player_box .current-time").textContent =
        getTimeCodeFromNum(audio.currentTime);
    }, 2);

    audio.addEventListener("timeupdate", () => {
      seekSlider.value = Math.floor(audio.currentTime);
    });

    //play audio

    function musicPlay() {
      playBtn.classList.remove("play");
      playBtn.classList.add("pause");
      audio.play();
    }

    function musicPause() {
      playBtn.classList.remove("pause");
      playBtn.classList.add("play");
      audio.pause();
    }

    playBtn.addEventListener(
      "click",
      () => {
        if (audio.paused) {
          musicPlay();
        } else {
          musicPause();
        }
      },
      false
    );

    //audio title

    function setTitle(index) {
      document.getElementById("player_title_text").textContent =
        musicList[getIndex()][0].toUpperCase() + musicList[index].slice(1);
    }

    setTitle(index);

    function getIndex() {
      return musicList.findIndex((el) => audio.src.includes(el));
    }

    seekSlider.addEventListener("change", () => {
      audio.currentTime = seekSlider.value;
    });

    //volume audio

    if (volumeBtn) {
      volumeBtn.addEventListener("click", vol);
    }
    function vol() {
      volumeNoneBtn.classList.toggle("active");
      volumeBtn.classList.toggle("active");
      if (volumeNoneBtn.classList.contains("active")) {
        audio.volume = 0;
      } else {
        audio.volume = volumeRange.value / 100;
      }
    }
    if (volumeNoneBtn) {
      volumeNoneBtn.addEventListener("click", vol);
    }

    //speed audio

    if (speed) {
      speed.addEventListener("click", setSpeedValue);
    }

    function setSpeedValue(evt) {
      const speedList = [1, 1.5, 2];
      let speedIndexValue;
      if (
        speedList.findIndex((el) => el === parseFloat(evt.target.textContent)) +
        1 <
        speedList.length
      ) {
        speedIndexValue =
          speedList.findIndex(
            (el) => el === parseFloat(evt.target.textContent)
          ) + 1;
      } else {
        speedIndexValue = 0;
      }
      speed.textContent = speedList[speedIndexValue] + "x";
      audio.playbackRate = speedList[speedIndexValue];
    }

    //audio info

    document.addEventListener("click", (evt) => {
      evt.stopPropagation();
      if (evt.target.closest(".info") === info) {
        info.querySelector(".info-tultip").classList.toggle("active");
      }
    });

    //next audio

    audio.addEventListener("ended", nextSong);
    function nextSong() {
      if (musicList.length > 1) {
        index++;

        if (index > musicList.length - 1) {
          index = 0;
        }
        audio.src = `wp-content/themes/my-theme/audio/${musicList[index]}.mp3`;
        setTitle(index);
      }

      musicPlay();
    }

    //audio time


    // next.addEventListener('click', () => {
    //   index = getIndex()
    //   if (index < musicList.length - 1) {
    //     index++
    //   }
    //   else {
    //     index = 0
    //   }
    //   music.src = `./music/${musicList[index]}.mp3`
    //   setTitle(index)
    //   musucPlay();
    // });

    // prev.addEventListener('click', () => {
    //   index = getIndex()
    //   if (index > 0) {
    //     index--
    //   }
    //   else {
    //     index = musicList.length - 1
    //   }
    //   music.src = `./music/${musicList[index]}.mp3`
    //   setTitle(index)
    //   musucPlay();
    // });

    // document.querySelector('.replay').addEventListener('click', () => {
    //   if (music.currentTime > 0) {
    //     music.currentTime -= 10
    //   } else {
    //     music.currentTime = 0
    //   }
    // })

    // document.querySelector('.forward').addEventListener('click', () => {
    //   if (music.currentTime < music.duration) {
    //     music.currentTime += 10
    //   } else {
    //     music.currentTime = music.duration
    //   }
    // })

    // volumeRange.addEventListener('input', handleVolumeChange);

    // function handleVolumeChange() {
    //   music.volume = volumeRange.value / 100
    // }
  }
})();
