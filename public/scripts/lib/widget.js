function Widget(options) {

  this.options = {
    'url' : '/colorbars',
    'title' : 'Title',
    'useIframe' : false,
    'alwaysCreate' : false,
    'css' : {
      'normal' : {
        'top': '100px',
        'left': '100px',
        'width' : '500px',
        'height' : '500px',
        'min-width' : '200px',
        'min-height' : '200px',
        'max-width' : null, //'700px',
        'max-height' : null //'700px' 
      },
      'docked' : {
        'position' : 'relative',
        'width':'100%',
        'top':'0px',
        'left':'0px',
        'bottom':'0px',
        'right' : '0px'
      },
      'moveable' : {
        'position' : 'absolute',
        'width' : '300px',
        'height' : '600px',
        'top' : '40px',
        'right' : '0px'
      }
    }
  }

  $.extend(this.options, options);

  this.id = "widget-" + this.options.name;
  this.selector = "div#widget-" + this.options.name;

  this.buttonId = "button-widget-" + this.options.name;
  this.buttonSelector = "div#button-widget-" + this.options.name;


  if (Widget.counter === undefined) {
    Widget.counter = 1;
  } else {
    Widget.counter += 1;
  }
  
  var existing = null;
  if (Widget.widgets === undefined) {
    Widget.widgets = [];
  } else {
    var widgetInstance = this;
    $.each(Widget.widgets, function(n, e) {
      if (e.options.name == widgetInstance.options.name) {
        existing = e;
      }
    });
  }

  if (existing == null) {
    this.widget = this;
    Widget.widgets.push(this);
    this._init();
    this._load();
  } else if (this.options.alwaysCreate) {
    this.widget = this;
    Widget.widgets.push(this);
    this._init();
    this._load();
  } else {

  }

}

Widget.prototype._init = function() {

  var widget = $("div#html-templates div#widget-template > div").clone();
  var button = $("div#html-templates div#widget-button-template > div").clone();

  this.widget = widget;
  this.button = button;

  $(widget).attr("id", this.id);
  $(widget).find("div.widget-title").html(this.options.title);
  $(widget).appendTo("div#widget-container");

  $(button).attr("id", this.buttonId);
  $(button).html(this.options.title);
  $(button).appendTo("div#widget-button-container");
  
  $(this.selector).css(this.options.css.normal);

  var widgetInstance = this;

  $(this.selector).draggable({

    addClasses: false,
    cancel: ".nointeraction",
    handle: "div.widget-drag",
    snap: true,
    snapMode: "outer",
    containment: $("div#widget-container"),
    start: function(event, ui) {
      $("iframe").css('pointer-events', 'none');
    },

    stop: function(event, ui) {
      $("iframe").css('pointer-events', 'auto');
    }

  });

  $(this.selector).resizable({ 

    iframeFix: true,
    addClasses: false,
    cancel: ".nointeraction",
    handle: "div.widget-drag",
    snap: true,
    snapMode: "outer",
    start: function(event, ui) {
      $("iframe").css('pointer-events', 'none');
    },

    stop: function(event, ui) {
      $("iframe").css('pointer-events', 'auto');
    }

  });

  $(this.selector).find("div.widget-dock").click(function() {
    widgetInstance.dock();
  });

  $(this.selector).find("div.widget-minimize").click(function() {
    widgetInstance.minimize();
  });

  $(this.buttonSelector).click(function() {
    widgetInstance.toggle();
  });


  $(this.selector).find("div.widget-drag").mousedown(function() {
    widgetInstance.bringTop();
  });

  $(this.selector).mousedown(function() {
    widgetInstance.bringTop();
  });

}

Widget.prototype._load = function() {
  if (this.options.useIframe == true) {
    this.iframeId = this.id + '-iframe';
    var jq_tag = $("<iframe></iframe>");
    jq_tag.attr("id", this.iframeId) ;
    jq_tag.attr("src", this.options.url) ;
    $(this.selector).find("div.widget-body").append(jq_tag);
    $(this.selector).addClass("widget-iframe");
  } else {
    var widgetInstance = this;
    $.ajax({
      url: widgetInstance.options.url,
      success: function(response) {
        $(widgetInstance.selector).find("div.widget-body").html(response);
      }
    });
    $(this.selector).find("div.widget-body").addClass("widget-ajax");
  }
}

Widget.prototype.bringTop = function() {
  var max_z = 0;
  $(Widget.widgets).each(function(n, e) {
    var z = parseInt($(e.selector).css("z-index"));
    if (z > max_z)
      max_z = z;
  });
  $(this.selector).css("z-index", max_z + 1);
}

Widget.prototype.toggle = function() {
  if ($(this.buttonSelector).hasClass("minimized")) {
    this.maximize();
  } else {
    this.minimize();
  }
}

Widget.prototype.maximize = function() {
  $(this.selector).show();
  $(this.buttonSelector).removeClass("minimized");
  this.bringTop();
  // var widgetInstance = this;
  // $(widgetInstance.selector).animate({
  //   opacity : 1,
  //   width: 0,
  //   left : $($(widgetInstance).buttonSelector).css("left"),
  //   top : "-=100"
  // }, {
  //   duration : 400,
  //   easing: "swing",
  //   complete : function() {
  //     $(widgetInstance.selector).show();
  //     $(widgetInstance.buttonSelector).removeClass("minimized");
  //     this.bringTop();
  //   }
  // });
}

Widget.prototype.minimize = function () {
  $(this.selector).hide();
  $(this.buttonSelector).addClass("minimized");
  // var widgetInstance = this;
  // $(widgetInstance.selector).animate({
  //   opacity : 0,
  //   width: 0,
  //   left : $($(widgetInstance).buttonSelector).css("left"),
  //   top : "+=100"
  // }, {
  //   duration : 400,
  //   easing: "swing",
  //   complete : function() {
  //     $(widgetInstance.selector).hide();
  //     $(widgetInstance.buttonSelector).addClass("minimized");
  //   }
  // });

}


Widget.prototype.dock = function() {
  $(this.selector).css(this.options.css.docked);
}

$(document).on("click", "[data-widget-action]", function() {
  var action = $(this).data("widget-action");
  var name = $(this).data("widget-name");
  var href = $(this).attr("href");
  switch (action) {

    case "open":
      var createdWidget = new Widget({'name' : name, 'url' : href, 'title' : name});
      break;

    case "open-copy":
      var createdWidget = new Widget({'name' : name, 'url' : href, 'title' : name});
      break;

    default:
      break;

  }

  return false;
});