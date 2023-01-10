(() => {
  const videoPlayer = document.querySelector("#video-player");
  const playVideoBtn = document.querySelector(".video_play_btn");
  const fullscreenBtn = document.querySelector(".fullscreen-box_video");
  const volumeVideoIcon = document.querySelectorAll(".volume-video-icon");
  const moreBtn = document.querySelector(".more-box_video");
  const speedBtn = document.querySelector(".more-alert_speed");

  const progressBarVideo = document.querySelector("#progress-video");

  if (videoPlayer) {
    // progress video
    const setSliderMax = () => {
      progressBarVideo.max = Math.floor(videoPlayer.duration);
    };

    const showRangeProgress = (rangeInput) => {
      videoPause();
      videoPlayer.style.setProperty(
        "--seek-before-width",
        (rangeInput.value / rangeInput.max) * 100 + "%"
      );
      setSliderMax();
    };

    progressBarVideo.addEventListener("input", (e) => {
      e.preventDefault();
      showRangeProgress(e.target);
    });

    progressBarVideo.addEventListener("change", (e) => {
      e.preventDefault();
      videoPlayer.currentTime = e.target.value;
      videoPlay();
    });

    //duration video

    videoPlayer.addEventListener(
      "loadeddata",
      () => {
        let duration = getTimeCodeFromNum(videoPlayer.duration);
        let i = 0;

        while (isNaN(duration)) {
          duration = videoPlayer.duration;
          if (i === 10) {
            document.querySelector(
              ".duration-video .duration-time-video"
            ).textContent = "--";
            break;
          } else {
            document.querySelector(
              ".duration-video .duration-time-video"
            ).textContent = getTimeCodeFromNum(videoPlayer.duration);
            videoPlayer.volume = 1;
          }
          i++;
        }
      },
      false
    );

    setInterval(() => {
      setSliderMax();
      videoPlayer.style.setProperty(
        "--seek-before-width",
        (progressBarVideo.value / progressBarVideo.max) * 100 + "%"
      );
      document.querySelector(
        ".duration-video .current-time-video"
      ).textContent = getTimeCodeFromNum(videoPlayer.currentTime);
    }, 2);

    videoPlayer.addEventListener("timeupdate", () => {
      progressBarVideo.value = Math.floor(videoPlayer.currentTime);
    });

    //plays video
    function videoPlay() {
      playVideoBtn.classList.replace("play", "pause");
      videoPlayer.play();
    }

    function videoPause() {
      playVideoBtn.classList.replace("pause", "play");
      videoPlayer.pause();
    }

    let timerControlsContainer;

    function videoControl() {
      clearTimeout(timerControlsContainer);
      if (videoPlayer.paused) {
        videoPlay();
      } else {
        videoPause();
      }

      document.querySelector(".video-controls").style.display = "block";
      timerControlsContainer = setTimeout(
        () =>
          (document.querySelector(".video-controls").style.display = "none"),
        3000
      );
    }

    videoPlayer.addEventListener("click", videoControl, false);
    playVideoBtn.addEventListener("click", videoControl, false);

    //open fullscreen
    fullscreenBtn.addEventListener("click", () => openFullscreen(), false);

    function openFullscreen() {
      videoPlayer.controls = "true";
      videoPlayer.removeEventListener("click", videoControl, false);
      playVideoBtn.removeEventListener("click", videoControl, false);
      if (videoPlayer.requestFullscreen) {
        videoPlayer.requestFullscreen();
      } else if (fullscreenBtnwebkitRequestFullscreen) {
        /* Safari */
        videoPlayer.webkitRequestFullscreen();
      } else if (videoPlayer.msRequestFullscreen) {
        /* IE11 */
        videoPlayer.msRequestFullscreen();
      }
    }

    document.addEventListener(
      "fullscreenchange",
      () => {
        if (!document.fullscreenElement) {
          videoPlayer.removeAttribute("controls");
          videoPlayer.addEventListener("click", videoControl, false);
          playVideoBtn.addEventListener("click", videoControl, false);
        }
      },
      false
    );

    //volume change
    let myTimeout;

    function changeVolume(amount) {
      clearTimeout(myTimeout);
      videoPlayer.volume = amount;

      if (Number(amount) === 0) {
        document.querySelector(".volume-video").classList.remove("active");
        document.querySelector(".volume-video-none").classList.add("active");
      } else {
        document.querySelector(".volume-video").classList.add("active");
        document.querySelector(".volume-video-none").classList.remove("active");
      }

      myTimeout = setTimeout(
        () =>
          (document.querySelector(".progress_volume-video").style.display =
            "none"),
        3000
      );
    }

    document
      .querySelector("#volume-video_range")
      .addEventListener("change", function () {
        changeVolume(this.value);
      });

    volumeVideoIcon.forEach((icon) => {
      icon.addEventListener("click", function () {
        if (
          window.getComputedStyle(
            document.querySelector(".progress_volume-video")
          ).display === "block"
        ) {
          document.querySelector(".progress_volume-video").style.display =
            "none";
        } else if (
          window.getComputedStyle(
            document.querySelector(".progress_volume-video")
          ).display === "none"
        ) {
          document.querySelector(".progress_volume-video").style.display =
            "block";
          myTimeout = setTimeout(
            () =>
              (document.querySelector(".progress_volume-video").style.display =
                "none"),
            3000
          );
        }
      });
    });

    document.addEventListener(
      "mousemove",
      function (e) {
        if (e.target.nodeName !== "#document") {
          let container = e.target.closest(".video-container");
          if (container) {
            document.querySelector(".video-controls").style.display = "block";
          } else {
            document.querySelector(".video-controls").style.display = "none";
          }
        }
      },
      false
    );

    //btn more
    moreBtn.addEventListener("click", function () {
      if (
        window.getComputedStyle(document.querySelector(".more-alert_video"))
          .display === "none"
      ) {
        document.querySelector(".more-alert_video").style.display = "block";
      }
    });

    //speed video
    let speedTimer;
    let speedVideoIndexValue = 1;
    speedBtn.addEventListener("click", function () {
      clearTimeout(speedTimer);
      const speedVideoList = [0.75, 1, 1.25];
      speedVideoIndexValue++;
      if (speedVideoIndexValue >= speedVideoList.length) {
        speedVideoIndexValue = 0;
      }
      speedBtn.innerText =
        "Скорость видео: " + speedVideoList[speedVideoIndexValue] + "x";
      videoPlayer.playbackRate = speedVideoList[speedVideoIndexValue];
      speedTimer = setTimeout(
        () =>
          (document.querySelector(".more-alert_video").style.display = "none"),
        3000
      );
    });

    //ended video
    videoPlayer.addEventListener(
      "ended",
      function () {
        videoPlayer.currentTime = 0;
        videoPlayer.play();
      },
      false
    );
  }
})();
