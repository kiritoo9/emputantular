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

    __removeLoader(fail = false) {
        document.getElementById(this.preloader_id).remove();
        this.root_element.style.position = 'static';
        this.root_element.style.backgroundColor = "transparent";
        if(!fail) {
            for(let i=0; i<this.__bindedEl.length; ++i) {
                const __v = this.__bindedEl[i];
                __v.el.removeEventListener(__v.event, __v.func);
            }
            this.__bindedEl=[];

            this.init();
        }
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
                    _this.root_element.style.position = 'absolute';
                    _this.root_element.style.backgroundColor = "rgba(100, 100, 100, 0.4)";

                    const __preloader = document.createElement('div');
                    __preloader.setAttribute('id', _this.preloader_id);
                    _this.root_element.prepend(__preloader);

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

    async empuLoadHandler(path) {
        try {
            /** 
             * Push state, update title and url
             * Remove all elements
             * Load html by route --> append to root_element
             * */

            var req = await this.empuXHRCall("GET", path);
            while(this.root_element.firstChild) {
                this.root_element.lastChild.remove();
            }
            this.root_element.innerHTML = req;
            document.title = route;
            window.history.pushState({state: 1}, "Detail Page" , route);
            this.empuCookieHandler("empuui", true, 1);

            this.__removeLoader();
        } catch(err) {
            this.__removeLoader(true);
            alert(`Woooppss page is ${err.statusText}`)
        }
    }

}

const core = new EmpuCore(document.getElementById("emputantular-rootapp"));
core.init();