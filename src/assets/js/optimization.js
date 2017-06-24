'use strict';

NodeList.prototype.forEach = NodeList.prototype.forEach || Array.prototype.forEach;

document.onreadystatechange = function () {
    if (document.readyState === 'complete') {
        initYoutube();
    }
};

function initYoutube() {
    let div, n,
        v = document.getElementsByClassName('youtubePlayer');

    if (v.length > 0) {
        [...v].forEach((value,key) => {
            div = document.createElement('div');
            div.setAttribute('data-id', v[key].dataset.id);
            div.innerHTML = youtubeThumb(v[key].dataset.id);
            div.onclick = youtubeIframe;
            v[key].appendChild(div);
        });
    }
}

function youtubeThumb(id) {
    const thumb = '<img src="https://i.ytimg.com/vi/ID/hqdefault.jpg" alt="youtube video placeholder">',
        play = '<div class="play"></div>';
    return thumb.replace('ID', id) + play;
}

function youtubeIframe() {
    const iframe = document.createElement('iframe');
    const embed = 'https://www.youtube.com/embed/ID?autoplay=1';
    iframe.setAttribute('src', embed.replace('ID', this.dataset.id));
    iframe.setAttribute('frameborder', '0');
    iframe.setAttribute('allowfullscreen', '1');
    this.parentNode.replaceChild(iframe, this);
}