//import {ViewBase} from './../contract/view/ViewBase.class.js';
import {s} from './../s';

//const Zviews = [];
const Zopts = {};

function zreg(ctn) {
    let views = [];

    for (let selector in Zopts) {
        if (Zopts.hasOwnProperty(selector)) {
            let viewClass = Zopts[selector];
            (ctn ? ctn.s(selector) : s(selector)).forEach(elem => {
                if (!elem._view) {
                    let view = new viewClass(elem);
                    view.on('prepare', () => zreg(elem));
                    views.push(view);
                }
            });
        }
    }

    views.forEach(view => view.hasBuilt || view.build());
}

function zview(opts) {
    for(let selector in opts) {
        if (opts.hasOwnProperty(selector)) {
            Zopts[selector] = opts[selector];
        }
    }

    zreg();
}

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
