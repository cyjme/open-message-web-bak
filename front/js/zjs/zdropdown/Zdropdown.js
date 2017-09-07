
let currentZdd = null;

document.on('click', (e) => {
    if (!currentZdd) {
        return;
    }

    if (currentZdd.contains(e.target)) {
        return;
    }

    currentZdd.hide();
});

class Zdropdown {
    constructor(btn, wrap) {
        this.btn = btn;
        //this.btn.addClass('zdropdown-btn');

        this.wrap = wrap;
        //this.wrap.addClass('zdropdown-wrap');
        this.wrap._zdropdown = this;

        const iconDown = btn.elem('.icon-down');
        if (iconDown) {
            this.icon = iconDown;
        }

        this.isShowing = false;

        btn.on('click', () => this.toggle());

        this.initAutohide();
    }

    contains(target) {
        if (target == this.wrap) {
            return true;
        }

        if (this.wrap.contains(target)) {
            return true;
        }

        if (target == this.btn) {
            return true;
        }

        if (this.btn.contains(target)) {
            return true;
        }

        return false;
    }

    show() {
        if (currentZdd) {
            currentZdd.hide();
        }
        currentZdd = this;

        this.wrap.show();
        this.wrap.animateCss('fadeIn');
        if (this.icon) {
            this.iconFade('icon-down', 'icon-up');
        }
        this.isShowing = true;
        this.resetPos();

    }

    hide() {
        this.wrap.hide();
        if (this.icon) {
            this.iconFade('icon-up', 'icon-down');
        }
        this.isShowing = false;
        currentZdd = null;
    }

    toggle() {
        if (this.isShowing) {
            this.hide();
            return;
        }

        this.show();
    }

    resetPos() {
        let top = this.btn.offsetTop + this.btn.offsetHeight;
        let left = this.btn.offsetLeft - this.wrap.offsetWidth / 2 + 16;

        this.wrap.style.top = top + 'px';
        this.wrap.style.left = left + 'px';
        if (this.wrap.hasClass('center')) {
            this.wrap.style.marginLeft = -this.btn.offsetWidth / 2 + 'px';
        } else {
            this.wrap.style.marginLeft = ((this.btn.offsetWidth - this.wrap.offsetWidth) / 2) + 'px';
        }
    }

    initAutohide() {
    }

    iconFade(current, next) {
        this.icon.removeClass(current);
        this.icon.addClass(next);
        this.icon.animateCss('fadeIn');
    }
}

export {Zdropdown};
