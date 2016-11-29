// Grab elements, create settings, etc.
var video = document.getElementById('video');

// Trigger photo take
/*
document.getElementById("snap").addEventListener("click", function() {
  context.drawImage(video, 0, 0, 640, 480);
});
*/
// Get access to the camera!
if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
// Not adding `{ audio: true }` since we only want video now
  navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream) {
  video.src = window.URL.createObjectURL(stream);
    video.play();
  });
}