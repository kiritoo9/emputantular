/**
 * Empu - Core
 * ------------
 * 
 * @package EmpuCoreJs
 * @version 2.0.0
 * @author jonsnow
*/

import * as component from './component.js'

class EmpuCore {

    constructor(root_element) {
        this.root_element = root_element
    }
    
    empuRouteHandler(route = '/') {
        while(this.root_element.firstChild) {
            this.root_element.lastChild.remove()
        }

        /**
         * Clear DOM
         * Push State
         * Load html by route --> append to root_element
        */

        document.title = route
        window.history.pushState({state: 1}, "Detail Page" , route);
        this.empuLoadHandler(route)
    }

    init() {
        document.querySelectorAll("a").forEach(anchor => {
            const route = anchor.getAttribute('empu-route')
            if(route !== undefined && route) {
                anchor.style.cursor = 'pointer'
                anchor.addEventListener("click", () => this.empuRouteHandler(route))
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
        var req = await this.empuXHRCall("GET", path)
        this.root_element.innerHTML = req
        this.init()
    }

}

const core = new EmpuCore(document.getElementById("emputantular-rootapp"))
core.init()