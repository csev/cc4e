#include <stdio.h>
#define MAXWORD 20
#define LETTER 'a'

main() /* word frequency count */
{
  struct tnode *root, *tree();
  char word [MAXWORD];
  int t;

  root = NULL;
  while ((t = get_word(word, MAXWORD)) != EOF)
    if (t == LETTER)
      root = tree(root, word);
  treeprint(root);
}
