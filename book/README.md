
TODO
----

Switch all variables mentioned in the narrative to back-quote (markdown style).

Enclose all reserved words like `if`, `for`, `while`, `int`, `float`, etc. in back-quotes.

At times K&R use italics in pseudo-code - remove the italics and just leave
this as indented pre-formatted text
without styling.

All references to other chapters should be turned into links like

    [Chapter 2](chap02.md)

Extract all complete code sequences (with and without a main) and place in the `code`
folder in a file named:

    c_123_01.c

Where '123' is the original page number and '01' is the position within page in case there is more than
one code sequence on a page.  These will likely need some `#include` lines 
in the code - we add these and include them in the book.  Things need to
compile when copy and pasted from the book.

Add the compilation instructions to the `code/unit.sh` so they are test compiled.  Eventually this
will have sample inputs and outputs so as to be a real live compile and run unit test.

Then remove the code from the markdown file and replace it with a line that looks like:

    [comment]: <> (code c_123_01.c)

The code in these files will only show up when viewed through PHP - it won't show up on github.

Short fragments that won't compile that are being described can be left in as indented pre-formatted text.


Scanning Details
----------------

Scanned June 2021 - Charles Severance

Epson WS-200
* Two-sided scan color
* Automatig adjustments
* Scanned to JPG at 400DPI

OCR using Epson Scan to Word

Unbold everything in the Word doc before converting to Markdown

Convert to Markdown using online:

https://word2md.com/

Produce the `orig` markdown then run the 

clean.py code to fix things that just come out weird and produce the .md file that is
the basis for hand-edited book files.

