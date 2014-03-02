$(function() {
	$.getJSON('/scripts/itemsprite.json', function(sd) {

    /*
     * Items in Player Inventory
     */
    $('span.item').each(function() {
      var EMPTY_ITEM_X = 19;
      var EMPTY_ITEM_Y = 17;

      var d = $(this).attr('data-item').split(' ');
      var enchantments = $(this).attr('data-enchantments').split(' ');

      if (d[0] == "") // empty
      {
        var x=-(EMPTY_ITEM_X)*24;
        var y=-(EMPTY_ITEM_Y)*24;
        $(this).attr('style', 'background-position:'+x+'px '+y+'px');
        return;
      }

      if (enchantments[0] == "")
        enchantments = null;

      var sid = d[0] +"-"+ d[1];
      var amount = d[2];
      var durability = d[3];
      var info = null;
      var title = null;

      if (sid in sd['sprites']) {
        info = sd['sprites'][sid];
      }
      else {
        var pid = d[0] +'-'+ durability;
        if (pid in sd['potions']) {
          info = sd['potions'][pid];
          title = info[1]+'\n'+info[2];
          sid = 'potion-' + info[0];
          if (sid in sd['sprites'])
            info = sd['sprites'][sid];
          else
            info = null;
        }
        else {
          sid = d[0]+'-0';
          if (sid in sd['sprites'])
            info = sd['sprites'][sid];
          else
            info = null;
        }
      }

      if (info) {
        if (info[2] && !title)
          title = info[2];

        var enchanted = false;

        if (enchantments) {
          enchantments.forEach(function(e) {
            e = e.split(':');
            if (e[0] in sd['enchantments']){
              var name = sd['enchantments'][e[0]];
              var l = ['I', 'II', 'III', 'IV', 'V'];
              var level = l[e[1]-1];
              title += "\n"+name+" "+level;
              enchanted = true;
            }
          });
        }
        
        if (enchanted)
          $(this).parent().addClass("enchanted");
        
        if (amount > 1)
          $(this).append('<span class="amount">'+amount+'</span>');

        if (durability > 0 && sid in sd['durabilities'])
        {
          var damage = 100 * (1 - durability / sd['durabilities'][sid])
          var c = Math.floor(damage*2.55);
          $(this).append('<div class="damage"><div style="background:rgb('+(255-c)+','+c+',0);width:'+(damage*0.22)+'px"></div></div>');
        }

        $(this).attr('title', title);

        var x=-(info[0])*24;
        var y=-(info[1])*24;
        $(this).attr('style', 'background-position:'+x+'px '+y+'px');
      }
      else { // empty
        var x=-(EMPTY_ITEM_X)*24;
        var y=-(EMPTY_ITEM_Y)*24;
        $(this).attr('style', 'background-position:'+x+'px '+y+'px');
      }
 
      return;

    });
    
    /*
     * Item Names
     */
    $('span.itemname').each(function() {
      var d = $(this).attr('data-item').split(' ');
      var enchantments = $(this).attr('data-enchantments').split(' ');

      if (enchantments[0] == "")
        enchantments = null;

      var sid = d[0] +"-"+ d[1];
      var amount = d[2];
      var durability = d[3];
      var info = null;
      var title = null;

      if (sid in sd['sprites']) {
        info = sd['sprites'][sid];
      }
      else {
        var pid = d[0] +'-'+ durability;
        if (pid in sd['potions']) {
          info = sd['potions'][pid];
          title = info[1]+'\n'+info[2];
          sid = 'potion-' + info[0];
          if (sid in sd['sprites'])
            info = sd['sprites'][sid];
          else
            info = null;
        }
        else {
          sid = d[0]+'-0';
          if (sid in sd['sprites'])
            info = sd['sprites'][sid];
          else
            info = null;
        }
      }

      if (info) {
        if (info[2] && !title)
          title = info[2];

        var enchanted = false;

        if (enchantments) {
          enchantments.forEach(function(e) {
            e = e.split(':');
            if (e[0] in sd['enchantments']){
              var name = sd['enchantments'][e[0]];
              var l = ['I', 'II', 'III', 'IV', 'V'];
              var level = l[e[1]-1];
              title += "\n"+name+" "+level;
              enchanted = true;
            }
          });
        }
        
        $(this).html(title);
      }

      return;
    });

    $("select#itemid_sel").each(function() {
      var that = this;
      $(that).append($("<option></option>").val("").text("..."));
      $.each(sd["sprites"], function(k, v) {
        if (v[2] != "") {
          $(that).append($("<option></option>").val(k).text(v[2] + " [" + k + "]"));
        }
      });
    });

    $("select#itemid_sel").change(function() {
      var val = $(this).val().split("-");
      var itemid = val[0];
      var itemaux = val[1];

      $("input[name=itemid]").val(itemid);
      $("input[name=itemaux]").val(itemaux);
    });

    $("input[name=itemid], input[name=itemaux]").change(function() {
      $("select#itemid_sel").val("");
    });
  });
});