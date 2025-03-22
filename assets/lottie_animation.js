document.addEventListener('DOMContentLoaded', () => {
    initializeLottieAnimation('lottie-animation', 'assets/json/loading.json');

    const container = document.querySelector('.content');
    const passwordGrid = document.querySelector('.password-grid');
    const passwordList = document.querySelector('.password-list');

    function initializeLottieAnimation(containerId, jsonPath) {
        lottie.loadAnimation({
            container: document.getElementById(containerId),
            renderer: 'svg',
            loop: true,
            autoplay: true,
            path: jsonPath,
        });
    }

    function displayNoDataAnimation() {
        const lottieContainer = createLottieContainer(container, 'lottie-no-data');
        setLottieContainerDimensions(lottieContainer);
        loadNoDataAnimation(lottieContainer, 'assets/lottie/no_data.json');
    }

    function createLottieContainer(parent, id) {
        let lottieContainer = document.getElementById(id);
        if (!lottieContainer) {
            lottieContainer = document.createElement('div');
            lottieContainer.id = id;
            parent.appendChild(lottieContainer);
        }
        return lottieContainer;
    }

    function setLottieContainerDimensions(lottieContainer) {
        const screenWidth = window.innerWidth;
        if (screenWidth < 400) {
            lottieContainer.style.width = '100%';
            lottieContainer.style.height = '200px';
        } else if (screenWidth < 768) {
            lottieContainer.style.width = '300px';
            lottieContainer.style.height = '300px';
        } else {
            lottieContainer.style.width = '400px';
        }
        lottieContainer.style.margin = 'auto';
    }

    function loadNoDataAnimation(container, jsonPath) {
        lottie.loadAnimation({
            container: container,
            renderer: 'svg',
            loop: true,
            autoplay: true,
            path: jsonPath,
        });
    }

    function checkForEmptyPasswordLists() {
        if (passwordGrid && passwordGrid.children.length === 0) {
            passwordGrid.style.display = 'none';
            displayNoDataAnimation();
        } else if (passwordList && passwordList.children.length === 0) {
            passwordList.style.display = 'none';
            displayNoDataAnimation();
        }
    }

    function showLoadingScreen() {
        setTimeout(() => {
            document.body.classList.add('loaded');
        }, 5000);
    }

    showLoadingScreen();
    checkForEmptyPasswordLists();
});


