/**
 * Empu - Core
 * ------------
 * 
 * @package EmpuCoreJs
 * @version 2.0.0
 * @author jonsnow
*/

import * as component from './component.js'

const root_element = document.getElementById("emputantular-rootapp")
function init() {
    function empuRouteHandler(route = '/') {
        while(root_element.firstChild) {
            root_element.lastChild.remove()
        }

        /**
         * Clear DOM
         * Push State
         * Load html by route --> append to root_element
        */

        document.title = route
        window.history.pushState({state: 1}, "Detail Page" , route);
        empuLoadHandler(route)
    }

    document.querySelectorAll("a").forEach(anchor => {
        const route = anchor.getAttribute('empu-route')
        if(route !== undefined && route) {
            anchor.style.cursor = 'pointer'
            anchor.addEventListener("click", () => empuRouteHandler(route))
        }
    })
}

function empuLoadHandler(path) {
    var req = new XMLHttpRequest();
    req.open("GET", path, false);
    req.send(null);
    
    root_element.innerHTML = req.responseText;
    init()
}

init()