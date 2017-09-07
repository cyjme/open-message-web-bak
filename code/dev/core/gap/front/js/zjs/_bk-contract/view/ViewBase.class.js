import {s} from './../../s';
import {ZonEvent} from './../../zon/ZonEvent.class.js';
import {DtoBase} from './../dto/DtoBase.class.js';

let viewId = 0;

class ViewBase {
    constructor(ctn, dto) {
        if (typeof ctn == 'string') {
            ctn = s.elem(ctn);
        }

        if (ctn instanceof HTMLElement) {
            this.ctn = ctn;
        } else {
            throw 'ctn Error format in ViewBase';
        }
        this.id = 'view-' + viewId++;

        this.ctn._view = this;

        this.load(dto || new DtoBase());
        //this.dto = dto || new DtoBase();
        //this.dto.bind(this);
        //this.dto.on('change', () => this.bind());

        this.event = new ZonEvent();

        this.beforeRender();
        this.render();

        this.event.reg(this.ctn);

        this.event.trigger('prepare');

        //this.init();
        //this.boot();
        //this.register();
    }

    load(dto) {
        this.dto = dto;
        this.dto.bind(this);
        this.bind();
    }

    view(selector) {
        let elem = this.ctn.elem(selector);
        if (elem) {
            return elem._view || null;
        }
    }

    s(selector) {
        let viewArr = [];
        this.ctn.s(selector).forEach(elem => {
            if (elem._view) {
                viewArr.push(elem._view);
            }
        });
        return viewArr;
    }

    remove() {
        this.ctn.remove();
    }

    append(child) {
        this.ctn.appendChild(child.getCtn());
    }

    getCtn() {
        return this.ctn;
    }

    on(type, listener) {
        this.event.on(type, listener);
        return this;
    }

    show() {
        this.ctn.show();
    }

    hide() {
        this.ctn.hide();
    }

    bind() {
        if (!this.dto) {
            throw 'dto cannot be empty';
        }

        function bindVal(ctn, val, key = '') {
            let dtoClass = '.dto' + key;
            if (typeof val == 'string') {
                ctn.s(dtoClass).forEach(elem => {
                    if (elem._view && elem._view.setValue) {
                        elem._view.setValue(val);
                    } else if (elem.tagName == 'INPUT') {
                        elem.value = val;
                    } else if (elem.tagName == 'TEXTAREA') {
                        elem.value = val;
                        elem.innerHTML = val;
                    } else if (elem instanceof HTMLElement) {
                        elem.innerHTML = val;
                    } else {
                        throw 'unkown error in ViewBase';
                    }
                });
                return;
            }

            // check later
            if (key) {
                ctn.s(dtoClass).forEach(elem => {
                    if (elem._view && elem._view.setValue) {
                        elem._view.setValue(val);
                    }
                });
            }

            for (let subKey in val) {
                if (val.hasOwnProperty(subKey)) {
                    bindVal(ctn, val[subKey], key + '-' + subKey);
                }
            }
        }

        bindVal(this.ctn, this.dto.data);

        /*
        for (key in this.dto) {
            if (this.dto.hasOwnProperty(key)) {
                val = this.dto[key];
                dtoClass = '.dto-' + key;
                this.ctn.s(dtoClass).forEach(elem => {
                    if (elem._view && elem._view.setValue) {
                        elem._view.setValue(val);
                    } else if (elem.tagName == 'INPUT') {
                        elem.value = val;
                    } else if (elem instanceof HTMLElement) {
                        elem.innerHTML = val;
                    } else {
                        throw 'unkown error in ViewBase';
                    }
                });
            }
        }
        */
        //throw 'bind not implement';
    }

    fetch() {
        return this.dto;
        //throw 'fetch not implement';
    }

    beforeRender() {
    }

    render() {
        //throw 'render not implement';
    }

    startup() {
    }

    build() {
        this.startup();
        this.isBuilt = true;
        this.event.trigger('build');
    }
}

export {ViewBase};
