<h1>Test Harness</h1>
<form method="POST" action="compile.php" target="output">
<input type="submit">
<textarea name="code" style="width:95%;" rows="10">
#include <stdio.h>

main() {
   printf("Hello world\n");
}
</textarea>
<p>Input data (optional)</p>
<textarea name="input" style="width:95%;" rows="5">
</textarea>
<h1>Output</h1>
<iframe name="output" id="output" style="width:95%;height: 500px; border: 1px blue solid">
</iframe>
</form>

