import {s} from './../../s';

const pageAttrObj = JSON.parse(s.elem('#page-attr').value);

export function pageAttr(key) {
    return pageAttrObj[key];
}
