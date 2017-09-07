var pt = Element.prototype;

pt.on = function(types, handler, useCapture) {
    types.split(' ').forEach(type => {
        if (this.addEventListener) {
            this.addEventListener(type, handler, useCapture);
        } else if (this.attachEvent) {
            this.attachEvent('on' + type, handler);
        }
    });
    return this;
};
pt.one = function(types, handler) {
    types.split(' ').forEach(type => {
        this.addEventListener(type, handler, {once: true});
    });
};
