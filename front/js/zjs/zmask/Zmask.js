import {s} from './../s';

// require https://daneden.github.io/animate.css/

class Zmask {
    constructor(ctn) {
        if (typeof ctn == 'string') {
            ctn = s.elem(ctn);
        }

        if (ctn instanceof HTMLElement) {
            this.ctn  = ctn;
        } else {
            throw 'ctn Error format in Zmask';
        }

        this.ctn.addClass('zmask');
        this.ctn.removeClass('hide');

        this.outer = this.getOuter();
        this.outer.appendChild(this.ctn);

        this.reg();
    }

    reg() {
        if (this.ctn.getAttribute('data-hidemode') == 'auto') {
            this.ctn.on('click', () => {
                this.outer.hide();
            });
        }
    }

    hide() {
        this.outer.fadeOut();
    }

    pop(selector) {
        this.outer.show();
        this.ctn.s('.zpop').forEach(elem => elem.hide());
        this.ctn.s((selector || '') + '.zpop')
            .forEach(elem => {
                elem.show();
                elem.style.marginLeft = (-elem.offsetWidth / 2) + 'px';
                elem.animateCss('pulse');
            });
    }

    getOuter() {
        let outer = s.elem('#zmask-outer');
        if (outer) {
            return outer;
        }

        outer = document.createElement('div');
        outer.id = 'zmask-outer';
        outer.className = 'zmask-outer';

        document.body.appendChild(outer);
        outer.hide();

        return outer;
    }
}

export {Zmask};
