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

    init(firstInit = false) {
        if(firstInit) {
            this.handlerRouteHistories(window.location.pathname);
        }

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
                        statusText: xhr.statusText,
                        responseText: xhr.responseText,
                    });
                }
            };
            xhr.onerror = function () {
                reject({
                    status: this.status,
                    statusText: xhr.statusText,
                    responseText: xhr.responseText,
                });
            };
            xhr.send();
        });
    }

    handlerRouteHistories(route, backward) {
        let __histories = window.localStorage.getItem("__empuRouteHistories");
        __histories = __histories ? JSON.parse(__histories) : [];
        if(!backward) {
            __histories.push(route);
        } else if(__histories.length > 0) {
            let __lastItem = (__histories.length-1);
            __histories.splice(__lastItem, 1); // DELETE CURRENT PAGE FROM HISTORIES
            __lastItem = (__histories.length-1); // GET ROUTES BEFORE

            route = __histories[__lastItem] ?? "/";
        }
        window.localStorage.setItem("__empuRouteHistories", JSON.stringify(__histories));

        return route;
    }

    async empuLoadHandler(route = "/", backward = null) {
        try {
            /** 
             * Check backward, if true then remove last route
             * Push state, update title and url
             * Remove all elements
             * Load html by route --> append to root_element
             * */

            this.empuCookieHandler("empuui", true, 1);
            var req = await this.empuXHRCall("GET", route);
            route = this.handlerRouteHistories(route, backward);

            while(this.root_element.firstChild) {
                this.root_element.lastChild.remove();
            }

            let __arrCookies = document.cookie.split(";");
            let __strTitle = __arrCookies.length > 0 ? __arrCookies[0] : null;
            const __cookieTitle = `activeTitle=`;
            if(__strTitle) {
                while (__strTitle.charAt(0) == ' ') { 
                    __strTitle = __strTitle.substring(1,__strTitle.length);
                }
                if (__strTitle.indexOf(__cookieTitle) == 0){
                    __strTitle = __strTitle.substring(__cookieTitle.length,__strTitle.length);
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
            if(err.responseText !== undefined) err_str = err.responseText;
            this.__removeLoader(true);

            let __parser = new DOMParser();
            const errHTML = __parser.parseFromString(err_str, 'text/html');
            const errMain = errHTML.getElementsByClassName("fof");
            if(errMain[0].innerHTML !== undefined) {
                /**
                 * Append error to empuErrorDOM
                 * Bind close button to close error
                 * 
                 * --- Next Version ---
                 * Possibility to trace specific error
                 */

                let __errPoint = `<div 
                    onclick="
                        javascript:(function() { 
                            document.getElementById('empuErrorDom').style.display = 'none' 
                        })()" 
                    id="empuErrorDOMClose">
                        Close[x]
                    </div>`;
                __errPoint += errMain[0].innerHTML;
                var empuErrorDOM = document.getElementById("empuErrorDom");
                empuErrorDOM.innerHTML = __errPoint;
                empuErrorDOM.style.display = "block";
            } else {
                window.alert(`Woooppss something went wrong, but we cannot reach the error, sorry`);
            }
        }
    }

}

/**
 * Initialize DOM Core
 * Binding HashChange in Browser
 * ErrorDomCloseDialog()
 * */

const core = new EmpuCore(document.getElementById("emputantular-rootapp"));
core.init(true);

window.addEventListener('popstate', function(event) {
    core.__openLoader();
    core.empuLoadHandler(null, true);
});