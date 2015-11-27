beeFreeApp.service('templateService', [
    '$http', '$q', 'webMethodService', 'REST_TEMPLATES_RESOURCE_ENDPOINT', function($http, $q, webMethodService, REST_TEMPLATES_RESOURCE_ENDPOINT) {
        return {
            getTemplates: function(group) {

                var deferred = $q.defer();

                if (REST_TEMPLATES_RESOURCE_ENDPOINT) {
                    $http({
                            method: 'GET',
                            url: REST_TEMPLATES_RESOURCE_ENDPOINT
                        }).success(function(data, status, headers, config) {
                            // TODO: è necessario implementare la logica per la suddivisione in gruppi, come implementato nel webmethod
                            deferred.resolve(data);
                        })
                        .error(function(err, status, headers, config) {
                            deferred.reject(err);
                        });
                } else {
                    //'BeeFreeSite.WebMethods.BeeFree.GetTemplates'
                    webMethodService.callWebMethod(null, '/WebMethods/BeeFree.asmx/GetTemplates',
                        function(response) {
                            deferred.resolve(response);
                        }, function(err) {
                            deferred.reject(err);
                        });
                }

                return deferred.promise;
            },

            getTemplate: function(templateId) {
                var deferred = $q.defer();

                if (REST_TEMPLATES_RESOURCE_ENDPOINT) {
                    $http({
                            method: 'GET',
                            url: REST_TEMPLATES_RESOURCE_ENDPOINT + '/' + templateId
                        }).success(function(data, status, headers, config) {
                            deferred.resolve(data);
                        })
                        .error(function(err, status, headers, config) {
                            deferred.reject(err);
                        });
                } else {
                    webMethodService.callWebMethod({ 'templateId': templateId }, '/WebMethods/BeeFree.asmx/GetTemplate',
                        function(response) {
                            deferred.resolve(response);
                        }, function(err) {
                            deferred.reject(err);
                        });
                }

                return deferred.promise;
            },

            downloadTemplate: function(userId, templateJson) {
                var deferred = $q.defer();

                webMethodService.callWebMethod({ 'userId': userId, 'templateJson': templateJson }, '/WebMethods/BeeFree.asmx/DownloadTemplate',
                    function (response) {
                        deferred.resolve(response);
                    }, function (err) {
                        deferred.reject(err);
                    });

                return deferred.promise;
            }
    }
    }
]);