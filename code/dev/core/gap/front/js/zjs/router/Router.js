class Router {
    constructor(siteConfig, routeConfig) {
        this.siteConfig = siteConfig;
        this.routeConfig = routeConfig;
    }

    routeUrl(key) {
        let route = this.routeConfig[key];
        let site = route.site;
        let siteUrl = this.siteConfig[site];
        return `//${siteUrl}/${route.pattern}`;
    }
}

export {Router};
