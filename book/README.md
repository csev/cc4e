
TODO
----

Underline the chapter title with '===='.  Underline sub-chapters like "1.10 Scope ..." with "-----".

Bold the "Exercise 1-17" bits.

Switch all variables mentioned in the narrative to back-quote (markdown style).

At times they use italics in pseudo-code - remove the italics and just leafe this as indented pre-formatted text
without styling.

Extract all complete code sequences (with and without a main) and place in the `code`
folder in a file named:

    c_123_01.c

Where '123' is the original page number and '01' is the position within page in case there is more than
one code sequence on a page.

Add the compilation instructions to the `code/unit.sh' so they are test compiled.  Eventually this
will have sample inputs and outputs so as to be a real live compiile and run unit test.

Then remove the code from the markdown file and replace it with a line that looks like:

    [comment]: <> (code c_123_01.c)

This code will only show up when viewed through PHP - it won't show up on github.

Fragments that won't compile that are being described can be left in as indented pre-formatted text.


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

