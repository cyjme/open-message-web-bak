Element.prototype.remove = function () {
    if (this.parentNode) {
        this.parentNode.removeChild(this);
    }
};
