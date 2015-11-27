beeFreeApp.service('webMethodService', [
	'$rootScope', '$q', '$http', function ($rootScope, $q, $http) {

		var cache = {};
		var numberOfCalls = 0;

		this.callWebMethod = function (objParam, url, funcSuccess, funcError, notifyCumulativeBeginAndEnd, useCache) {
		    function callFunction(fn, response) {
		        //it doesn't call 'fn' if null or undefined
		        if (fn) { fn(response); }
		    }

		    var deferred = $q.defer();

		    var dataJson = "";
		    if (objParam) {
		        dataJson = JSON.stringify(objParam);
		    }

		    var cacheKey = url + " " + dataJson;

		    if (typeof (useCache) === 'undefined') {
		        useCache = false;
		    }

		    var doCall = true;
		    var objCache = cache[cacheKey];

		    if (useCache) {
		        if (!objCache) {
		            objCache = { response: null, isError: false, success: [], error: [], deferred: deferred };
		            cache[cacheKey] = objCache;

		            objCache.success.push(funcSuccess);
		            objCache.error.push(funcError);
		        }
		        else {
		            deferred = objCache.deferred;
		            doCall = false;

		            if (objCache.response != null) {
		                if (objCache.isError) {
		                    callFunction(funcError, objCache.response);
		                }
		                else {
		                    callFunction(funcSuccess, objCache.response);
		                }
		            }
		            else {
		                objCache.success.push(funcSuccess);
		                objCache.error.push(funcError);
		            }
		        }
		    }

		    if (doCall) {
		        var isShowLoading = typeof (notifyCumulativeBeginAndEnd) === 'undefined' ? true : notifyCumulativeBeginAndEnd;

		        if (isShowLoading) {
		            numberOfCalls = numberOfCalls + 1;
		            if (numberOfCalls == 1) {
		                $rootScope.$broadcast('callWebMethodCumulativeBeginEvent');
		            }
		        }

		        $http({
		            method: "POST",
		            url: url,
		            data: dataJson,
		            processData: false,
		            cache: false,
		            contentType: "application/json; charset=utf-8",
		            dataType: "json",
		            headers: {
		                'Content-Type': 'application/json; charset=utf-8'
		            }
		        })
				.success(function (response) {
					if (objCache) { //even if 'useCache' is false objCache.response is updated (if objCache exists)
					    objCache.response = response;
					    objCache.isError = false;
					}

					if (useCache) {
					    $.each(objCache.success, function () {
					        callFunction(this, response);
					    });
					}
					else {
					    callFunction(funcSuccess, response);
					}
				})
				.error(function (response) {
					if (objCache) { //even if 'useCache' is false objCache.response is updated (if objCache exists)
					    objCache.response = response;
					    objCache.isError = true;
					}

					if (useCache) {
					    $.each(objCache.error, function () {
					        callFunction(this, response);
					    });
					}
					else {
					    callFunction(funcError, response);
					}
				})['finally'](function () {
					if (objCache) { //remove all functions queues to avoid multiple executions
					    objCache.success = [];
					    objCache.error = [];
					}

					if (isShowLoading) {
					    numberOfCalls = numberOfCalls - 1;
					    if (numberOfCalls == 0) {
					        $rootScope.$broadcast('callWebMethodCumulativeEndEvent', false);
					    }
					}
					deferred.resolve();
				});
		    }

		    return deferred.promise;
		}
	}
]);