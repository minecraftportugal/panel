App.Sound = {

};

App.Sound.bank = {
    "break" : "break.ogg.wav",
    "fuse" : "fuse.ogg.wav",
    "levelup" : "levelup.ogg.wav",
    "orb" : "orb.ogg.wav"
};


App.Sound.init = function() {

    $.each(App.Sound.bank, function(k, v) {
        var audioElement = document.createElement('audio');
        audioElement.setAttribute('id', 'audio_' + k);
        audioElement.setAttribute('src', '/sounds/' + v);
        audioElement.load()
        App.Sound.bank[k] = audioElement;
    });
};

App.Sound.play = function(sound) {
    if (App.Desktop.settings.sounds) {
        App.Sound.bank[sound].play();
    }
};

App.Sound.init();