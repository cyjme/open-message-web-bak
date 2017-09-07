import {s} from './../s';
import {ZonEvent} from './../zon/ZonEvent.js';
import {tpl} from './../tpl';
import {pageAttr} from './../html/page-attr';
import {trans} from './../trans';

const Zopts = {};

let viewId = 0;

class View {
    constructor(ctn) {
        if (typeof ctn == 'string') {
            ctn = s.elem(ctn);
        }

        if (ctn instanceof HTMLElement) {
            this.ctn = ctn;
        } else {
            throw 'ctn Error format in View';
        }
        this.tpl = tpl;
        this.pageAttr = pageAttr;
        this.trans = trans;

        this.id = 'v' + viewId++;
        this.dtoElems = {};

        this.ctn._view = this;

        this.event = new ZonEvent();

        this.data = null;

        let script = this.ctn.firstElementChild;
        if (script && script.tagName == 'SCRIPT') {
            this.data = JSON.parse(script.text);
            script.remove();
        }

        // -------- //

        this.beforeRender();
        this.render();

        this.event.reg(this.ctn);

        View.reg(this.ctn);
        this.build();
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

    trigger(type, ...args) {
        this.event.trigger(type, ...args);
    }

    show() {
        this.ctn.show();
    }

    hide() {
        this.ctn.hide();
    }

    setElemVal(elem, val) {
        if (elem._view) {
            elem._view.setValue(val);
        } else if (elem.tagName == 'INPUT') {
            elem.value = val;
        } else if (elem.tagName == 'SELECT') {
            elem.elem(`option[value="${val}"]`).selected = true;
        } else if (elem.tagName == 'TEXTAREA') {
            elem.value = val;
            elem.innerHTML = val;
        } else if (elem instanceof HTMLElement) {
            elem.innerHTML = val;
        } else {
            throw 'unkown error in View';
        }
    }

    scriptJson(obj) {
        return `<script type="text/javascript">${JSON.stringify(obj)}</script>`;
    }

    set(key, val) {
        if (!val) {
            val = '';
        }

        // support class="dto-dtoName" will delete later
        let dtoClass = ['.dto', key.replace('.', '-')].join('-');
        let nodeList = this.ctn.s(dtoClass);

        if (nodeList.length > 0) {
            nodeList.map(elem => this.setElemVal(elem, val));
            return;
        }

        // ${this.d('dtoName')}
        if (this.dtoElems.hasOwnProperty(key)) {
            this.dtoElems[key].map(elem => this.setElemVal(elem, val));
            return;
        }

        if (typeof val != 'string') {
            for (let subKey in val) {
                if (val.hasOwnProperty(subKey)) {
                    this.set(key + '.' + subKey, val[subKey]);
                }
            }
        }

        /*
        let dtoClass = ['.dto', key].join('-');
        if (typeof val == 'string') {
            this.ctn.s(dtoClass).forEach(elem => this.setElemVal(elem, val));
            return;
        }

        // check later
        if (key) {
            this.ctn.s(dtoClass).forEach(elem => {
                if (elem._view && elem._view.setValue) {
                    elem._view.setValue(val);
                }
            });
        }

        for (let subKey in val) {
            if (val.hasOwnProperty(subKey)) {
                this.set(key + '-' + subKey, val[subKey]);
            }
        }
        */
    }

    setValue(val) {
        throw 'View setValue not implement: cannot setValue: ' + val;
    }

    beforeRender() {
    }

    render() {
    }

    startup() {
    }

    d(dtoName) {
        return `dto-view="${this.id}" dto-key="${dtoName}"`;
    }

    build() {
        if (this.isBuilt) {
            return;
        }

        this.bindDtoElem();
        this.startup();
        this.isBuilt = true;
        this.event.trigger('build');
        this.afterBuild();
    }

    afterBuild() {
    }

    bindDtoElem() {
        this.ctn.s(`[dto-view="${this.id}"]`).map(elem => {
            let key = elem.getAttribute('dto-key');
            if (!this.dtoElems[key]) {
                this.dtoElems[key] = [];
            }
            this.dtoElems[key].push(elem);
        });
    }
}

View.reg = function(ctn) {
    let views = [];

    for (let selector in Zopts) {
        if (Zopts.hasOwnProperty(selector)) {
            let viewClass = Zopts[selector];
            if (!viewClass) {
                throw 'cannot find viewClass';
            }
            (ctn ? ctn.s(selector) : s(selector)).forEach(elem => {
                if (!elem._view) {
                    views.push(new viewClass(elem));
                }
            });
        }
    }
};

View.build = function(opts) {
    for(let selector in opts) {
        if (opts.hasOwnProperty(selector)) {
            Zopts[selector] = opts[selector];
        }
    }

    View.reg();
};

export {View};
