// Load the Lottie animation
const animation = lottie.loadAnimation({
    container: document.getElementById('lottie-animation'), // the dom element that will contain the animation
    renderer: 'svg',
    loop: true,
    autoplay: true,
    path: 'assets/json/loading.json' // the path to the animation json
});

// Hide the loading screen once the content is loaded with a 5-second delay
window.addEventListener('load', () => {
    setTimeout(() => {
        document.body.classList.add('loaded');
    }, 5000);  // 5000 milliseconds equals 5 seconds
});