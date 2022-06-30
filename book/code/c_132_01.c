#include <string.h>

struct tnode { /* the basic node */
    char *word; /* points to the text */
    int count; /* number of occurrences */
    struct tnode *left; /* left child */
    struct tnode *right; /* right child */
};

struct tnode *tree(p, w) /* install w at or below p */
struct tnode *p;
char *w;
{
  struct tnode *talloc();
  char *strsave();
  int cond;

  if (p == NULL) {    /* a new word has arrived */
    p = talloc();     /* make a new node */
    p->word = strsave(w);
    p->count = 1;
    p->left = p->right = NULL;
  } else if ((cond = strcmp(w, p->word)) == 0)
    p->count++;       /* repeated word */
  else if (cond < 0)  /* lower goes into left subtree */
    p->left = tree(p->left, w);
  else        /* greater into right subtree */
    p->right = tree(p->right, w);
  return (p);
}

