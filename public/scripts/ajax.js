function AjaxIndicator() {

  if ( arguments.callee._singletonInstance )
    return arguments.callee._singletonInstance;
  arguments.callee._singletonInstance = this;

  this.indicate = function() {
    $("div#ajax-indicator").removeClass("ajax-loadings ajax-error").addClass("ajax-loading");
  }

  this.disappear = function() {
    setTimeout(function() {
        $("div#ajax-indicator").removeClass("ajax-loading ajax-error ajax-loading-httops");
    }, 1000);
    
  }
}

var ajaxIndicator = new AjaxIndicator();
$.ajaxSetup({
  beforeSend: function() {
    ajaxIndicator.indicate();
  },
  complete: function() {
    ajaxIndicator.disappear();
  },
  type: "GET"
});