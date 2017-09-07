import {Zmask} from './../zmask/Zmask.class.js';
import {s} from './../../s';
import {addStyle} from './../../html/css';
import {tpl} from './../../tpl';

class Zpop {
    constructor(elem, opts = {}) {
        this.width = opts.width || 0;
        this.height = opts.height || 0;
        this.top = opts.top || 0;
        this.left = opts.left || 0;
        this.autohide = opts.autohide || false;

        this.buildStyle();

        this.mask = new Zmask();
        this.mask.append(this.getCtn());


        if (elem) {
            this.append(elem);
        }

        this.setSize(this.width, this.height);
        this.setPos(this.left, this.top);

        this.buildEvent();
    }

    buildEvent() {
        if (this.autohide) {
            this.mask.on('click', () => this.hide());
        }
    }

    getCtn() {
        if (this.ctn) {
            return this.ctn;
        }

        this.ctn = document.createElement('div');
        this.ctn.className = 'zpop';
        return this.ctn;
    }

    setSize(width, height) {
        let ctn = this.getCtn();

        if (width) {
            ctn.style.width = width + 'px';
        }
        if (height) {
            ctn.style.height = height + 'px';
        }
        //ctn.style.marginLeft = (-ctn.offsetWidth / 2) + 'px';
    }

    setPos(left, top) {
        let ctn = this.getCtn();

        if (left) {
            ctn.style.left = left + 'px';
        }

        if (top) {
            ctn.style.top = top + 'px';
        }
    }

    buildStyle() {
        if (s.elem('.zpop')) {
            return;
        }

        addStyle(tpl`
            .zpop {
                position: absolute;
                top: 100px;
                left: 50%;
                margin-bottom: 50px;
                border: 1px solid #ddd;
                background: #fff;
                border-radius: 3px;
                box-shadow: 0 0 7px rgba(0,0,0,.21);
                z-index: 77;
                overflow: hidden;
                height: auto;
            }
        `);
    }

    show() {
        this.mask.show();

        let ctn = this.getCtn();
        ctn.style.marginLeft = (-ctn.offsetWidth / 2) + 'px';
    }

    hide() {
        this.mask.hide();
    }

    append(elem) {
        let ctn = this.getCtn();
        if (typeof elem == 'string') {
            ctn.innerHTML = elem;
        } else {
            ctn.appendChild(elem);
        }
    }
}

export {Zpop};
