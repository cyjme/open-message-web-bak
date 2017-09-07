export function type(obj) {
    if (obj === null) {
        return 'null';
    }

    if (obj === undefined) {
        return 'undefined';
    }
    return Object.prototype.toString.call(obj).slice(8, -1).toLowerCase();
}
