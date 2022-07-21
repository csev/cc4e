/* Constants and types included from above */

#define _BUFSIZE 512
#define _NFILE 20 /* #files that can be handled */

typedef struct _iobuf {
  char *_ptr;     /* next character position */
  int _cnt;       /* number of characters left */
  char *_base;    /* location of buffer */
  int _flag;      /* mode of file access */
  int _fd;        /* file descriptor */
} FILE;

#define stdin (&_iob[0])
#define stdout (&_iob[1])
#define stderr (&_iob[2])

#define _READ 01    /* file open for reading */
#define _WRITE 02   /* file open for writing */
#define _UNBUF 04   /* file is unbuffered */
#define _BIGBUF 010 /* big buffer allocated */
#define _EOF 020  /* EOF has occurred on this file */
#define _ERR 040  /* error has occurred on this file */
#define NULL 0
#define EOF (-1)

#define getc(p) (--(p)->_cnt >= 0 \
              ? *(p)->_ptr++ & 0377 : _fillbuf(p))
#define getchar() getc(stdin)

#define putc(x,p) (--(p)->_cnt >= 0 \
              ? *(p)->_ptr++ = (x) : _flushbuf((x),p))
#define putchar(x) putc(x,stdout)

FILE _iob[_NFILE] = {
    { NULL, 0, NULL, _READ, 0 }, /* stdin */
    { NULL, 0, NULL, _WRITE, 1 }, /* stdout */
    { NULL, 0, NULL, _WRITE | _UNBUF, 2 } /* stderr */
};

/* Beginning of the sample code on page 165 */

#define PMODE 0644 /* R/W for owner; R for others */

FILE *fopen(name, mode) /* open file, return file ptr */
register char *name, *mode;
{
  register int fd;
  register FILE *fp;

  if (*mode != 'r' && *mode != 'w' && *mode != 'a') {
    fprintf(stderr, "illegal mode %s opening %s\n",mode, name);
    exit(1);
  }
  for (fp = _iob; fp < _iob + _NFILE; fp++)
    if ((fp->_flag & (_READ | _WRITE)) == 0)
      break; /* found free slot */
  if (fp >= _iob + _NFILE) /* no free slots */
    return(NULL);

  if (*mode == 'w') /* access file */
    fd = creat(name, PMODE);
  else if (*mode == 'a') {
    if ((fd = open(name, 1)) == -1)
      fd = creat(name, PMODE);
    lseek(fd, 0L, 2);
  } else
    fd = open (name, 0);
  if (fd == -1) /* couldn't access name */
    return(NULL);
  fp->_fd = fd;
  fp->_cnt = 0;
  fp->_base = NULL;
  fp->_flag &= ~( _READ | _WRITE);
  fp->_flag |= (*mode == 'r') ? _READ : _WRITE;
  return(fp);
}

/* Sample code from page 168, merged for compilation */

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

