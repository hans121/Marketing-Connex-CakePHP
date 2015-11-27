var beeFreeApp = angular.module('beeFreeApp', ['ui.router', 'ui.bootstrap', 'LocalStorageModule', 'vcRecaptcha']);

beeFreeApp.constant('OAUTH_ENDPOINT', '')
    .constant('OAUTH_SAFE_ENDPOINT', '')
    .constant('REST_TEMPLATES_RESOURCE_ENDPOINT', '')
    .constant('REST_MESSAGES_RESOURCE_ENDPOINT', '')
    .constant('RECAPTCHA_KEY', '')
    .constant('REGEX',
    {
        email: /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/i
    })
    .value('CLIENT_ID', '')
    .value('CLIENT_SECRET', '');
