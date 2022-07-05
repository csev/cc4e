#define NULL 0

typedef int ALIGN; /* forces alignment on PDP-11 */

union header { /* free block header */
  struct {
      union header *ptr; /* next free block */
      unsigned size; /* size of this free block */
  } s;
  ALIGN x; /* force alignment of blocks */
};

typedef union header HEADER;

static HEADER base; /* empty list to get started */
static HEADER *allocp = NULL; /* last allocated block */

#define NALLOC 128 /* #units to allocate at once */

static HEADER *morecore(nu) /* ask system for memory */
unsigned nu;
{
  char *sbrk();
  register char *cp;
  register HEADER *up;
  register int rnu;

  rnu = NALLOC * ((nu+NALLOC-1) / NALLOC);
  cp = sbrk (rnu * sizeof(HEADER));
  if ((int)cp == -1) /* no space at all */
    return(NULL);
  up = (HEADER *)cp;
  up->s.size = rnu;
  free ((char *)(up+1));
  return(allocp);
}

char *alloc(nbytes) /* general-purpose storage allocator */
unsigned nbytes;
{
  HEADER *morecore();
  register HEADER *p, *q;
  register int nunits;

  nunits = 1+(nbytes+sizeof(HEADER)-1)/sizeof(HEADER);
  if ((q = allocp) == NULL) { /* no free list yet */
    base.s.ptr = allocp = q = &base;
    base.s.size = 0;
  }
  for (p=q->s.ptr; ; q=p, p=p->s.ptr) {
    if (p->s.size >= nunits) { /* big enough */
      if (p->s.size == nunits) /* exactly */
        q->s.ptr = p->s.ptr;
      else { /* allocate tail end */
        p->s.size -= nunits;
        p += p->s.size;
        p->s.size = nunits;
      }
      allocp = q;
      return((char *)(p+1));
    }
    if (p == allocp) /* wrapped around free list */
      if ((p = morecore(nunits)) == NULL)
        return(NULL); /* none left */
  }
}

free(ap) /* put block ap in free list */
char *ap;
{
  register HEADER *p, *q;

  p = (HEADER *)ap - 1; /* point to header */
  for (q=allocp; !(p > q && p < q->s.ptr); q=q->s.ptr)
    if (q >= q->s.ptr && (p > q || p < q->s.ptr))
      break; /* at one end or other */

  if (p+p->s.size == q->s.ptr) { /* join to upper nbr */
    p->s.size += q->s.ptr->s.size;
    p->s.ptr = q->s.ptr->s.ptr;
  } else
    p->s.ptr = q->s.ptr;
  if (q+q->s.size == p) { /* join to lower nbr */
    q->s.size += p->s.size;
    q->s.ptr = p->s.ptr;
  } else
    q->s.ptr = p;
  allocp = q;
}
