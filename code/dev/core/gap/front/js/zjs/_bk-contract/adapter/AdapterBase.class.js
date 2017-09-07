import {Request} from './../../http/request/Request.class.js';
//import {pageAttr} from './../../html/page-attr';

class AdapterBase {
    constructor() {
        this.request = new Request();
    }

    send(apiUrl, obj) {
        let send = this.filter(obj);
        //send.token = pageAttr('token');

        return this.request.postJson(
            apiUrl,
            send
        );
    }

    filter(obj) {
        return obj;
    }
}

export {AdapterBase};
