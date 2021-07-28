#include <stdio.h>
#define PMODE 0644 /* R/W for owner; R for others */

FILE *fopen(name, mode) /* open file, return file ptr */
register char *name, *mode;
{
  register int fd;
  register FILE *fp;

  if (*mode != 'r' && *mode != 'w' && *mode != 'a') {
    fprintf(stderr, "illegal mode %s opening %s\n",mode, name);
    exit (1);
  }
  for (fp = _iob; fp < _iob + _NFILE; fp++)
    if ((fp->_flag & (_READ | _WRITE)) == 0)
      break; /* found free slot */
    if (fp >= _iob + _NFILE) /* no free slots */
      return (NULL)

    if (*mode == 'w') /* access file */
      fd = creat(name, PMODE);
    else if (*mode == 'a') {
      if ((fd = open(name, 1)) == -1)
        fd = creat(name, PMODE);
      lseek(fd, OL, 2);
    } else
      fd = open (name, 0);
    if (fd == -1) /* couldn't access name */
      return(NULL);
    fp->_fd = fd;
    fp->_cnt = 0;
    fp->_base = NULL;
    fp->_flag &= -LREAD I _WRITE);
    fp->_flag |= (*mode == 'r') ? _READ : _WRITE;
    return(fp);
}
