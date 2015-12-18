
var xhr = new XMLHttpRequest(),
    path = "../lib",
    runtimeFilePath = path + "/runtime.js",
    code;

xhr.open("GET", runtimeFilePath, false);
xhr.send(null);
code = xhr.responseText;
code += "\n//# sourceURL=" + runtimeFilePath;
eval(code);

// adapt for out-of-sources run
runtime.currentDirectory = function () {
    return path;
};
runtime.libraryPaths = function () {
    return [path];
};
// load a class to trigger loading the complete lib
runtime.loadClass('odf.OdfContainer');

// flag for telling the editor component that this is run from source
WodoFromSource = true;
