export function type(obj) {
    if (obj === null) {
        throw 'null';
    }
    if (obj === undefined) {
        throw 'undefined';
    }
    return Object.prototype.toString.call(obj).slice(8, -1).toLowerCase();
}
