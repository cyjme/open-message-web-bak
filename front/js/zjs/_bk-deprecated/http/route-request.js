import {Request} from './request.js';

class RouteRequest {
    construct (routeMap, siteMap) {
        this.routeMap = routeMap;
        this.siteMap = siteMap;
        this.request = new Request();
    }

    getJson (routeName, fn) {
        let route = this.routeMap[routeName];
        this.request.getJson(
            `//${this.routeMap[route['site']]['host']}${route['pattern']}`,
            fn
        );
    }

    postJson (routeName, data, fn) {
        let route = this.routeMap[routeName];
        this.request.getJson(
            `//${this.routeMap[route['site']]['host']}${route['pattern']}`,
            data,
            fn
        );
    }
}

export {RouteRequest};
