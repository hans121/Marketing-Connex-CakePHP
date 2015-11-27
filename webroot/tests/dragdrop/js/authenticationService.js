beeFreeApp.service('authenticationService', [
    '$http', '$q', 'webMethodService', 'OAUTH_ENDPOINT', 'OAUTH_SAFE_ENDPOINT', function($http, $q, webMethodService, OAUTH_ENDPOINT, OAUTH_SAFE_ENDPOINT) {
        return {
            getRecaptchaGoogleKey: function () {
                var deferred = $q.defer();

                webMethodService.callWebMethod(null, '/WebMethods/BeeFree.asmx/GetRecaptchaGoogleKey',
                        function (response) {
                            deferred.resolve(response);
                        }, function (err) {
                            deferred.reject(err);
                        });

                return deferred.promise;
            },

            generateGuid: function () {
                var deferred = $q.defer();

                webMethodService.callWebMethod(null, '/WebMethods/BeeFree.asmx/GenerateGuid',
                        function (response) {
                            deferred.resolve(response);
                        }, function (err) {
                            deferred.reject(err);
                        });

                return deferred.promise;
            },

            getToken: function(clientId, clientSecret) {

                var deferred = $q.defer();

                if (OAUTH_ENDPOINT && clientId && clientSecret) {
                    // console.log('AUTHENTICATION WITH CLIENT ID AND CLIENTSECRET');

                    return $http({
                        method: 'POST',
                        url: OAUTH_ENDPOINT,
                        data: 'grant_type=password&client_id=' + clientId + '&client_secret=' + clientSecret,
                        headers: {
                            'Content-type': 'application/x-www-form-urlencoded'
                        }
                    }).success(function(authenticationData, status, headers, config) {
                        deferred.resolve(authenticationData);
                    }).error(function (err, status, headers, config) {
                        deferred.reject(err);
                    });
                } else if (OAUTH_SAFE_ENDPOINT) {
                    // console.log('CLIENT SAFE AUTHENTICATION');

                    return $http({
                        method: 'POST',
                        url: OAUTH_SAFE_ENDPOINT,
                        headers: {
                            'Content-type': 'application/x-www-form-urlencoded'
                        }
                    }).success(function(authenticationData, status, headers, config) {
                        deferred.resolve(authenticationData);
                    }).error(function (err, status, headers, config) {
                        deferred.reject(err);
                    });
                } else {
                    //console.log('AUTHENTICATION VIA WEBMETHOD');

                    webMethodService.callWebMethod(null, '/WebMethods/BeeFree.asmx/GetToken',
                        function(response) {
                            deferred.resolve(response);
                        }, function(err) {
                            deferred.reject(err);
                        });
                }

                return deferred.promise;
            }
        }
    }
]);