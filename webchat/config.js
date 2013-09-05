/*
 * lightIRC configuration
 * www.lightIRC.com
 *
 * You can add or change these parameters to customize lightIRC.
 * Please see the full parameters list at http://redmine.lightirc.com/projects/lightirc/wiki/Customization_parameters
 *
 */

var params = {};

/* Change these parameters */
params.host                         = "irc.ptnet.org";
params.port                         = 6667;
params.policyPort                   = 843;

/* Language for the user interface. Currently available translations: ar, bd, bg, br, cz, da, de, el, en, es, et, fi, fr, hu, hr, id, it, ja, nl, no, pl, pt, ro, ru, sl, sq, sr_cyr, sr_lat, sv, th, tr, uk */
params.language                     = "en";

/* Relative or absolute URL to a lightIRC CSS file.
 * The use of styles only works when you upload lightIRC to your webspace.
 * Example: css/lightblue.css 
 */
params.styleURL                     = "css/transparent.css";

/* Nick to be used. A % character will be replaced by a random number */
//params.nick                         = "minecraft_%";

/* Channel to be joined after connecting. Multiple channels can be added like this: #lightIRC,#test,#help */
params.autojoin                     = "#minecraft";
/* Commands to be executed after connecting. E.g.: /mode %nick% +x */
params.perform                      = "";

/* Whether the server window (and button) should be shown */
params.showServerWindow             = true;

/* Show a popup to enter a nickname */
params.showNickSelection            = true;
/* Adds a password field to the nick selection box */
params.showIdentifySelection        = true;

/* Show button to register a nickname */
params.showRegisterNicknameButton   = true;
/* Show button to register a channel */
params.showRegisterChannelButton    = true;

/* Opens new queries in background when set to true */
params.showNewQueriesInBackground   = true;
params.enableQueries   = true;

/* Position of the navigation container (where channel and query buttons appear). Valid values: left, right, top, bottom */
params.navigationPosition           = "bottom";

params.showNickPrefixes = true;

/* See more parameters at http://redmine.lightirc.com/projects/lightirc/wiki/Customization_parameters */
//params.charset 			   = "ISO-8859-15";
params.charset 			   = "utf-8";
params.fontSize			   = "12";
params.showTimestamps = "true";
params.timestampFormat = "[hh:mm]";
params.showEmoticonsButton 	   = false;
params.showRichTextControls 	   = false;
params.showMenuButton 	   	   = true;
params.showSubmitButton 	   = true;
params.showChannelHeader	   = true;
params.soundAlerts 		   = false;
params.channelHeader 	 	   = "%channel% (%users% online) %topic%";
params.realname 		   = "Minecraftia.PT Webuser - #minecraft";
params.quitMessage		   = "see you, webcraftia :(";
params.nickPrefix 		   = "";
params.nickPostfix		   = ": ";
params.rememberNickname		   = true;
params.showServerWindow		   = true;
params.emoticonList 		   = "";
params.userListWidth		   = "150";
params.blockedCommands		   = "";
params.showNavigation		   = true;

params.identifyCommand = "NickServ login %nick% %pass%";

params.loopServerCommands = false; 
/* Use this method to send a command to lightIRC with JavaScript */
function sendCommand(command) {
  swfobject.getObjectById('lightIRC').sendCommand(command);
}

/* Use this method to send a message to the active chatwindow */
function sendMessageToActiveWindow(message) {
  swfobject.getObjectById('lightIRC').sendMessageToActiveWindow(message);
}

/* Use this method to set a random text input content in the active window */
function setTextInputContent(content) {
  swfobject.getObjectById('lightIRC').setTextInputContent(content);
}

/* This method gets called if you click on a nick in the chat area */
function onChatAreaClick(nick, ident, realname) {
  //alert("onChatAreaClick: "+nick);
}

/* This method gets called if you use the parameter contextMenuExternalEvent */
function onContextMenuSelect(type, nick, ident, realname) {
  //alert("onContextMenuSelect: "+nick+" for type "+type);
}

/* */
/* This method gets called if you use the parameter loopServerCommands */
/* */
function onServerCommand(command) {
  if (command.substring(0,4) != "PING") {
    chatHilight(command);
  }
  return command.replace(/:MemoServ!suporte@PTnet.org PRIVMSG/, ":MemoServ!suporte@PTnet.org NOTICE");
}

window.onbeforeunload = function() {
  swfobject.getObjectById('lightIRC').sendQuit();
}

/* This loop escapes % signs in parameters. You should not change it */
for(var key in params) {
  params[key] = params[key].toString().replace(/%/g, "%25");
}
