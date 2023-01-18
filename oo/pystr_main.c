#include <stdio.h>
#include "pystr.c"

int main(void)
{
    printf("Testing pystr class\n");
    struct pystr * x = pystr_new();
    pystr_dump(x);
    pystr_append(x, 'H');
    pystr_dump(x);
    pystr_appends(x, "ello world");
    pystr_dump(x);
    pystr_del(x);
}

