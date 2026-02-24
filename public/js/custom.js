document.addEventListener('alpine:init', () => {
    Alpine.data('lessonPlayer', (watchSeconds) => ({
        player: null,
        showModal: false,
        isCompleting: false,
        lastSavedTime: 0,
        init() {
            this.$nextTick(() => {
                if (this.$refs.player) {
                    this.player = new Plyr(this.$refs.player, {
                        controls: ['play-large', 'play', 'rewind', 'fast-forward', 'progress', 'current-time', 'duration', 'mute', 'volume', 'captions', 'settings', 'fullscreen'],
                        settings: ['quality', 'speed'],
                        speed: { selected: 1, options: [0.5, 0.75, 1, 1.25, 1.5, 2] },
                        youtube: { noCookie: true, rel: 0, showinfo: 0, iv_load_policy: 3, modestbranding: 1 }
                    });

                    this.player.on('ready', () => {
                        if (watchSeconds > 0) {
                            setTimeout(() => {
                                this.player.currentTime = watchSeconds;
                            }, 500);
                        }
                    });

                    this.player.on('timeupdate', () => {
                        let currentTime = Math.floor(this.player.currentTime);
                        if (currentTime > 0 && Math.abs(currentTime - this.lastSavedTime) >= 10) {
                            this.lastSavedTime = currentTime;
                            if (this.$wire) {
                                this.$wire.saveProgress(currentTime);
                            }
                        }
                    });

                    this.player.on('pause', () => {
                        let currentTime = Math.floor(this.player.currentTime);
                        if (currentTime > 0 && currentTime !== this.lastSavedTime) {
                            this.lastSavedTime = currentTime;
                            if (this.$wire) {
                                this.$wire.saveProgress(currentTime);
                            }
                        }
                    });
                }
            });
        }
    }));
});
