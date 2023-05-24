/**
 * Empu - Component
 * ------------
 * 
 * Generate pagination, searchbox in serverside
 * Catch data from view and send to controller
 * 
 * @package EmpuTable
 * @version 2.0.0
 * @author jonsnow
*/

"use strict";
(function (a) {

    /**
     * Data Structures
     * --------
     * @var array data
     * @var array columns
     * @var object config
     * @var array skipSort
     * 
     * Inside data
     * @var string type -> fill with "plain" or "element"
     * @var string name -> name will send to server
     * @var string elid -> library will get value from elementId (use it when type is "element")
     * @var any value -> value will send to server (use it when type is "plain")
     * 
     * Inside config
     * @var string url -> target destination to server
     * @var boolean search -> set True to active, default false
     * @var boolean sort -> set True to active, default false
     * @var object paging -> set True to active default false
     * */

    a.fn.empuTable = function (l) {
      const attributes = a.extend({ 
            data: [],
            columns: [],
            config: {
                url: null,
                paging: false,
                search: false,
                sort: false
            },
            skipSort: []
      }, l);

      if(this[0] === undefined) {
        window.alert("Table you defined is not found");
        return;
      }

      /**
        * Define global variable
        * */

        const table_id = this[0].id;
        var table_selected = document.getElementById(table_id);
        const limitAvailable = [5,10,30,50,100];
        var bindingList = [];
        var fetchData = {
            keywords: '',
            current_page: 1,
            clicked_page: 1,
            sort_name: null,
            sort_by: null,
            data_limit: limitAvailable[0]
        }

      /**
         * Search
         * ------
         * 
         * Search will run after user type at least 3 words
         * @var string keywords
         * */

        function _createSearch(el) {
            var searchInput = document.createElement("input");
            searchInput.setAttribute("type", "text");
            searchInput.setAttribute("placeholder", "Type something..");
            const _searchId = `_empuSearchBox-${table_id}`;
            searchInput.setAttribute("id", _searchId);
            el.insertBefore(searchInput, el.firstChild);

            /**
             * Binding Search
             * Insert to bindingList so we can remove it before re-binding!
             * */
            function __bindingSearch(e) {
                if(
                    e.keyCode >= 65 && e.keyCode <= 90
                    || e.keyCode >= 48 && e.keyCode <= 57
                    || e.keyCode === 13 || e.keyCode === 46
                ) {
                    if(this.value.length >= 3) {
                        fetchData.keywords = this.value;
                        _callServer();
                    }
                }
            }
            searchInput.addEventListener("keyup", __bindingSearch);
            bindingList.push({
                el: searchInput,
                event: "keyup",
                func: __bindingSearch
            });
        }

      /**
        * Pagination
        * ----------
        * 
        * Required from client:
        * @var integer limit
        * @var integer page
        * 
        * Response server:
        * @var integer total_all_data
        * @var array data
        * */

        function _createPagination(sortBox, bottomBox) {

        	/**
        	 * Sort Box
        	 * */
            let limitBox = document.createElement("select");
            limitBox.classList.add("_empuSortBoxSelect");
           	for(l in limitAvailable) {
           		let option = new Option(limitAvailable[l], limitAvailable[l]);
           		limitBox.add(option, undefined);
           	}
            sortBox.insertBefore(limitBox, sortBox.firstChild);

            /**
             * Binding sort on change
             * */
            function __bindingSort(e)
            {
            	fetchData.data_limit = parseInt(e.target.value);
            	_callServer();
            }
            sortBox.addEventListener("change", __bindingSort);
            bindingList.push({
                el: sortBox,
                event: "change",
                func: __bindingSort
            });

            /**
             * Pagination Box
             * */
            let pagingBox = document.createElement("div");
            pagingBox.classList.add("_empuPagingBox");
            pagingBox.append(_generatePagingTotal(1));
            bottomBox.insertBefore(pagingBox, bottomBox.firstChild);
        }

        function _generatePagingTotal(total = 1) {
        	let pagingList = document.createElement("ul");

        	let previous = document.createElement("li");
        	previous.innerHTML = "Previous";
        	pagingList.append(previous);

        	for(let i=1; i<=total; ++i) {
        		let steps = document.createElement("li");
        		steps.innerHTML = i;
        		pagingList.append(steps);
        	}

        	let next = document.createElement("li");
        	next.innerHTML = "Next";
        	pagingList.append(next);
        	return pagingList;
        }

        /**
         * Sort
         * ----
         * 
         * When user specifically click header from table
         * The library will send the field_name they clicked and last sort by
         * 
         * @var string field_name
         * */

        function _createSort() {

        }

        /**
         * Binding Actions
         * -----------
         * 
         * Send prepared data to server
         * Use fetch with POST method
         * */
        function _callServer() {
            console.log("calling server with ", fetchData);
        }

        /**
         * Send attributes to server
         * --------------
         * 
         * _create function will also binding action besides generate DOM
         * binding will remove everytime page reload
         * 
         * @var array data
         * */

        function run() {
            if(!attributes.config.url) {
                window.alert("You did not set url target yet!");
                return;
            }

            /**
             * Check total columns with total <th> defined
             * */

            if(table_selected.querySelectorAll("th").length !== attributes.columns.length) {
                window.alert("Total columns you defined is not match with header!");
                return;
            }

            /**
             * Remove existing listener to clear DOM
             * */
            for(bindrow in bindingList) {
                bindingList[bindrow].el.removeEventListener(bindingList[bindrow].event, bindingList[bindrow].func);
            }

            /**
             * Create preparing element for features when active
             * SortBox
             * SearchBox
             * PaginationBox
             * */

            var _empuTableTopBox = document.createElement("div");
            _empuTableTopBox.classList.add("_empuTableTopBox");
            table_selected.before(_empuTableTopBox);

            var _empuTableBottomBox = document.createElement("div");
            _empuTableBottomBox.classList.add("_empuTableBottomBox");
            table_selected.after(_empuTableBottomBox);

            var _empuTableTopBox_sortBox = document.createElement("div");
            _empuTableTopBox_sortBox.classList.add("_empuTableTopBox-sortBox");
            _empuTableTopBox.insertBefore(_empuTableTopBox_sortBox, _empuTableTopBox.firstChild);

            var _empuTableTopBox_searchBox = document.createElement("div");
            _empuTableTopBox_searchBox.classList.add("_empuTableTopBox-searchBox");
            _empuTableTopBox.insertBefore(_empuTableTopBox_searchBox, null);

            /**
             * Generate features
             * */

            if(attributes.config.search) {
                _createSearch(_empuTableTopBox_searchBox);
            }

            if(attributes.config.paging) {
                _createPagination(_empuTableTopBox_sortBox, _empuTableBottomBox);
            }

            if(attributes.config.sort) {
                _createSort(_empuTableTopBox);
            }
        }

        run();
     }
})(jQuery);