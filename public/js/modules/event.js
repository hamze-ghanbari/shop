import {checkBlacklist, maxLength, required} from "./validation";

export function formEvent(selector, event, handler){
    document.querySelector(selector).addEventListener(event, () => {
        handler();
        // if (event.target.tagName === 'INPUT' && event.target.type === 'text') {

        // }
    });
}
