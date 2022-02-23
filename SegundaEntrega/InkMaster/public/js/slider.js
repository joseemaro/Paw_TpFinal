document.addEventListener("DOMContentLoaded", function() {

    let index = 1;
    slider(index);

    function next(n) {
        slider(index += n);
    }

    function positionSlide(n) {
        slider(index = n);
    }

    setInterval(function tiempo() {
        slider(index += 1)
    }, 4000);


    function slider(n) {
        let i;
        let slides = document.getElementsByClassName('miSlider');
        let bars = document.getElementsByClassName('bar');

        if (n > slides.length) {
            index = 1;
        }
        if (n < 1) {
            index = slides.length;
        }
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = 'none';
        }
        for (i = 0; i < bars.length; i++) {
            bars[i].className = bars[i].className.replace(" active-slider", "");
        }

        slides[index - 1].style.display = 'block';
        bars[index - 1].className += ' active-slider';

    };
});
