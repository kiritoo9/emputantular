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
	 * @var object config
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
            config: {},
        }, l);


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
         * @var integer total_page
         * @var array data
         * */

       	function _createPagination() {

       	}

       	/**
       	 * Search
       	 * ------
       	 * 
       	 * Required data from client
       	 * @var string keywords
       	 * */

       	function _createSearch() {

       	}

       	/**
       	 * Send attributes to server
       	 * --------------
       	 * 
       	 * @var array data
       	 * */

       	function _run() {
       		console.log("run data");
       	}

       	_run();

    }
})(jQuery);