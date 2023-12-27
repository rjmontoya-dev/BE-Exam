<template>
  <div class="border-4 border-red-500" >
    <video  ref="videoPlayer" class="video-js vjs-theme-dt" />
  </div>
</template>

<script>
import videojs from 'video.js';
import 'video.js/dist/video-js.css';
import '@digitaltheatre/videojs-theme-dt/dist/theme/index.css';

export default {
  name: 'VideoPlayer',
  props: {
    videoUrl: {
      type: String,
      required: true,
    },
  },
  data() {
    return {
      player: null,
    };
  },
  methods: {
    updatePlayerSource(newUrl) {

      if (this.player) {
        this.player.dispose();
      }

      this.initializePlayer(newUrl);
    },
    initializePlayer(newUrl) {
      var videoPlayerElement = videojs.dom.createEl('video',{ref:'videoPlayer'});
      this.player = videojs(videoPlayerElement, {
        controls: false,
        autoplay: true,
        sources: [{ src: newUrl, type: 'video/mp4' }],
      }, () => {
        this.player.log('onPlayerReady', this);
      });
    },
  },
  watch: {
    videoUrl(newUrl) {
      this.updatePlayerSource(newUrl);
    },
  },
  mounted() {
    this.$nextTick(() => {
      this.initializePlayer(this.props.videoUrl);
    });
  },
  beforeDestroy() {
    if (this.player) {
      this.player.dispose();
    }
  },
};
</script>
