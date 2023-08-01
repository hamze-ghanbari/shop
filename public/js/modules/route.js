export const RouteNames = {
    'roles.create' : 'roles/create',
    'categories.create' : 'products/categories/create',
};
export function getParam(param) {

    let params = new URLSearchParams(location.search);

    if (params.has(param)) {
        return params.get(param);
    } else {
        return '';
    }
}

export function getAllParam() {
    let params = new URLSearchParams(location.search);
    let result = [];

    params.forEach((item, index) => {
        result.push({[index]: item});
    });

    return result;
}

export function setParam(name, value){
    const url = new URL(window.location);
    url.searchParams.set(name, value);
    window.history.pushState({}, '', url);
}

export function getOrigin() {
    return location.origin;
}

export function currentRoute() {
    return location.pathname;
}

export function requestUrl(url){
    return getOrigin() + url;
}

export function getHost() {
    let host = document.URL.split(':').shift();
    if (host === "http") {
        return "http://" + document.domain + ':' + location.port;
    } else if (host === "https") {
        return "https://" + document.domain + ':' + location.port;
    } else {
        return false;
    }
}

export function getRouteByName(name){
    return getOrigin() + '/' + RouteNames[name];
}

