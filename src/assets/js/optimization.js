'use strict';

NodeList.prototype.forEach = NodeList.prototype.forEach || Array.prototype.forEach;

import smoothScroll from 'smooth-scroll';

document.onreadystatechange = function () {
    if (document.readyState === 'complete') {
        initYoutube();
        initSketchfab();
        smoothScroll.init();
    }
};

function initYoutube() {
    let div,
        v = document.getElementsByClassName('youtubePlayer');

    if (v.length > 0) {
        [...v].forEach((value, key) => {
            div = document.createElement('div');
            div.setAttribute('data-id', v[key].dataset.id);
            div.setAttribute('data-name', v[key].dataset.name);
            div.innerHTML = youtubeThumb(v[key].dataset.id, v[key].dataset.name);
            div.onclick = youtubeIframe;
            v[key].appendChild(div);
        });
    }
}

function youtubeThumb(id, name) {
    const thumb = `<img src="https://i.ytimg.com/vi/${id}/hqdefault.jpg" alt="${name} Play Button">`,
        play = '<div class="play"></div>';
    return thumb + play;
}

function youtubeIframe() {
    const iframe = document.createElement('iframe');
    iframe.setAttribute('src', `https://www.youtube.com/embed/${this.dataset.id}?autoplay=1`);
    iframe.setAttribute('frameborder', '0');
    iframe.setAttribute('allowfullscreen', '1');
    this.parentNode.replaceChild(iframe, this);
}

function initSketchfab() {
    let div,
        v = document.getElementsByClassName('sketchfabPlayer');

    if (v.length > 0) {
        [...v].forEach((value, key) => {
            div = document.createElement('div');
            div.setAttribute('data-id', v[key].dataset.id);
            div.setAttribute('data-id', v[key].dataset.name);
            div.innerHTML = sketchFabThumb(v[key].dataset.id, v[key].dataset.name);
            div.onclick = sketchFabIframe;
            v[key].appendChild(div);
        });
    }
}

function sketchFabThumb(id, name) {
    const thumb = `<img src="./assets/images/${id}.jpg" alt="${name} Play Button">`,
        play = '<div class="play"></div>';
    return thumb + play;
}

function sketchFabIframe() {
    const iframe = document.createElement('iframe');
    iframe.setAttribute('src', `https://sketchfab.com/models/${this.dataset.id}/embed?autostart=1`);
    iframe.setAttribute('frameborder', '0');
    iframe.setAttribute('allowfullscreen', 'true');
    iframe.setAttribute('mozallowfullscreen', 'true');
    iframe.setAttribute('webkitallowfullscreen', 'true');
    iframe.setAttribute('onmousewheel', '');
    this.parentNode.replaceChild(iframe, this);
}