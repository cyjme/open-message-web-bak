import {s} from './../s';
import {View} from './../base/View.js';

const zview = View.build;

zview.view = function (selector) {
    let elem = s.elem(selector);
    if (elem && elem._view) {
        return elem._view;
    }
    return null;
};

zview.s = function (selector) {
    let viewArr = [];
    s(selector).forEach(elem => {
        if (elem._view) {
            viewArr.push(elem._view);
        }
    });
    return viewArr;
};

export {zview};
