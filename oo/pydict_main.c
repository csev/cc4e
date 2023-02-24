#include <stdio.h>
#include "pydict.c"

int main(void)
{
    printf("Testing pydict class\n");
    struct pydict * lst = pydict_new();
    pydict_put(lst, "x", "Hello world");
    pydict_put(lst, "y", "Catch phrase");
    pydict_put(lst, "x", "Brian");
    // printf("Bob? %d\n", pydict_get(lst, "x"));
    // printf("Brian? %d\n", pydict_get(lst, "z"));
    for(struct dnode * cur = pydict_start(lst); cur != NULL ; cur = pydict_next(lst) ) {
        printf("%s=%s\n", cur->key, cur->value);
    }
    pydict_del(lst);
}

