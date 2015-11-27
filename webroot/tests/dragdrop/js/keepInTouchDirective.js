beeFreeApp.directive('keepintouch', function() {

    var instanceCtrl = [
        '$scope', '$modalInstance', 'webMethodService', 'alertService', 'REGEX', 'modalParams', function ($scope, $modalInstance, webMethodService, alertService, REGEX, modalParams) {

            var status = ['send', 'sending', 'sent'];
            var statusLabel = ['Send', 'Subscribing...', 'Subscribed!'];
            var succesfullSubscriptionEmailSentParams = {
                emailAddress: '',
                name: ''
            };

            function setStatus(statusIndex) {
                $scope.currentStatus = status[statusIndex];
                $scope.currentStatusLabel = statusLabel[statusIndex];
            }

            function saveSuccesfullEmailSent(emailAddress, name) {
                succesfullSubscriptionEmailSentParams.emailAddress = emailAddress;
                succesfullSubscriptionEmailSentParams.name = name;
            }

            function checkStatus() {
                if (succesfullSubscriptionEmailSentParams.emailAddress == $scope.user.email && succesfullSubscriptionEmailSentParams.name == $scope.user.name) {
                    setStatus(2);
                } else {
                    setStatus(0);
                }
            }

            statusLabel[0] = modalParams.formConfirm;
            setStatus(0);
            $scope.emailRegex = REGEX.email;
            $scope.header = modalParams.header;
            $scope.id = 'kit_' + modalParams.id;
            $scope.type = modalParams.type;
            $scope.formTitle = modalParams.formTitle;
            $scope.formDescription = modalParams.formDescription;
            $scope.formConfirm = modalParams.formConfirm;
            
            $scope.showConditionAgreement = modalParams.showConditionAgreement;
            $scope.hasConditionsAccepted = false;

            $scope.user = {
                name: '',
                email: ''
            }

            $scope.getBodyTemplateUrl = function() {
                return modalParams.bodyTemplateUrl;
            }

            $scope.ok = function () {

                if (modalParams.subscriptionGroupId && modalParams.subscriptionListId) {

                    if ($scope.currentStatus == status[2]) {
                        $modalInstance.close($scope.user);
                    } else {
                        setStatus(1);

                        webMethodService.callWebMethod({ 'idGroup': modalParams.subscriptionGroupId, 'idList': modalParams.subscriptionListId, 'email': $scope.user.email, 'name': $scope.user.name }, '/WebMethods/BeeFree.asmx/Subscribe',
                            function(response) {
                                var result = parseInt(response.d);

                                if (result === 0) {
                                    alertService.success('Thanks! A confirmation email is in the way of your inbox');
                                    setStatus(2);
                                    saveSuccesfullEmailSent($scope.user.email, $scope.user.name);
                                } else if (result === 3) {
                                    alertService.info('It seems that your email was previously submited!');
                                    setStatus(0);
                                } else {
                                    alertService.error('Something went wrong. Please retry.');
                                    setStatus(0);
                                }
                            }, function(err) {
                                alertService.error('Something went wrong. Please retry.');
                            });
                    }
                } else {
                    alertService.warning('Something went wrong. Please contact support@beefree.io to solve the issue.');
                }
            };

            $scope.cancel = function() {
                $modalInstance.dismiss('cancel');
            };

            $scope.$watch('user.name', function (newVal, oldVal) {
                if (succesfullSubscriptionEmailSentParams.emailAddress && succesfullSubscriptionEmailSentParams.name) {
                    checkStatus();
                }
            });

            $scope.$watch('user.email', function (newVal, oldVal) {
                if (succesfullSubscriptionEmailSentParams.emailAddress && succesfullSubscriptionEmailSentParams.name) {
                    checkStatus();
                }
            });
        }
    ]

    var keepInTouchDirectiveCtrl = [
        '$scope', '$modal', function($scope, $modal) {

            $scope.show = function() {

                var modalInstance = $modal.open({
                    templateUrl: 'components/keepInTouchTemplateView.html',
                    controller: instanceCtrl,
                    backdrop: 'static',
					windowClass: 'allWidth',
                    resolve: {
                        modalParams: function () {
                            var showConditionAgreement = false;
                            if ($scope.showConditionAgreement) {
                                showConditionAgreement = $scope.showConditionAgreement == 'true';
                            }

                            return $scope.modalParams = {
                                'header': $scope.header,
                                'subscriptionGroupId': $scope.subscriptionGroupId,
                                'subscriptionListId': $scope.subscriptionListId,
                                'showConditionAgreement': showConditionAgreement,
                                'bodyTemplateUrl': $scope.bodyTemplateUrl,
                                'id': $scope.id,
                                'formTitle': $scope.formTitle,
                                'formDescription': $scope.formDescription,
                                'formConfirm': $scope.formConfirm
                            }
                        }
                    }
                });

                modalInstance.result.then(function(result) {
                    //console.log('Success');
                    $scope.onConfirm({ result: result });
                }, function() {
                    //console.log('Keep in touch cancelled');
                });
            }
        }
    ];

    return {
        restrict: 'E',
        replace: true,
        transclude: true,
        templateUrl: 'components/keepInTouchView.html',
        scope: {
            id: '@id',
            header: '@header',
            subscriptionGroupId: '@subscriptionGroupId',
            subscriptionListId: '@subscriptionListId',
            showConditionAgreement: '@showConditionAgreement',
            bodyTemplateUrl: '@bodyTemplateUrl',
            formTitle: '@formTitle',
            formDescription: '@formDescription',
            formConfirm: '@formConfirm',
            onConfirm: '&confirmCallback'
        },
        controller: keepInTouchDirectiveCtrl
    };
});