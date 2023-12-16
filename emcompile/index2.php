<!DOCTYPE html>
<?php
require_once("../config.php");
?>
<head>
</head>
</body>
<h1>EmScriptEn Compiler</h1>

<form method="post" id="form">
Secret: <input type="password" name="secret"><br/>
<textarea name="code" style="width:95%;" rows="5">
#include <stdio.h>

main() { printf("hello world\n"); }
</textarea>
<br/>
<input type="submit" onclick="runCompile(); return false;">
</form>


    <div class="spinner" id='spinner'></div>
    <div class="emscripten" id="status">Ready...</div>

    <div class="emscripten">
      <progress value="0" max="100" id="progress" hidden=1></progress>
    </div>

<textarea id="output" rows="8"></textarea>

<script type='text/javascript'>

Module = 42;
function runCompile() {

    // Rebuild every time
      var statusElement = document.getElementById('status');
      var progressElement = document.getElementById('progress');
      var spinnerElement = document.getElementById('spinner');
      Module = {
        print: (function() {
          var element = document.getElementById('output');
          if (element) element.value = ''; // clear browser cache
          return function(text) {
            if (arguments.length > 1) text = Array.prototype.slice.call(arguments).join(' ');
            // These replacements are necessary if you render to raw HTML
            //text = text.replace(/&/g, "&amp;");
            //text = text.replace(/</g, "&lt;");
            //text = text.replace(/>/g, "&gt;");
            //text = text.replace('\n', '<br>', 'g');
            console.log(text);
            if (element) {
              element.value += text + "\n";
              element.scrollTop = element.scrollHeight; // focus on bottom
            }
          };
        })(),
        setStatus: (text) => {
          if (!Module.setStatus.last) Module.setStatus.last = { time: Date.now(), text: '' };
          if (text === Module.setStatus.last.text) return;
          var m = text.match(/([^(]+)\((\d+(\.\d+)?)\/(\d+)\)/);
          var now = Date.now();
          if (m && now - Module.setStatus.last.time < 30) return; // if this is a progress update, skip it if too soon
          Module.setStatus.last.time = now;
          Module.setStatus.last.text = text;
          if (m) {
            text = m[1];
            progressElement.value = parseInt(m[2])*100;
            progressElement.max = parseInt(m[4])*100;
            progressElement.hidden = false;
            spinnerElement.hidden = false;
          } else {
            progressElement.value = null;
            progressElement.max = null;
            progressElement.hidden = true;
            if (!text) spinnerElement.style.display = 'none';
          }
          statusElement.innerHTML = text;
        },
        totalDependencies: 0,
        monitorRunDependencies: (left) => {
          this.totalDependencies = Math.max(this.totalDependencies, left);
          Module.setStatus(left ? 'Preparing... (' + (this.totalDependencies-left) + '/' + this.totalDependencies + ')' : 'All downloads complete.');
        }
      };
      Module.setStatus('Ready...');
      window.onerror = (event) => {
        // TODO: do not warn on ok events like simulating an infinite loop or exitStatus
        Module.setStatus('Exception thrown, see JavaScript console');
        spinnerElement.style.display = 'none';
        Module.setStatus = (text) => {
          if (text) console.error('[post-exception status] ' + text);
        };
      };

fetch("compile.php", {
    credentials: "same-origin",
    mode: "same-origin",
    method: "post",
    // body: formData
    body: new FormData(document.getElementById("form"))
})
    .then(resp => {
        if (resp.status === 200) {
            return resp.json()
        } else {
            console.log("Status: " + resp.status)
            return Promise.reject("server")
        }
    })
    .then(dataJson => {
        console.log(dataJson);
        var element = document.getElementById("executable");
        if ( element ) element.parentNode.removeChild(element);

        var executable = dataJson.js;
        console.log(`Javascript: ${executable}`);
        const s = document.createElement('script');

        s.setAttribute('id', 'executable');
        s.setAttribute('src', executable);
        document.body.appendChild(s);
    })
    .catch(err => {
        if (err === "server") return
        console.log(err)
    })

}
</script>


</body>
</html>
