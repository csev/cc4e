#include <stdio.h>
#include <stdlib.h>
#include <string.h>

#define MAXLINE 1000

struct lnode {
    char *text;
    struct lnode *next;
};

struct list {
  struct lnode *head;
  struct lnode *tail;
};

void list_add(lst, line)
    struct list *lst;
    char *line;
{
      char *save = (char *) malloc(strlen(line)+1);
      strcpy(save, line);
      struct lnode *new = (struct lnode *) malloc(sizeof(struct lnode));
      if ( lst->tail != NULL ) lst->tail->next = new;
      new->text = save;
      new->next = NULL;
      lst->tail = new;

      if ( lst->head == NULL ) lst->head = new;
}

int main()
{
  char line[MAXLINE];
  struct list mylist;
  struct lnode *current;

  mylist.head = NULL;
  mylist.tail = NULL;

  while(fgets(line, MAXLINE, stdin) != NULL) {
      list_add(&mylist, line);
  }

  for (current = mylist.head; current != NULL; current = current->next ) {
      printf("%s", current->text);
  }
}
