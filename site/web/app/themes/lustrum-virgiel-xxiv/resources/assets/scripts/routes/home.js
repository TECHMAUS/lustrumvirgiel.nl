export default {
    init() {
        // JavaScript to be fired on the home page
    },
    finalize() {
        var playButton = document.getElementById("play-button");
        var video = document.getElementById("hero-video");

        // Event listener for the play/pause button
        playButton.addEventListener("click", function() {
            if (video.paused == true) {
                // Play the video
                video.play();
                $('#play-button').removeClass('mdi-play-circle').addClass('is-hidden');
            } else {
                // Pause the video
                video.pause();
                $('#play-button').addClass('mdi-play-circle').removeClass('is-hidden');
            }
        });
    },
};