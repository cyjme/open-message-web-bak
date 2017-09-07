import {Event} from './../../event/Event.class.js';

class DtoBase {
    constructor(data) {
        this.load(data);
        this.bindMap = {};
        this.data = {};

        this.event = new Event();
    }

    load(data) {
        let index;
        for(index in data) {
            if (data.hasOwnProperty(index)) {
                this.set(index, data[index]);
                //this[index] = data[index];
            }
        }
    }

    change(data) {
        this.load(data);
        this.event.trigger('change');
        return this;
    }

    set(key, value) {
        this.data[key] = value;
        //this.keys[key] = 1;
        //this[key] = value;
        this.event.trigger('change');
        return this;
    }

    get(key) {
        return this.data[key] || '';
        //return this[key] || '';
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
        if (item.bind) {
            this.on('change', () => item.bind());
        }
    }
}

export {DtoBase};
