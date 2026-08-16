
document.addEventListener("DOMContentLoaded", function () {

    const modal = document.getElementById('modalVideo');
    const video = document.getElementById('videoPlayer');

    // Ao abrir o modal
    modal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const videoSrc = button.getAttribute('data-video');

        video.querySelector('source').src = videoSrc;
        video.load();
        video.play();
    });

    // Ao fechar o modal
    modal.addEventListener('hidden.bs.modal', function () {
        video.pause();
        video.currentTime = 0;
    });

});