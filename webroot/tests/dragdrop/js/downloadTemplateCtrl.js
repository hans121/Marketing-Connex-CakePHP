beeFreeApp.controller('downloadTemplateCtrl', [
    '$scope', '$state', '$stateParams', 'beeService', function($scope, $state, $stateParams, beeService) {

        // PRIVATE VARIABLES
        var templateJson, templateHtml, templateDownloadUrl, templateDownloadFileName, templateId;


        // PRIVATE FUNCTIONS


        // SCOPED FUNCTIONS
        $scope.initDownloadTemplate = function() {
            var stateData = $state.get('downloadTemplate').data;

            templateJson = stateData.json;
            templateHtml = stateData.html;
            templateDownloadUrl = stateData.download.url;
            templateDownloadFileName = stateData.download.fileName;
            templateId = $stateParams.templateId;

            $scope.downloadTemplate();
        }

        $scope.editYourMessage = function() {
            $state.get('editTemplate').data = templateJson;
            $state.go('editTemplate', { templateId: templateId, isTemplateLoadedFromLocalStorage: 'true' });
        }

        $scope.startNewMessage = function() {
            $state.go('welcome');
        }

        $scope.downloadTemplate = function() {

            if (templateDownloadUrl) {
                beeService.downloadFileLocally(templateDownloadUrl, templateDownloadFileName);
            } else {
                if (templateJson)
                    beeService.saveFileLocally(templateId + '-template.json', JSON.stringify(templateJson));

                if (templateHtml)
                    beeService.saveFileLocally(templateId + '.html', templateHtml);
            }
        }

        $scope.subscribeProAccount = function(result) {
            console.log('subscribeProAccount', result);
        }

        $scope.subscribeBetaAccount = function(result) {
            console.log('subscribeBetaAccount', result);
        }
    }
]);