#include <stdio.h>
#include <sys/types.h> /* typedefs */
#include <sys/stat.h>  /* structure returned by stat */
#define BUFSIZE 256

main(argc, argv) /* fsize: print file sizes */
char *argv[];
{
  char buf[BUFSIZE];

  if (argc == 1) { /* default: current directory */
    strcpy(buf, ".");
    fsize(buf);
  } else
    while (--argc > 0) {
      strcpy(buf, *++argv);
      fsize(buf);
    }
}
