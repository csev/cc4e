#define _BUFSIZE 512
#define _NFILE 20 /* #files that can be handled */

typedef struct _iobuf {
  char *_ptr;     /* next character position */
  int _cnt;       /* number of characters left */
  char *_base;    /* location of buffer */
  int _flag;      /* mode of file access */
  int _fd;        /* file descriptor */
} FILE;

extern FILE _iob[_NFILE];

#define _READ 01    /* file open for reading */
#define _WRITE 02   /* file open for writing */
#define _UNBUF 04   /* file is unbuffered */
#define _BIGBUF 010 /* big buffer allocated */
#define _EOF 020  /* EOF has occurred on this file */
#define _ERR 040  /* error has occurred on this file */
#define NULL 0
#define EOF (-1)

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
