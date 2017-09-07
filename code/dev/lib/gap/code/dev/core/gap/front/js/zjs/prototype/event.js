var pt = Event.prototype;

pt.cancel = function() {
    if (this.stopPropagation) {
        this.stopPropagation();
    }
    this.cancelBubble = true;
};

pt.stop = function() {
    if (this.preventDefault) {
        this.preventDefault();
    } else {
        this.returnValue =false;
    }
};
