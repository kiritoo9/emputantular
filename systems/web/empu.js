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

    __bindedEl = [];

    constructor(root_element) {
        this.root_element = root_element;
        this.preloader_id = "emputantular-preloader";
    }

    __validateParams(url = '') {
        return url += (url.includes('?') ? '&' : '?' ) + `empuui=${true}`;
    }

    __openLoader() {
        this.root_element.style.position = 'absolute';
        this.root_element.style.backgroundColor = "rgba(100, 100, 100, 0.4)";

        const __preloader = document.createElement('div');
        __preloader.setAttribute('id', this.preloader_id);
        this.root_element.prepend(__preloader);
    }

    __removeLoader(fail = false) {
        if(!fail) {
            for(let i=0; i<this.__bindedEl.length; ++i) {
                const __v = this.__bindedEl[i];
                __v.el.removeEventListener(__v.event, __v.func);
            }
            this.__bindedEl=[];

            this.init();
        } else {
            document.getElementById(this.preloader_id).remove();
        }

        this.root_element.style.position = 'static';
        this.root_element.style.backgroundColor = "transparent";
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

    init() {
        document.querySelectorAll("a").forEach(anchor => {
            const route = anchor.getAttribute('empu-route');
            if(route !== undefined && route) {
                anchor.style.cursor = 'pointer';

                /**
                 * Open preloader
                 * Call page open handler
                */

                var _this = this;
                function empuRouteHandler() {
                    _this.__openLoader();
                    _this.empuLoadHandler(route);
                }
                anchor.addEventListener("click", empuRouteHandler);
                this.__bindedEl.push({
                    el: anchor,
                    event: "click",
                    func: empuRouteHandler
                });
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

    async empuLoadHandler(route) {
        try {
            /** 
             * Push state, update title and url
             * Remove all elements
             * Load html by route --> append to root_element
             * */

            this.empuCookieHandler("empuui", true, 1);

            var req = await this.empuXHRCall("GET", route);
            while(this.root_element.firstChild) {
                this.root_element.lastChild.remove();
            }

            let __arrCookies = document.cookie.split(";");
            let __strTitle = __arrCookies.length > 0 ? __arrCookies[0] : null;
            const __cookieName = `activeTitle=`;
            if(__strTitle) {
                while (__strTitle.charAt(0) == ' ') { 
                    __strTitle = __strTitle.substring(1,__strTitle.length);
                }
                if (__strTitle.indexOf(__cookieName) == 0){
                    __strTitle = __strTitle.substring(__cookieName.length,__strTitle.length);
                }
            } else {
                __strTitle = "Emputantular";
            }

            document.title = decodeURI(__strTitle);
            window.history.pushState({state: 1}, __strTitle , route);
            this.root_element.innerHTML = req;
            this.__removeLoader();
        } catch(err) {
            let err_str = err;
            if(err.statusText !== undefined) err_str = err.statusText;
            this.__removeLoader(true);
            alert(`Woooppss page is ${err_str}`)
        }
    }

}

/**
 * Initialize DOM Core
 * Binding HashChange in Browser
 * */

const core = new EmpuCore(document.getElementById("emputantular-rootapp"));
core.init();

window.addEventListener('popstate', function(event) {
    core.__openLoader();
    core.empuLoadHandler("/heroes");
});