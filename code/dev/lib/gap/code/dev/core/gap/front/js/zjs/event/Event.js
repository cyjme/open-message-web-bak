// https://github.com/insane-jo/event-emitter/blob/master/index.es6

class Event {
    constructor(opts = {}) {
        this.events = [];
        this.listeners = {};

        this.isStrict = opts.isStrict || false;
    }

    on(type, listener) {
        if (typeof listener !== 'function') {
            throw TypeError('listener must be function');
        }

        if (this.events.indexOf(type) === -1) {
            this.events.push(type);
            this.listeners[type] = [];
        }

        this.listeners[type].push({fn: listener});
    }

    hasEvent(type) {
        return this.listeners[type] && this.listeners[type].length;
    }

    trigger(type, ...args) {
        if (!this.hasEvent(type)) {
            if (this.isStrict) {
                throw 'No listeners specified for event: ' + type;
            }

            return;
        }
        let typeListeners = this.listeners[type];

        typeListeners.forEach(listener => listener.fn.apply(null, args));
    }

    triggerAll(...args) {
        this.events.forEach(type => this.trigger(type, ...args));
    }
}

export {Event};
