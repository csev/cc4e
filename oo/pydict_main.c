#include <stdio.h>
#include "pydict.c"

int main(void)
{
    printf("Testing pydict class\n");
    struct pydict * lst = pydict_new();
    pydict_put(lst, "z", "Catch phrase");
    pydict_put(lst, "z", "Z value");
    pydict_put(lst, "y", "Y value");
    pydict_put(lst, "x", "X value");
    pydict_put(lst, "a", "A value");

    printf("z=%s\n", pydict_get(lst, "z"));
    printf("x=%s\n", pydict_get(lst, "x"));

    printf("\nDump\n");
    for(struct dnode * cur = pydict_start(lst); cur != NULL ; cur = pydict_next(lst) ) {
        printf("%s=%s\n", cur->key, cur->value);
    }

    pydict_vsort(lst);
    printf("\nSorted by value\n");
    for(struct dnode * cur = pydict_start(lst); cur != NULL ; cur = pydict_next(lst) ) {
        printf("%s=%s\n", cur->key, cur->value);
    }

    pydict_del(lst);
}

