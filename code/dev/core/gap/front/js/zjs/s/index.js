require('./../prototype');

function s(selector) {
    return document.querySelectorAll(selector);
}

s.elem = (selector) => document.querySelector(selector);

export {s};
