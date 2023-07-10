export function setCookie(name,value,expire) {
    const d = new Date();
    let checkValue = getCookie(name);
    if(checkValue === null){
        d.setTime(d.getTime() + (+expire*24*60*60*1000));
        let expires = "expires=" + d.toUTCString();
        document.cookie = name + "=" + value + ";" + expires + ";path=/";
    }
}

export function getCookie(cname) {
    let result = null;
    let name = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');
    for(let i = 0; i < ca.length; i++) {
        let c = ca[i].trim();
        if (c.indexOf(name) === 0) {
            result =  c.substring(name.length, c.length);
        }
    }
    return result;
}

export function removeCookie(cname){
    document.cookie = cname + "=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;";
}
