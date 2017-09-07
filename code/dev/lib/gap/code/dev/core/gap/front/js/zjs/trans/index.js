import {pageAttr} from 'zjs/html/page-attr';
import {request} from 'zjs/http/request';

export function trans(str) {

    const transGroup = window.transGroup;
    const localeKey = pageAttr('localeKey');
    const createTransGroup = pageAttr('create-trans-group');

    if (transGroup === undefined) {
        return `:${str}`;
    }

    if (transGroup[str] === undefined) {
        if (arguments.length > 1) {
            for (let i = 1; i < arguments.length; i++) {
                str = str + `-%${i}$s`;
            }
        }

        request.postJson(createTransGroup, {
            key: str,
            group: 'js',
            localeKey: localeKey
        });

        return `:${str}`;
    }

    if (arguments.length > 1) {
        let replaceStr = transGroup[str];

        for (let i = 1; i < arguments.length; i++) {
            replaceStr = replaceStr.replace(`%${i}$s`, arguments[i]);
        }

        return replaceStr;
    }

    return transGroup[str];
}
