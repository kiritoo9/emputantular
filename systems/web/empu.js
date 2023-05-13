/**
 * Empu - Core
 * ------------
 * 
 * @package EmpuCoreJs
 * @version 2.0.0
 * @author jonsnow
*/

import * as component from './component.js';

class EmpuCore {

    constructor(root_element) {
        this.root_element = root_element;
        this.preloader_id = "emputantular-preloader";
    }

    __validateParams(url = '') {
        return url += (url.includes('?') ? '&' : '?' ) + `empuui=${true}`;
    }

    empuCookieHandler(name,value,days) {
        var expires = "";
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days*24*60*60*1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + (value || "")  + expires + "; path=/";
    }
    
    empuRouteHandler(route = '/') {
        /**
         * Open preloader
         * Push state
         * Remove all elements
         * Load html by route --> append to root_element
        */

        this.root_element.style.position = 'absolute';
        this.root_element.style.backgroundColor = "rgba(100, 100, 100, 0.4)";

        const __preloader = document.createElement('div');
        __preloader.setAttribute('id', this.preloader_id);
        this.root_element.prepend(__preloader);

        document.title = route;
        window.history.pushState({state: 1}, "Detail Page" , route);
        this.empuCookieHandler("empuui", true, 1);
        this.empuLoadHandler(route);
    }

    init() {
        document.querySelectorAll("a").forEach(anchor => {
            const route = anchor.getAttribute('empu-route');
            if(route !== undefined && route) {
                anchor.style.cursor = 'pointer';
                anchor.addEventListener("click", () => this.empuRouteHandler(route));
            }
        })
    }

    empuXHRCall(method, url) {
        return new Promise(function (resolve, reject) {
            let xhr = new XMLHttpRequest();
            xhr.open(method, url);
            xhr.onload = function () {
                if (this.status >= 200 && this.status < 300) {
                    resolve(xhr.response);
                } else {
                    reject({
                        status: this.status,
                        statusText: xhr.statusText
                    });
                }
            };
            xhr.onerror = function () {
                reject({
                    status: this.status,
                    statusText: xhr.statusText
                });
            };
            xhr.send();
        });
    }

    async empuLoadHandler(path) {
        var req = await this.empuXHRCall("GET", path);
        while(this.root_element.firstChild) {
            this.root_element.lastChild.remove();
        }
        this.root_element.innerHTML = req;
        this.root_element.style.position = 'static';
        this.root_element.style.backgroundColor = "transparent";
        this.init();
    }

}

const core = new EmpuCore(document.getElementById("emputantular-rootapp"));
core.init();