#include <stdio.h>
#include "pystr.c"
#include "pylist.c"

int main(void)
{
    struct lnode *cur;

    printf("Testing pylist class\n");
    struct pylist * lst = pylist_new();
    pylist_append(lst, "Hello world");
    pylist_append(lst, "Catch phrase");
    pylist_append(lst, "Brian");
    printf("Bob? %d\n", pylist_index(lst, "Bob"));
    printf("Brian? %d\n", pylist_index(lst, "Brian"));
    for(cur = pylist_start(lst); cur != NULL ; cur = pylist_next(lst) ) {
        printf("  %s\n", pystr_str(cur->text));
    }
    pylist_del(lst);
}

