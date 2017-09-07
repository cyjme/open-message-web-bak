import {Event} from './../event/Event.js';
import {pageAttr} from 'zjs/html/page-attr';
import {request} from 'zjs/http/request';
import {s} from './../s';

class Loader {
    constructor() {
        this.event = new Event();

        document.ready(() => {
            const localeKey = pageAttr('localeKey');
            const listTransGroup = pageAttr('list-trans-group');

            if(!listTransGroup) {
                this.load();
                return;
            }

            if(window.transGroup) {
                this.load();
                return;
            }

            request.postJson(listTransGroup, {localeKey: localeKey, group: 'js'}).then(
                data => {
                    window.transGroup = data;
                    this.load();
                }
            );
        });
    }

    on(type, listener) {
        this.event.on(type, listener);
    }

    load() {
        s('.loader').forEach(elem => {
            let evs = elem.getAttribute('zon-load').trim();
            evs.split(',').forEach(ev => this.event.trigger(ev, elem));
        });
    }
}

export {Loader};
