beeFreeApp.controller('sendEmailCtrl', [
    '$scope', '$modalInstance', 'vcRecaptchaService', 'emailService', 'alertService', 'REGEX', 'emailInitialParams', function($scope, $modalInstance, vcRecaptchaService, emailService, alertService, REGEX, emailInitialParams) {
        // PRIVATE VARIABLES
        var status = ['send', 'sending', 'sent'];
        var statusLabel = ['Send', 'Sending...', 'Sent!'];
        var succesfullEmailSentParams = {
            emailAddress: '',
            subject: ''
        };


        // PRIVATE FUNCTIONS
        function setStatus(statusIndex) {
            $scope.currentStatus = status[statusIndex];
            $scope.currentStatusLabel = statusLabel[statusIndex];
        }

        function saveSuccesfullEmailSent(emailAddress, subject) {
            succesfullEmailSentParams.emailAddress = emailAddress;
            succesfullEmailSentParams.subject = subject;
        }

        function checkStatus() {
            if (succesfullEmailSentParams.emailAddress == $scope.emailAddress && succesfullEmailSentParams.subject == $scope.subject) {
                setStatus(2);
            } else {
                setStatus(0);
            }
        }


        // SCOPED VARIABLES
        setStatus(0);
        $scope.emailRegex = REGEX.email;
        //$scope.invalidCaptcha = true;
        //$scope.recaptchaKey = emailInitialParams.recaptchaKey;
        $scope.emailAddress = emailInitialParams.emailAddress;
        $scope.subject = emailInitialParams.subject;
        $scope.user = {
            captcharesponse: ''
        };


        // SCOPED FUNCTIONS
        //$scope.onCreate = function(widgetId) {
        //    $scope.invalidCaptcha = false;
        //};

        //$scope.onSuccess = function(response, widgetId) {
        //    $scope.user.captcharesponse = response;
        //    if (response !== null && response !== undefined && response !== '') {
        //        $scope.invalidCaptcha = false;
        //    }
        //};

        //$scope.onExpire = function(widgetId) {
        //};

        $scope.ok = function() {
            //if ($scope.invalidCaptcha == false) {
            if ($scope.currentStatus == status[2]) {
                $modalInstance.close({
                    emailAddress: $scope.emailAddress,
                    subject: $scope.subject
                });
            } else {
                setStatus(1);
                emailService.sendEmail(emailInitialParams.uuid, $scope.emailAddress, $scope.subject, emailInitialParams.html)
                    .then(function(data) {
                        alertService.success('Mail sent succesfully');
                        setStatus(2);
                        saveSuccesfullEmailSent($scope.emailAddress, $scope.subject);
                    }, function(err) {
                        alertService.error('An error occurred sending email');
                        setStatus(0);
                    });
            }
            //} else {
            //    vcRecaptchaService.reload();
            //}
        };

        $scope.cancel = function() {
            $modalInstance.dismiss('cancel');
        };

        $scope.$watch('emailAddress', function (newVal, oldVal) {
            if (succesfullEmailSentParams.emailAddress && succesfullEmailSentParams.subject) {
                checkStatus();
            }
        });

        $scope.$watch('subject', function (newVal, oldVal) {
            if (succesfullEmailSentParams.emailAddress && succesfullEmailSentParams.subject) {
                checkStatus();
            }
        });
    }
]);