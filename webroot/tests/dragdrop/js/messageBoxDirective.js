beeFreeApp.directive('messagebox', function () {

  var instanceCtrl = ['$scope', '$modalInstance', 'modalParams', function ($scope, $modalInstance, modalParams) {

    $scope.header = modalParams.header;
    $scope.body = modalParams.body;
    $scope.footer = modalParams.footer;
    $scope.hasHtmlHeader = modalParams.hasHtmlHeader;
    $scope.hasHtmlBody = modalParams.hasHtmlBody;
    $scope.hasHtmlFooter = modalParams.hasHtmlFooter;
    $scope.hasHeader = modalParams.hasHeader;
    $scope.hasBody = modalParams.hasBody;
    $scope.hasFooter = modalParams.hasFooter;
    $scope.id = 'msgbox_' + modalParams.id;
    $scope.type = modalParams.type

    $scope.getHeaderTemplateUrl = function() {
      return modalParams.headerTemplateUrl;
    }

    $scope.getBodyTemplateUrl = function() {
      return modalParams.bodyTemplateUrl;
    }

    $scope.getFooterTemplateUrl = function() {
      return modalParams.footerTemplateUrl;
    }

    $scope.ok = function () {
      $modalInstance.close();
    };

    $scope.cancel = function () {
      $modalInstance.dismiss('cancel');
    };
  }]

  var modalDirectiveCtrl = ['$scope', '$modal', function($scope, $modal) {

    function checkIfEmpty(val) {
      if(val) {
        return true;
      }
      else {
        return false;
      }
    }

    $scope.show = function() {

      var size = 'lg';
      if($scope.size) {
        size = $scope.size;
      }

      var type = 'info';
      if($scope.type) {
        type = $scope.type;
      }

      var modalInstance = $modal.open({
        templateUrl: 'components/messageBoxTemplateView.html',
        controller: instanceCtrl,
        size: size,
        resolve: {
          modalParams: function() {
            return $scope.modalParams = {
              'hasHeader': checkIfEmpty($scope.headerTemplateUrl) || checkIfEmpty($scope.header),
              'hasHtmlHeader': checkIfEmpty($scope.headerTemplateUrl),
              'header': $scope.header,
              'headerTemplateUrl': $scope.headerTemplateUrl,
              'hasBody': checkIfEmpty($scope.bodyTemplateUrl) || checkIfEmpty($scope.body),
              'hasHtmlBody': checkIfEmpty($scope.bodyTemplateUrl),
              'body': $scope.body,
              'bodyTemplateUrl': $scope.bodyTemplateUrl,
              'hasFooter': checkIfEmpty($scope.footerTemplateUrl) || checkIfEmpty($scope.footer),
              'hasHtmlFooter': checkIfEmpty($scope.footerTemplateUrl),
              'footer': $scope.footer,
              'footerTemplateUrl': $scope.footerTemplateUrl,
              'id': $scope.id,
              'type': type
            }
          }
        }
      });
    }
  }];

  return {
    restrict: 'E',
    replace: true,
    transclude: true,
    templateUrl: 'components/messageBoxView.html',
    scope: {
      id: '@id',
      header: '@header',
      body: '@body',
      footer: '@footer',
      headerTemplateUrl: '@headerTemplateUrl',
      bodyTemplateUrl: '@bodyTemplateUrl',
      footerTemplateUrl: '@footerTemplateUrl',
      type: '@type',
      size: '@size'
    },
    controller: modalDirectiveCtrl
  };
});