var pt = Element.prototype;

pt.hasClass = function (className) {
    let arr;
    if (!className) {
        return false;
    }
    if (this.classList) {
        arr = className.split(' ');
        if (arr.length === 1) {
            return this.classList.contains(className);
        }

        for (let i in arr) {
            if (!this.classList.contains(arr[i])) {
                return false;
            }
        }

        return true;
    } else if (this.className) {
        // todo
        return (new RegExp('(^| )' + className + '( |$)', 'gi')).test(this.className);
    }

    return false;
};
pt.removeClass = function (className) {
    let arr;
    if (this.classList) {
        arr = className.split(' ');
        if (arr.length === 1) {
            this.classList.remove(className);
        } else {
            arr.forEach((item) => this.classList.remove(item));
        }
    } else if (this.className) {
        // todo
        this.className = this.className.replace(new RegExp('(^|\\b)' + className.split(' ').join('|') + '(\\b|$)', 'gi'), ' ');
    }
};
pt.addClass = function (className) {
    let arr;
    if (!className) {
        return;
    }
    if (this.hasClass(className)) {
        return;
    }
    if (this.classList) {
        arr = className.split(' ');
        if (arr.length === 1) {
            this.classList.add(className);
        } else {
            arr.forEach((item)  => this.addClass(item));
        }
    } else {
        if (this.className) {
            this.className += " " + className;
        } else {
            this.className = className;
        }
    }
};
pt.toggleClass = function (className) {
    className.split(' ').forEach((item) => {
        if (this.classList) {
            this.classList.toggle(item);
        } else {
            if (this.hasClass(item)) {
                this.removeClass(item);
            } else {
                this.addClass(item);
            }
        }
    });
};
