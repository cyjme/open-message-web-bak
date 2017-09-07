//import {type} from './../obj/type.js';

import {pageAttr} from './../../html/page-attr';
import {type} from './../type.js';

export function toFormData(data) {
    let fd;

    if (type(data) !== 'formdata') {
        let key;

        fd = new window.FormData();

        for (key in data) {
            if (data.hasOwnProperty(key)) {
                fd.append(key, data[key]);
            }
        }
    } else {
        fd = data;
    }

    fd.append('token', pageAttr('token'));
    // console.warn('chang');
    return fd;

}
