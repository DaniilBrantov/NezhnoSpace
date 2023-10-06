const createCustomAudioPlayer = (audioSrc) => {
  if (typeof audioSrc !== 'string' || !audioSrc.trim()) {
      console.error('Ошибка: Неправильный путь к аудио.');
      return null;
  }

  const createEl = (tag, className = '', attributes = {}) => {
      const element = document.createElement(tag);
      element.className = className;
      for (const key in attributes) {
          element.setAttribute(key, attributes[key]);
      }
      return element;
  };

  const audioContainer = createEl('div', 'custom-audio-container');

  audioContainer.innerHTML = `
  <div class="custom-audio-player">
    <div class="time-display">
      <span class="duration">00:00</span> 
      <span class="current-time">00:00</span>
    </div>
    <div class="progress-container">
      <input type="range" class="progress" min="0" max="100" value="0">
    </div>
    <div class="controls">
      <button class="mute-button" title="Mute">
        <svg class="mute-icon" width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M15 6.50001C16.333 8.27801 16.333 11.722 15 13.5M18 3.00001C21.988 6.80801 22.012 13.217 18 17M1 12.959V7.04001C1 6.46601 1.448 6.00001 2 6.00001H5.586C5.71833 5.99954 5.8492 5.97228 5.97071 5.91986C6.09222 5.86744 6.20185 5.79095 6.293 5.69501L9.293 2.30701C9.923 1.65101 11 2.11601 11 3.04301V16.957C11 17.891 9.91 18.352 9.284 17.683L6.294 14.314C6.20259 14.2153 6.09185 14.1365 5.96867 14.0825C5.84549 14.0285 5.71251 14.0004 5.578 14H2C1.448 14 1 13.534 1 12.959Z" stroke="#7264AA" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <svg class="unmute-icon" width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M21 13L15 7M21 7L15 13" stroke="#7264AA" stroke-width="2" stroke-linecap="round"/>
            <path d="M1 12.959V7.04001C1 6.46601 1.448 6.00001 2 6.00001H5.586C5.71833 5.99954 5.8492 5.97228 5.97071 5.91986C6.09222 5.86744 6.20185 5.79095 6.293 5.69501L9.293 2.30701C9.923 1.65101 11 2.11601 11 3.04301V16.957C11 17.891 9.91 18.352 9.284 17.683L6.294 14.314C6.20259 14.2153 6.09185 14.1365 5.96867 14.0825C5.84549 14.0285 5.71251 14.0004 5.578 14H2C1.448 14 1 13.534 1 12.959Z" stroke="#7264AA" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </button>
      <button class="play-button" title="Play">
        <svg class="play-icon" width="25" height="25" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M38.5 20C38.5 30.2173 30.2173 38.5 20 38.5C9.78273 38.5 1.5 30.2173 1.5 20C1.5 9.78273 9.78273 1.5 20 1.5C30.2173 1.5 38.5 9.78273 38.5 20Z" fill="#7264AA" stroke="#7264AA" stroke-width="3" />
          <path d="M30.5 19.134C31.1667 19.5189 31.1667 20.4811 30.5 20.866L15.5 29.5263C14.8333 29.9112 14 29.4301 14 28.6603L14 11.3397C14 10.5699 14.8333 10.0888 15.5 10.4737L30.5 19.134Z" fill="white" />              
        </svg>
        <svg class="pause-icon" width="25" height="25" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
          <circle cx="20" cy="20" r="20" fill="#7264AA" />
          <rect x="15" y="10" width="4" height="21" rx="2" fill="white" />
          <rect x="21" y="10" width="4" height="21" rx="2" fill="white" />              
        </svg>
      </button>
      <div class="speed-buttons-container">
        <select id="speed-selector" class="speed-selector">
          <option value="1" class="speed-button" data-speed="1">1x</option>
          <option value="1.2" class="speed-button" data-speed="1.2">1.2x</option>
          <option value="1.5" class="speed-button" data-speed="1.5">1.5x</option>
          <option value="1.7" class="speed-button" data-speed="1.7">1.7x</option>
          <option value="2" class="speed-button" data-speed="2">2x</option>
        </select>
      </div>
    </div>
    <audio preload="metadata" class="audio" src="${audioSrc}" loop></audio>
  </div>
  `;

  const audioElement = audioContainer.querySelector('.audio');
  const playButton = audioContainer.querySelector('.play-button');
  const playIcon = audioContainer.querySelector('.play-icon');
  const pauseIcon = audioContainer.querySelector('.pause-icon');
  const progress = audioContainer.querySelector('.progress');
  const currentTimeElement = audioContainer.querySelector('.current-time');
  const durationElement = audioContainer.querySelector('.duration');
  const volume = audioContainer.querySelector('.volume');
  const muteButton = audioContainer.querySelector('.mute-button');
  const muteIcon = audioContainer.querySelector('.mute-icon');
  const unmuteIcon = audioContainer.querySelector('.unmute-icon');
  const speedButtons = audioContainer.querySelectorAll('.speed-button');
  const speedSelector = audioContainer.querySelector('#speed-selector');

  const setPlaybackSpeed = (speed) => {
      audioElement.playbackRate = speed;
  };

  speedSelector.addEventListener('change', () => {
      const selectedSpeed = parseFloat(speedSelector.value);
      setPlaybackSpeed(selectedSpeed);
  });

  speedButtons.forEach((button) => {
      button.addEventListener('click', () => {
          const speed = parseFloat(button.getAttribute('data-speed'));
          setPlaybackSpeed(speed);
          speedSelector.value = speed.toString();
      });
  });

  const togglePlayPauseButton = () => {
    if (audioElement.paused) {
      audioElement.play();
    } else {
      audioElement.pause();
    }
    updatePlayButton(); 
  };
  
  const updatePlayButton = () => {
    if (audioElement.paused) {
      playIcon.style.display = 'inline'; 
      pauseIcon.style.display = 'none'; 
    } else {
      playIcon.style.display = 'none';   
      pauseIcon.style.display = 'inline';
    }
  };

  updatePlayButton();

  playButton.addEventListener('click', togglePlayPauseButton);

  const formatTime = (timeInSeconds) => {
      const minutes = Math.floor(timeInSeconds / 60);
      const seconds = Math.floor(timeInSeconds % 60);
      return `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
  };

  const updateAudioTime = () => {
      currentTimeElement.textContent = formatTime(audioElement.currentTime);
      durationElement.textContent = formatTime(audioElement.duration);
      progress.value = (audioElement.currentTime / audioElement.duration) * 100;
  };

  audioElement.addEventListener('timeupdate', updateAudioTime);

  audioElement.addEventListener('error', () => {
      console.error('Произошла ошибка при загрузке аудио.');
  });

  progress.addEventListener('input', () => {
      const seekTime = (progress.value / 100) * audioElement.duration;
      audioElement.currentTime = seekTime;
  });

  const toggleMute = () => {
      if (audioElement.muted) {
          audioElement.muted = false;
      } else {
          audioElement.muted = true;
      }
      updateMuteButton();
  };

  muteButton.addEventListener('click', toggleMute);

  const updateMuteButton = () => {
      if (audioElement.muted) {
          muteIcon.style.display = 'none';
          unmuteIcon.style.display = 'inline';
      } else {
          muteIcon.style.display = 'inline';
          unmuteIcon.style.display = 'none';
      }
  };

  updateMuteButton();

  return audioContainer;
};

const audioSrc = 'wp-content/themes/NezhnoSpace/audio/theme_1.mp4';
const customAudioPlayer = createCustomAudioPlayer(audioSrc);

if (customAudioPlayer) {
  document.body.appendChild(customAudioPlayer);
}
