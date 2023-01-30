#include <stdio.h>
#include <stdlib.h>
#include <string.h>

#define MAXLINE 1000

struct lnode {
    char *text;
    struct lnode *prev;
    struct lnode *next;
};

int main()
{
  struct lnode *head = NULL;
  struct lnode *tail = NULL;
  struct lnode *current;
  char line[MAXLINE];

  while(fgets(line, MAXLINE, stdin) != NULL) {
      char *save = (char *) malloc(strlen(line)+1);
      strcpy(save, line);

      struct lnode *new = (struct lnode *) malloc(sizeof(struct lnode));
      if ( tail != NULL ) tail->next = new;
      new->text = save;
      new->next = NULL;
      new->prev = tail;
      tail = new;

      if ( head == NULL ) head = new;
  }

  for (current = tail; current != NULL; current = current->prev ) {
      printf("%s", current->text);
  }

}
