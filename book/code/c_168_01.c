#include <stdio.h>

_fillbuf(fp) /* allocate and fill input buffer */
register FILE *fp;
{
  static char smallbuf[_NFILE]; /* for unbuffered I/O */
  char *calloc();

  if ((fp-> _flag & _READ) == 0 || (fp-> _flag & (_EOF | _ERR)) != 0)
  return (EOF);
  while (fp->_base == NULL) /* find buffer space */
    if (fp->_flag & _UNBUF) /* unbuffered */
      fp->_base = &smallbuf[fp->_fd];
    else if ((fp->_base=calloc(_BUFSIZE, 1)) == NULL)
      fp->_flag |= _UNBUF; /* can't get big buf */
    else
      fp->_flag |= _BIGBUF; /* got big one */
  fp->_ptr = fp->_base;
  fp->_cnt = read(fp->_fd, fp->_ptr,
                  fp->_flag & _UNBUF ? 1 : _BUFSIZE);
  if (--fp->_cnt < 0) {
    if (fp->_cnt == -1)
      fp->_flag |= _EOF;
    else
      fp->_flag |= _ERR;
    fp->_cnt = 0;
    return (EOF);
  }
  return(*fp->_ptr++ & 0377); /* make char positive */
}
