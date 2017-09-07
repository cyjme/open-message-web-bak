import {trans} from 'zjs/trans';
import {pageAttr} from 'zjs/html/page-attr';

export function elapsed(datetime) {
    let now = pageAttr('now');
    if (!now) {
        throw 'now-time cannot be null';
    }

    let diffSeconds = (new Date(now + 'Z').valueOf() - new Date(datetime + 'Z').valueOf()) / 1000;

    if (diffSeconds > 2678400) {
        return datetime.substr(0, 10);
    }
    if (diffSeconds > 86400 && diffSeconds <= 2678400) {
        return `${trans('days-ago', parseInt(diffSeconds / 86400))}`;
    }
    if (diffSeconds > 3600 && diffSeconds <= 86400) {
        return `${trans('hours-ago', parseInt(diffSeconds / 3600))}`;
    }
    if (diffSeconds > 60 && diffSeconds <= 3600) {
        return `${trans('minutes-ago', parseInt(diffSeconds / 60))}`;
    }
    if (diffSeconds > 1 && diffSeconds <= 60) {
        return `${trans('seconds-ago', parseInt(diffSeconds))}`;
    }
    if (diffSeconds <= 1) {
        return `${trans('just-now')}`;
    }

    return `${trans('unknown')}`;
}