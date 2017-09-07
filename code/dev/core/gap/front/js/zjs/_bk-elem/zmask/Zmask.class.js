import {tpl} from './../../tpl';
import {addStyle} from './../../html/css';
import {s} from './../../s';

class Zmask {
    constructor() {
        this.outer = this.getOuter();
        this.ctn = this.outer.elem('#zmask-ctn');

        this.buildStyle();
    }

    on(type, handler, useCapture) {
        return this.ctn.on(type, handler, useCapture);
    }

    getOuter() {
        let outer = s.elem('#zmask-outer');
        if (outer) {
            return outer;
        }

        outer = document.createElement('div');
        outer.id = 'zmask-outer';
        outer.className = 'hide';

        let ctn = document.createElement('div');
        ctn.id = 'zmask-ctn';

        document.body.appendChild(outer);
        outer.appendChild(ctn);

        return outer;
    }

    buildStyle() {
        addStyle(tpl`
            #zmask-outer {
                position: absolute;
                top: 0;
                width: 100%;
                z-index: 10000;
                margin: 0;
                padding: 0;
                border: 0;
                font: inherit;
                font-size: 100%;
                vertical-align: baseline;
            }
            #zmask-ctn {
                position: fixed;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                background: rgba(221,221,221,.9);
                overflow-y: auto;
            }
        `);
    }

    show() {
        this.outer.removeClass('hide');
    }

    hide() {
        this.outer.addClass('hide');
    }

    append(elem) {
        this.ctn.appendChild(elem);
    }
}

export {Zmask};
