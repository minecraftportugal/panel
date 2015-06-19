/* http://stackoverflow.com/questions/1009911/javascript-get-argument-value-and-name-of-passed-variable?lq=1 */

App.Debug = {

};

App.Debug.getParamNames = function(func) {
    var STRIP_COMMENTS = /((\/\/.*$)|(\/\*[\s\S]*?\*\/))/mg;
    var ARGUMENT_NAMES = /([^\s,]+)/g;

    var fnStr = func.toString().replace(STRIP_COMMENTS, '');
    var result = fnStr.slice(fnStr.indexOf('(')+1, fnStr.indexOf(')')).match(ARGUMENT_NAMES);
    if(result === null)
        result = [];

    return result;
};

App.Debug.debugCall = function (args) {

    var callee = arguments.callee.toString();
    console.log(callee)
    callee = callee.substr('function '.length);
    callee = callee.substr(0, callee.indexOf('('));

    console.log("DEBUG " + callee + "(" + args + ")");
};