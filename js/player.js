(() => {
  const musicList = ["theme_1"];
  let index = 0;
  
  class AudioPlayer {
    constructor(element, audio) {
      this.element = element;
      this.audio = audio;
      
      this.playBtn = audio.querySelector(".player__box-wrap .play");
      this.seekSlider = audio.querySelector("#progress.progress");
    
      this.volumeBtn = audio.querySelector(".volume-box");
      this.volumeRange = document.querySelector(".volume-range");
      this.speed = audio.querySelector(".speed");
    
      this.info = audio.querySelector(".info");
    }
    loadeddata() {
      this.element.addEventListener("loadeddata", () => {
        this.audio.querySelector(".duration-time").textContent = getTimeCodeFromNum(this.element.duration);
        this.element.volume = 1;
      }, false);
    }
    musicPlay() {
      this.playBtn.classList.remove("play");
      this.playBtn.classList.add("pause");
      this.element.play();
    }
    musicPause() {
      this.playBtn.classList.remove("pause");
      this.playBtn.classList.add("play");
      this.element.pause();
    }
    listenerPlayBtn() {
      this.playBtn.addEventListener( "click", () => {
          if (this.element.paused) {
            this.musicPlay();
          } else {
            this.musicPause();
          }
        }, false
      );
    }
    //progress audio (google chrome)
    setSliderMax() {
      this.seekSlider.max = Math.floor(this.element.duration);
    }
    showRangeProgress(rangeInput) {
      this.audio.style.setProperty(
        "--seek-before-width",
        (rangeInput.value / rangeInput.max) * 100 + "%"
      );
      this.setSliderMax();
    }
    rangeProgress() {
      this.seekSlider.addEventListener("input", (e) => {
        e.preventDefault();
        this.showRangeProgress(e.target);
        this.musicPlay();
      });
      this.seekSlider.addEventListener("change", (e) => {
        e.preventDefault();
        this.element.currentTime = this.seekSlider.value;
        this.musicPlay();
      });
    }
    timeupdate() {
      this.element.addEventListener("timeupdate", () => {
        this.seekSlider.value = Math.floor(this.element.currentTime);
      });
    }
    setIntervalUpdate() {
      setInterval(() => {
        this.setSliderMax();
        this.audio.style.setProperty(
          "--seek-before-width",
          (this.seekSlider.value / this.seekSlider.max) * 100 + "%"
        );
        this.audio.querySelector(".player_box .current-time").textContent = getTimeCodeFromNum(this.element.currentTime);
      }, 2);
    }
    //audio title
    getIndex() {
      return musicList.findIndex((el) => this.element.src.includes(el));
    }
    setTitle(index) {
      document.getElementById("player_title_text").textContent = musicList[this.getIndex()][0].toUpperCase() + musicList[index].slice(1);
    }
  
    volumeAudio() {
      this.volumeBtn.addEventListener("click", () => {
        this.volumeBtn.querySelector('.volume').classList.toggle('active');
        this.volumeBtn.querySelector('.volume-none').classList.toggle('active');
        if (this.volumeBtn.querySelector('.volume-none').classList.contains('active')) {
          this.element.volume = 0;
        } else {
          this.element.volume = this.volumeRange.value / 100;
        }
      });
    }
    speedAudio() {
      this.speed.addEventListener("click", (evt) => {
        const speedList = [1, 1.5, 2];
        let speedIndexValue;
        if (speedList.findIndex((el) => el === parseFloat(evt.target.textContent)) + 1 < speedList.length) {
          speedIndexValue = speedList.findIndex((el) => el === parseFloat(evt.target.textContent)) + 1;
        } else {
          speedIndexValue = 0;
        }
        this.speed.textContent = speedList[speedIndexValue] + "x";
        this.element.playbackRate = speedList[speedIndexValue];
      });
    }
    infoAudio() {
      this.info.addEventListener('click', () => {
        this.info.querySelector(".info-tultip").classList.toggle("active");
      })
    }
    nextAudio() {
      this.element.addEventListener("ended", () => {
        if (musicList.length > 1) {
          index++;
        } else if (index > musicList.length - 1) {
          index = 0;
        }
        this.element.src = `wp-content/themes/my-theme/assets/audio/${musicList[index]}.mp3`;
        this.setTitle(index);
        this.musicPlay();
      });
    }
  
    initPlayer() {
      this.loadeddata();
      this.timeupdate();
      this.rangeProgress();
      this.listenerPlayBtn();
      this.setIntervalUpdate();
      this.volumeAudio();
      this.speedAudio();
      this.infoAudio();
      this.nextAudio();
    }
  }
  
  document.addEventListener('DOMContentLoaded', function() {
    if (document.querySelector(".player")) {
      const audio = new Audio(
        `wp-content/themes/my-theme/assets/audio/${musicList[index]}.mp3`
      );
      audio.preload = 'metadata';
      audio.className = 'audio';
      document.body.append(audio);
      const player = new AudioPlayer(audio, document.querySelector(".player"));
      player.initPlayer();
  
      //Subscription Lesson
      if (document.querySelector('.wp-block-audio')) {
        audio.src = document.querySelector('.wp-block-audio audio').src;
        document.querySelector('.wp-block-audio').style.display = 'none!important';
        document.querySelector('.wp-block-audio').classList.add('hidden');
        document.querySelector('.trial_audio .title').classList.add('hidden');
        document.querySelector('.trial_audio').style.marginTop = '40px';
  
      } else if (document.querySelector('.wp-audio-shortcode')) {
        // audio.src = document.querySelector('.wp-audio-shortcode').querySelector('a').textContent;
        audio.src = document.querySelector('.wp-audio-shortcode').querySelector('source').src;
        document.querySelector('.wp-audio-shortcode').style.display = 'none!important';
        document.querySelector('.wp-audio-shortcode').classList.add('hidden');
        document.querySelector('.trial_audio .title').classList.add('hidden');
        document.querySelector('.trial_audio').style.marginTop = '40px';
      } else {
        if (document.querySelector('.trial_audio')) {
          document.querySelector('.trial_audio').style.display = 'none';
        }
      }
      // if (!document.location.pathname.includes('subscription_lesson')) {
      //   player.setTitle(index);
      // }
    }
  });  
})();