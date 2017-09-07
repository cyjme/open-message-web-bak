import {toFormData} from './../../fun/form/toFormData.js';

class Request {
    /*
    construct () {
    }
    */
    getXhr () {
        if (window.XMLHttpRequest) {
            this.xhr = new XMLHttpRequest();
        } else if (window.ActiveXObject) {
            try {
                this.xhr = new window.ActiveXObject("Msxml2.XMLHTTP");
            } catch (e) {
                this.xhr = new window.ActiveXObject("Microsoft.XMLHTTP");
            }
        }

        return this.xhr;
    }

    ajax (opts) {
        return new Promise((resolve, reject) => {
            let method = (opts.method || 'get').toUpperCase(),
                async = opts.async === false ? false : true,
                url = opts.url || '',
                dataType = opts.dataType || 'html',
                xhr = this.getXhr();

            if (opts.withCredentials) {
                xhr.withCredentials = true;
            }

            xhr.onload = () => {
                if (xhr.status === 200) {
                    if (dataType === 'json') {
                        try {
                            resolve(JSON.parse(xhr.responseText));
                        } catch (err) {
                            reject({status: xhr.status, err: err, responseText: `<pre>${xhr.responseText}</pre>`});
                        }
                    } else {
                        resolve(xhr.responseText);
                    }
                } else {
                    reject({status: xhr.status, responseText: xhr.responseText});
                }
            };

            xhr.onerror = () => {
                reject({status: xhr.status, responseText: xhr.responseText});
            };

            xhr.open(method, url, async);

            if (opts.send) {
                xhr.send(toFormData(opts.send));
                return;
            }

            xhr.send();
        });
    }

    buildQuery(args) {
        var k, arr = [];
        for (k in args) {
            if (args.hasOwnProperty(k)) {
                arr.push(k + '=' + args[k]);
            }
        }
        return arr.join('&');
    }

    getJson(url, send) {
        url += '?' + this.buildQuery(send);

        return this.ajax(
            {
                method: 'get',
                url: url,
                dataType: 'json',
                withCredentials: true
            }
        );
    }

    postJson(url, send) {
        return this.ajax(
            {
                method: 'post',
                url: url,
                dataType: 'json',
                send: send,
                withCredentials: true
            }
        );
    }
}

export {Request};
