beeFreeApp.service('alertService', function(){
  return {
    error: function(msg) {
      toastr["error"](msg);
    },
    info: function(msg) {
      toastr["info"](msg);
    },
    success: function(msg) {
      toastr["success"](msg);
    },
    warning: function (msg) {
        toastr["warning"](msg);
    }
  }
});