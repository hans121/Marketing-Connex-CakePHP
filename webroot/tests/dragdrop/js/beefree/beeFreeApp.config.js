beeFreeApp.config(function($stateProvider, $urlRouterProvider, localStorageServiceProvider) {
  //
  // For any unmatched url, redirect to /state1
  // $urlRouterProvider.otherwise("/");
  //
  // Now set up the states
  $stateProvider
  .state('welcome', {
    views: {
      'mainContent': {
        templateUrl: "components/welcomeView.html"
      },
      'footer': {
        templateUrl: "components/footerView.html"
      }
    },
    controller: 'Client/app/components/welcome/welcomeCtrl'
  })
  .state('editTemplate', {
    views: {
      'mainContent' : {
        templateUrl: "components/editTemplateView.html"
      },
      'footer' : {
        templateUrl: "components/backFooterView.html"
      }
    },
    controller: 'Client/app/components/ediTemplate/editTemplateCtrl',
    params: { 'templateId': undefined, 'isTemplateLoadedFromLocalStorage': undefined },
    data: { 'template': undefined }
  })
  .state('downloadTemplate', {
    views: {
      'mainContent': {
        templateUrl: "components/downloadTemplateView.html"
      },
      'footer': {
        templateUrl: "components/footerView.html"
      }
    },
    controller: 'Client/app/components/downloadTemplate/downloadTemplateCtrl',
    params: { 'templateId': undefined },
    data: { 'template': undefined }
  });

  // setStorageType [localStorage, sessionStorage]
  // setNotify = setItem [bool], removeItem [bool]
  localStorageServiceProvider
  .setPrefix('beeFreePluginPlaygroundApp')
  .setStorageType('localStorage')
  .setNotify(false, false)
});

beeFreeApp.run(['$state', function ($state) {
  $state.transitionTo('welcome');
}]);