const pt = Element.prototype;
//const animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
const animationEnd = 'animationend';

pt.fadeOut = function() {
    this.addClass('animated fadeOut');
    this.one(animationEnd, () => {
        this.removeClass('animated fadeOut');
        this.hide();
    });
};
pt.animateCss = function (animationName) {
    this.addClass('animated ' + animationName);
    this.one(animationEnd, function() {
        this.removeClass('animated ' + animationName);
    });
};
