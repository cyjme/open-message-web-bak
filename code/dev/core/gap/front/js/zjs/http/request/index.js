import {Request} from './Request.js';

let request = {
    ajax: (opts, fn) => (new Request()).ajax(opts, fn),
    getJson: (url, send, fn) => (new Request()).getJson(url, send, fn),
    postJson: (url, send, fn) => (new Request()).postJson(url, send, fn)
};

export {request};
