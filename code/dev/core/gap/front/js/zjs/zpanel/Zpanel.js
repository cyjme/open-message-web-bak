import {s} from './../s';
//import {tpl} from './../tpl';

class Zpanel {
    constructor(ctn, opts = {}) {
        if (typeof ctn == 'string') {
            ctn = s.elem(ctn);
        }
        this.ctn = ctn;
        this.ctn.hide();

        this.autohide = true;

        if (opts.hasOwnProperty('autohide')) {
            this.autohide = opts.autohide;
        }

        if (this.autohide) {
            document.on('click', (e) => {
                if (e.target == this.ctn) {
                    return;
                }

                if (this.ctn.contains(e.target)) {
                    return;
                }

                if (!this.isHide) {
                    this.hide();
                }
            });
        }
    }

    show() {
        this.ctn.show();
        this.isHide = false;
    }

    hide() {
        this.ctn.hide();
        this.isHide = true;
    }
}

export {Zpanel};
