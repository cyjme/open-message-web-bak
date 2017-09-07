class Request {
    construct () {
    }

    getXhr () {
        /*
        if (this.xhr) {
            return this.xhr;
        }
        */

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

    ajax (opts, fn) {
        let method = (opts.method || 'get').toUpperCase(),
            async = opts.async === false ? false : true,
            url = opts.url || '',
            dataType = opts.dataType || 'html',
            xhr = this.getXhr();

        if (opts.withCredentials) {
            xhr.withCredentials = true;
        }

        xhr.onload = () => {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    if (dataType === 'json') {
                        fn.call(this, null, JSON.parse(xhr.responseText));
                    } else {
                        fn.call(this, null, xhr.responseText);
                    }
                    return;
                }

                fn.call(this, {status: xhr.status});
            }
        };

        xhr.onerror = () => {
            fn.call(this, {msg: 'error'});
        };

        xhr.open(method, url, async);

        if (opts.data) {
            xhr.send(opts.data);
        } else {
            xhr.send();
        }
    }

    getJson(url, fn) {
        this.ajax(
            {
                method: 'get',
                url: url,
                dataType: 'json'
            },
            fn
        );
    }

    postJson(url, data, fn) {
        this.ajax(
            {
                method: 'post',
                url: url,
                dataType: 'json',
                data: data,
                withCredentials: true
            },
            fn
        );
    }
}

export {Request};
