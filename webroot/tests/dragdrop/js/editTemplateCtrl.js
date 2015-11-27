beeFreeApp.controller('editTemplateCtrl', [
    '$scope', '$state', '$stateParams', '$modal', '$filter', 'CLIENT_ID', 'CLIENT_SECRET', 'authenticationService', 'beeService', 'beeFactory', 'emailService', 'templateService', 'alertService', function ($scope, $state, $stateParams, $modal, $filter, CLIENT_ID, CLIENT_SECRET, authenticationService, beeService, beeFactory, emailService, templateService, alertService) {

        var uuid;

        function getBeeConfig(uuid) {
            return {
                //whitelabel: true, // Not implemented yet
                //mode: 'full', // 'full|advanced|basic|view', // Not implemented yet
                //theme: 'classic', //'dark|light|classic', // Not implemented yet
                //showToolbar: true, // Not implemented yet
                //toolbar: ['Save', 'Save As Template', 'Send', 'Preview'], // Not implemented yet
                uid: uuid,
                container: 'bee-plugin-container',
                autosave: 15, // in seconds
                language: 'en-US', // if language is not supported the defualt language is loaded (value must have two-letter ISO 639-1 code format)
                // specialLinks: specialLinks, // Array of Object to specify special links
                // mergeTags: mergeTags, // Array of Object to specify special merge Tags
                // mergeContents: mergeContents, // Array of Object to specify merge Content
                // preventClose: false, // true|false - if true an alert is shown before borowser closure

                onSave: function(jsonFile, htmlFile) {
                    /* Implement function for save */
                    templateService.downloadTemplate(uuid, jsonFile)
                        .then(function (url) {
                            startLocalSaving(jsonFile, null, url.d, uuid + '.zip');
                        }, function (err) {
                            alertService.error('An error occurred saving email');
                        });
                },
                onSaveAsTemplate: function(jsonFile) {
                    /* Implement function for save as template */
                    startLocalSaving(jsonFile);
                },
                onAutoSave: function(jsonFile) {
                    /* Implement function for auto save */
                    if (jsonFile) {
                        var page = addPagePropertyToJsonTemplate(jsonFile);

                        var stringifiedPage = JSON.stringify(page);
                        beeService.saveToLocalStorage('templateSaved', stringifiedPage);
                        beeService.saveToLocalStorage('templateSavedTS', new Date().getTime().toString());
                    }
                },
                onSend: function(htmlFile) {
                    /* Implement function to send message */
                    authenticationService.getRecaptchaGoogleKey()
                        .then(function(key) {
                                var modalInstance = $modal.open({
                                    templateUrl: 'components/sendEmailView.html',
                                    controller: 'sendEmailCtrl',
                                    size: 'lg',
                                    backdrop: 'static',
                                    resolve: {
                                        emailInitialParams: function() {
                                            return $scope.emailInitialParams = {
                                                emailTo: '',
                                                subject: '',
                                                html: htmlFile,
                                                uuid: uuid,
                                                recaptchaKey: key.d
                                            }
                                        }
                                    }
                                });

                                modalInstance.result.then(function(emailParams) {
                                    // Email sent
                                }, function() {
                                    // Cancelled
                                });
                            }, function(err) {
                                alertService.error('An error occured retreiving security key');
                            }
                        );
                },
                onError: function(errorMessage) {
                    /* Implement error message */
                    console.log('beeCtrl -> onError', errorMessage);
                    for (var errmsg in errorMessage) {
                        alertService.error(errmsg + ' -> ' + errorMessage[errmsg]);
                    }
                }
            };
        };

        function startLocalSaving(jsonFile, htmlFile, downloadUrl, downloadFileName) {
            var data = {
                json: null,
                html: null,
                download: {
                    url: null,
                    fileName: null
                }
            }

            if (jsonFile) {

                var page = addPagePropertyToJsonTemplate(jsonFile);

                var stringifiedPage = JSON.stringify(page);
                beeService.saveToLocalStorage('templateSaved', stringifiedPage);
                beeService.saveToLocalStorage('templateSavedTS', new Date().getTime().toString());

                data.json = page;
            }

            if (htmlFile) {
                data.html = htmlFile;
            }

            if (downloadUrl) {
                data.download.url = downloadUrl;
                if(downloadFileName)
                    data.download.fileName = downloadFileName;
                else
                    data.download.fileName = 'download.txt';
            }

            $state.get('downloadTemplate').data = data;
            var templateId = beeService.getFromLocalStorage('templateSavedId');
            $state.go('downloadTemplate', { templateId: templateId });
        }

        function addPagePropertyToJsonTemplate(jsonTemplate) {
            var page = JSON.parse(jsonTemplate);

            if (page.hasOwnProperty('page') == false) {
                page = { "page": page };
            }

            return page;
        }

        function removePagePropertyFromJsonTemplate(jsonTemplate) {
            var page = JSON.parse(jsonTemplate);

            if (page.hasOwnProperty('page') == true) {
                page = page.page;
            }

            return page;
        }

        function startBeePlugin(token, guid, template) {
            if ($stateParams.isTemplateLoadedFromLocalStorage === 'true') {
                var ticks = beeService.getFromLocalStorage('templateSavedTS');
                alertService.info('Loaded template saved in date ' + $filter('date')(ticks, 'd MMMM yyyy, HH:mm:ss')); //'yyyy-MM-dd HH:mm:ss'
            } else {
                beeService.saveToLocalStorage('templateSaved', JSON.stringify(template));
                beeService.saveToLocalStorage('templateSavedId', $stateParams.templateId);
                beeService.saveToLocalStorage('templateSavedTS', new Date().getTime().toString());
            }

            beeFactory.createAndStart(token, getBeeConfig(guid), template);
        }

        $scope.beeInit = function() {

            var templateData = $state.get('editTemplate').data;

            authenticationService
                .getToken(CLIENT_ID, CLIENT_SECRET)
                .then(function(authenticationDataJson) {
                    var authenticationData = angular.fromJson(authenticationDataJson.d);

                    uuid = beeService.getFromLocalStorage('user-uuid');
                    if (uuid == null) {
                        authenticationService
                            .generateGuid()
                            .then(function(guid) {
                                uuid = guid.d;
                                beeService.saveToLocalStorage('user-uuid', uuid);

                                startBeePlugin(authenticationData, uuid, templateData);
                            }, function(err) {
                                alertService.error('An error occurred generating unique identifier');
                            });
                    } else {
                        startBeePlugin(authenticationData, uuid, templateData);
                    }
                }, function(errData) {
                    alertService.error('An error occurred retrieving token');
                });
        };

        $scope.backToWelcome = function() {
            $state.go('welcome');
        }
    }
]);