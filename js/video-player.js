(() => {
  class VideoPlayer {
    constructor(video) {
      this.video = video;
      this.playVideoBtn = document.querySelector(".video_play_btn");
      this.fullscreenBtn = document.querySelector(".fullscreen-box_video");
      this.volumeVideoIcon = document.querySelectorAll(".volume-video-icon");
      this.moreBtn = document.querySelector(".more-box_video");
      this.speedBtn = document.querySelector(".more-alert_speed");
      this.progressBarVideo = document.querySelector("#progress-video");
      this.timerControlsContainer = null;
      this.myTimeout = null;
      this.speedTimer = null;
      this.speedVideoIndexValue = 1;
    }
    videoPlay() {
      this.playVideoBtn.classList.replace("play", "pause");
      this.video.play();
    }
    videoPause() {
      this.playVideoBtn.classList.replace("pause", "play");
      this.video.pause();
    }
    videoControl() {
      if (this.timerControlsContainer) {
        clearTimeout(this.timerControlsContainer);
      }
      this.video.paused ? this.videoPlay() : this.videoPause();
      document.querySelector(".video-controls").style.display = "block";
      this.timerControlsContainer = setTimeout(() => (
        document.querySelector(".video-controls").style.display = "none"
      ), 3000);
    }
    setSliderMax() {
      this.progressBarVideo.max = Math.floor(this.video.duration);
    }
    showRangeProgress(rangeInput) {
      this.videoPause();
      this.video.style.setProperty("--seek-before-width", (rangeInput.value / rangeInput.max) * 100 + "%");
      this.setSliderMax();
    }
    progress() {
      this.progressBarVideo.addEventListener("input", (e) => {
        e.preventDefault();
        this.showRangeProgress(e.target);
      });

      this.progressBarVideo.addEventListener("change", (e) => {
        e.preventDefault();
        this.video.currentTime = e.target.value;
        this.videoPlay();
      });
    }
    duration() {
      this.video.addEventListener("loadeddata", () => {
        let duration = getTimeCodeFromNum(this.video.duration);
        let i = 0;

        while (isNaN(duration)) {
          duration = this.video.duration;
          if (i === 10) {
            document.querySelector(".duration-video .duration-time-video").textContent = "--";
            break;
          } else {
            document.querySelector(".duration-video .duration-time-video").textContent = getTimeCodeFromNum(this.video.duration);
            this.video.volume = 1;
          }
          i++;
        }
      }, false);

      setInterval(() => {
        this.setSliderMax();
        this.video.style.setProperty("--seek-before-width", (this.progressBarVideo.value / this.progressBarVideo.max) * 100 + "%");
        document.querySelector(".duration-video .current-time-video").textContent = getTimeCodeFromNum(this.video.currentTime);
      }, 2);

      this.video.addEventListener("timeupdate", () => {
        this.progressBarVideo.value = Math.floor(this.video.currentTime);
      });
    }
    click() {
      this.video.addEventListener("click", () => this.videoControl(), false);
      this.playVideoBtn.addEventListener("click", () => this.videoControl(), false);
    }
    openFullscreen() {
      this.video.controls = "true";
      if (this.video.requestFullscreen) {
        this.video.requestFullscreen();
      } else if (fullscreenBtnwebkitRequestFullscreen) {
        /* Safari */
        this.video.webkitRequestFullscreen();
      } else if (this.video.msRequestFullscreen) {
        /* IE11 */
        this.video.msRequestFullscreen();
      }
    }
    fullscreen() {
      this.fullscreenBtn.addEventListener("click", () => this.openFullscreen(), false);

      document.addEventListener("fullscreenchange", () => {
        if (!document.fullscreenElement) {
          this.video.removeAttribute("controls");
        }
      }, false);
    }
    changeVolume(amount) {
      if (this.myTimeout) {
        clearTimeout(this.myTimeout);
      }
      this.video.volume = amount;
      if (Number(amount) === 0) {
        document.querySelector(".volume-video").classList.remove("active");
        document.querySelector(".volume-video-none").classList.add("active");
      } else {
        document.querySelector(".volume-video").classList.add("active");
        document.querySelector(".volume-video-none").classList.remove("active");
      }

      this.myTimeout = setTimeout(() => (
        document.querySelector(".progress_volume-video").style.display = "none"
      ), 3000);
    }
    volume() {
      document.querySelector("#volume-video_range").addEventListener("change", (e) => this.changeVolume(e.target.value));

      this.volumeVideoIcon.forEach((icon) => {
        icon.addEventListener("click", function () {
          if (window.getComputedStyle(document.querySelector(".progress_volume-video")).display === "block") {
            document.querySelector(".progress_volume-video").style.display = "none";
          } else if (window.getComputedStyle(document.querySelector(".progress_volume-video")).display === "none") {
            document.querySelector(".progress_volume-video").style.display = "block";
            this.myTimeout = setTimeout(() => ( 
              document.querySelector(".progress_volume-video").style.display = "none"
            ), 3000);
          }
        });
      });   

      document.querySelector("#volume-video_range").addEventListener("change", (e) => this.changeVolume(e.target.value));   
    }
    mousemove() {
      document.addEventListener("mousemove", function (e) {
        if (e.target.nodeName !== "#document") {
          let container = e.target.closest(".video-container");
          if (container) {
            document.querySelector(".video-controls").style.display = "block";
          } else {
            document.querySelector(".video-controls").style.display = "none";
          }
        }
      }, false);
    }
    btnMore() {
      this.moreBtn.addEventListener("click", function () {
        if (window.getComputedStyle(document.querySelector(".more-alert_video")).display === "none") {
          document.querySelector(".more-alert_video").style.display = "block";
        }
      });
    }
    speed() {
      const speedVideoList = [0.75, 1, 1.25];
      this.speedBtn.addEventListener("click", () => {
        if (this.speedTimer) {
          clearTimeout(this.speedTimer);
        }
        this.speedVideoIndexValue++;
        if (this.speedVideoIndexValue >= speedVideoList.length) {
          this.speedVideoIndexValue = 0;
        }
        this.speedBtn.innerText = "Скорость видео: " + speedVideoList[this.speedVideoIndexValue] + "x";
        this.video.playbackRate = speedVideoList[this.speedVideoIndexValue];
        this.speedTimer = setTimeout(() => (
          document.querySelector(".more-alert_video").style.display = "none"
        ), 3000);
      });
    }
    ended() {
      this.video.addEventListener("ended", () => {
        this.video.currentTime = 0;
        this.video.play();
      }, false);
    }
    init() {
      this.progress();
      this.duration();
      this.click();
      this.fullscreen();
      this.volume();
      this.mousemove();
      this.btnMore();
      this.speed();
      this.ended();
    }
  }

  if (document.querySelector("#video-player")) {
    let videoPlayer = new VideoPlayer(document.querySelector("#video-player"));
    videoPlayer.init();
  }
})();