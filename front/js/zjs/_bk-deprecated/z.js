const version = "0.1.0";
//const [arr, obj] = [[], {}];

const z = {
    version: version,
    uuid: 0,
    isArray: Array.isArray,
    generateUuid() {
        z.uuid += 1;
        return `${(new Date()).getTime().toString()}-${z.uuid}`;
    },
    type(obj) {
        if (obj === null) {
            return 'null';
        }

        if (obj === undefined) {
            return 'undefined';
        }
        return Object.prototype.toString.call(obj).slice(8, -1).toLowerCase();
    },
    ready(fn) {
        if (document.readyState !== 'loading') {
            fn();
        } else if (document.addEventListener) {
            document.addEventListener('DOMContentLoaded', fn);
        } else if (document.attachEvent) {
            document.attachEvent('onreadystatechange', function () {
                if (document.readyState !== 'loading') {
                    fn();
                }
            });
        }
    },
    /*
    query(selector) {
        return document.querySelector(selector);
    },
    queryAll(selector) {
        return document.querySelectorAll(selector);
    },
    */
    addEvent(elem, type, handler, useCapture) {
        if (elem.addEventListener) {
            elem.addEventListener(type, handler, useCapture);
        } else if (elem.attachEvent) {
            elem.attachEvent('on' + type, handler);
        }
    },
    /*
    stopEvent(e = window.event) {
        if (e.stopPropagation) {
            e.stopPropagation();
        }

        e.cancelBubble = true;
    },
    cancelEvent(e = window.event) {
        if (e.preventDefault) {
            e.preventDefault();
        } else {
            e.returnValue =false;
        }
    }
    */
};

export {z};
