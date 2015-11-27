beeFreeApp.controller('welcomeCtrl', [
    '$scope', '$state', '$q', '$filter', 'templateService', 'beeService', 'alertService', function($scope, $state, $q, $filter, templateService, beeService, alertService) {

        // PRIVATE VARIABLES
        var templateSaved = null;


        // PRIVATE FUNCTIONS
        function checkTemplateIntoLocalStorage() {
            var autoSavedJson = beeService.getFromLocalStorage('templateSaved');

            if (autoSavedJson != null) {
                templateSaved = $.parseJSON(autoSavedJson);
                $scope.hasTemplateSaved = true;
            }
        }

        function loadTemplates() {
            templateService
                .getTemplates()
                .then(function (templatesData) {
                    var templates = angular.fromJson(templatesData.d).templates;
                    $scope.templatesGroup = templates;
                },
                    function(data, status, headers, config) {
                        alertService.error('An error occurred retriving the list of templates');
                    });
        }

        // SCOPED VARIABLES
        $scope.hasTemplateSaved = false;
        $scope.templatesGroup = [];


        // SCOPED FUNCTIONS
        $scope.initTemplate = function () {
            $scope.selectedGroup = '1';
            $scope.group1Status = 'active';
            $scope.group2Status = 'notactive';
            $q.all(
                loadTemplates(),
                checkTemplateIntoLocalStorage()
            );
        };

        $scope.templateSelected = function(templateId) {
            templateService
                .getTemplate(templateId)
                .then(function(templateDataJson) {
                    $state.get('editTemplate').data = angular.fromJson(templateDataJson.d);;
                    $state.go('editTemplate', { templateId: templateId, isTemplateLoadedFromLocalStorage: 'false' });
                }, function(data, status, headers, config) {
                    alertService.error('An error occurred retriving the template ' + templateId);
                });
        }

        $scope.continueEditingYourLastMessage = function() {
            $state.get('editTemplate').data = templateSaved;
            var templateId = beeService.getFromLocalStorage('templateSavedId');
            $state.go('editTemplate', { templateId: templateId, isTemplateLoadedFromLocalStorage: 'true' });
        }

        $scope.onGroupSelected = function(group) {
            $scope.selectedGroup = group;
            if (group == '1') {
                $scope.group1Status = 'active';
                $scope.group2Status = 'notactive';
            }

            if (group == '2') {
                $scope.group1Status = 'notactive';
                $scope.group2Status = 'active';
            }
        }
    }
]);