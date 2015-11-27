beeFreeApp.service('beeService', ['localStorageService', function(localStorageService) {
  return {
      saveFileLocally: function (fileName, content) {
      saveAs(
        new Blob([content], {type: 'text/plain;charset=utf-8'}),
        fileName
      );
    },

      downloadFileLocally: function (uri, name) {
        window.location = uri;
      },

    saveToLocalStorage: function(key, value) {
      var base64 = Base64.encode(value);
      localStorageService.set(key, base64);
    },

    getFromLocalStorage: function(key) {
      var val = localStorageService.get(key);
      if(val)
        return Base64.decode( val );
      return null;
    }
  }
}]);