#include <stdlib.h>
#include <string.h>

struct nlist { /* basic table entry */
    char *name;
    char *def;
    struct nlist *next; /* next entry in chain */
};

#define HASHSIZE 100
static struct nlist *hashtab[HASHSIZE]; /* pointer table */

struct nlist *lookup(s) /* look for s in hashtab */
char *s;
{
  struct nlist *np;

  for (np = hashtab[hash(s)]; np != NULL; np = np->next)
    if (strcmp(s, np->name) == 0)
      return(np); /* found it */
  return(NULL); /* not found */
}

struct nlist *install(name, def) /* put (name, def) */
char *name, *def;                /* in hashtab */
{
  struct nlist *np, *lookup();
  char *strsave(), *alloc();
  int hashval;
   if ((np = lookup (name)) == NULL) { /* not found */
    np = (struct nlist *) alloc(sizeof(*np));
    if (np == NULL)
      return(NULL);
    if ((np->name = strsave(name)) == NULL)
      return (NULL);
    hashval = hash(np->name);
    np->next = hashtab[hashval];
    hashtab[hashval] = np;
  } else /* already there */
      free(np->def); /* free previous definition */
  if ((np->def = strsave(def)) == NULL)
    return(NULL);
  return(np);
}


