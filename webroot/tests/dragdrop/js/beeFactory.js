beeFreeApp.factory('beeFactory', function() {

  var factory = {};
  var bee = {};

  factory.create = function(token, beeConfig) {
    BeePlugin.create(token, beeConfig, function(beePluginInstance) {
      bee = beePluginInstance;
      bee.start();
    });
  };

  factory.createAndStart = function(token, beeConfig, template) {
    BeePlugin.create(token, beeConfig, function(beePluginInstance) {
      bee = beePluginInstance;
      bee.start(template);
    });
  };

  factory.load = function(template) {
    bee.load(template);
  };

  return factory;
});