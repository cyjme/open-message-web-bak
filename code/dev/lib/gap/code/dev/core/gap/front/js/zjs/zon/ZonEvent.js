import {Event} from './../event/Event.js';
import {s} from './../s';

const types = [
    'click',
    'mousedown',
    'mouseup',
    'keyup',
    'submit'
];

class ZonEvent extends Event {
    triggerZon(zons, elem, e) {
        if (zons) {
            zons.split(',').forEach(zon => this.trigger(zon.trim(), elem, e));
        }
    }

    reg(ctn) {
        (ctn ? ctn.s('.zon') : s('.zon')).forEach(elem => {
            //document.ready(() => this.triggerZon(elem.getAttribute('zon-load'), elem));
            //this.on('load', () => this.triggerZon(elem.getAttribute('zon-load'), elem));

            types.forEach(type => {
                elem.on(type, (e) => this.triggerZon(elem.getAttribute('zon-' + type), elem, e));
            });
        });
    }
}

export {ZonEvent};
