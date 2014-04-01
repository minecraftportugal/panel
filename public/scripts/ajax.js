function AjaxIndicator() {

  if ( arguments.callee._singletonInstance )
    return arguments.callee._singletonInstance;
  arguments.callee._singletonInstance = this;

  this.indicate = function() {
    $("div#ajax-indicator").removeClass("ajax-loadings ajax-error").addClass("ajax-loading");
  }

  this.disappear = function() {
    setTimeout(function() {
        $("div#ajax-indicator").removeClass("ajax-loading ajax-error ajax-loading-https");
    }, 10);
    
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

$(function() {

  $(document).on('click', 'div.widget a:not(.noajax)', function(event) {
    var href = $(this).attr("href");
    var container = $(this).closest("div.widget-body");
    
    $.ajax({
      url : href,
      type : "GET",
      success : function(data) {
        container.html(data);
      }
    })
    event.preventDefault(); 
  });

  $(document).on('submit', 'form:not(.noajax)', function(event) {
    var action = $(this).attr("action");
    var type = $(this).attr("method");
    var data = $(this).serialize();
    var container = $(this).closest("div.widget-body");
    $.ajax({
      url : action,
      data : data,
      type : type,
      success : function(data) {
        container.html(data);
      }
    })
    event.preventDefault();
  });

});
