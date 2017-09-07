import {Event} from './../event/Event.js';

class Dto {
    constructor() {
        //this.load(data);
        this.data = {};
        this.bindMap = {};
        //this.data = data || {};

        this.event = new Event();
    }

    load(data) {
        let index;
        for(index in data) {
            if (data.hasOwnProperty(index)) {
                this.set(index, data[index]);
            }
        }
        return this;
    }

    clear() {
        for (let key in this.data) {
            this.set(key, null);
        }
    }

    set(key, value) {
        this.data[key] = value;
        this.event.trigger('change', key, value);
        return this;
    }

    get(key) {
        return this.data[key] || '';
    }

    on(type, listener) {
        this.event.on(type, listener);
        return this;
    }

    bind(item) {
        if (!item.id) {
            return;
        }
        if (this.bindMap[item.id]) {
            return;
        }

        this.bindMap[item.id] = 1;
        if (item.set) {
            this.on('change', (key, value) => {
                item.set(key, value);
            });
        }
    }
}

export {Dto};
