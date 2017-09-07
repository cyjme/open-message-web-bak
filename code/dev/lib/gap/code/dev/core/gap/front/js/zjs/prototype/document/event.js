//require('./../element/event.js');
import {} from './../element/event.js';

var pt = HTMLDocument.prototype;

pt.on = Element.prototype.on;

pt.ready = function (fn) {
    if (this.readyState !== 'loading') {
        fn();
    } else if (this.addEventListener) {
        this.addEventListener('DOMContentLoaded', fn);
    } else {
        this.attachEvent('onreadystatechange', function () {
            if (this.readyState !== 'loading') {
                fn();
            }
        });
    }
};
