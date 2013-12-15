// very based http://stackoverflow.com/questions/667555/detecting-idle-time-in-javascript-elegantly
// refresh when idle 
idleTime = 0;
$(document).ready(function () {
    //Increment the idle time counter every minute.
    var idleInterval = setInterval(timerIncrement, 5000); // count every 5 seconds

    //Zero the idle timer on mouse movement.
    $(this).mousemove(function (e) {
        idleTime = 0;
    });
    $(this).keypress(function (e) {
        idleTime = 0;
    });
});

function timerIncrement() {
    idleTime = idleTime + 5; // 5 seconds
    if (idleTime >= 30) { // 30 seconds
        window.location.reload();
    }
}