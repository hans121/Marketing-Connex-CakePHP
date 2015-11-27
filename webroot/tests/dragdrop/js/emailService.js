beeFreeApp.service('emailService', [
    '$http', '$q', 'webMethodService', 'REST_MESSAGES_RESOURCE_ENDPOINT', function($http, $q, webMethodService, REST_MESSAGES_RESOURCE_ENDPOINT) {
        return {
            sendEmail: function(userId, emailTo, subject, message) {

                var deferred = $q.defer();

                if (REST_MESSAGES_RESOURCE_ENDPOINT) {
                    var email = {
                        to: emailTo,
                        subject: subject,
                        message: message
                    };
                    //console.log('Send email via API -> ', email);

                    var formData = new FormData();
                    for (var key in email) {
                        formData.append(key, email[key]);
                    }

                    $http({
                            method: 'POST',
                            url: REST_MESSAGES_RESOURCE_ENDPOINT,
                            data: formData,
                            headers: {
                                'Content-type': 'multipart/form-data'
                            }
                        }).success(function(data) {
                            deferred.resolve(data);
                        })
                        .error(function(err) {
                            deferred.reject(err);
                        });
                } else {
                    webMethodService.callWebMethod({ 'userId': userId, 'recipients': emailTo, 'subject': subject, 'message': message }, '/WebMethods/BeeFree.asmx/SendEmail',
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