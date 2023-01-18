#include <stdio.h>
#include "pystr.c"

int main(void)
{
    printf("Testing pystr class\n");
    struct pystr * x = pystr_new();
    x->dump(x);
    x->append(x, 'H');
    x->dump(x);
    x->appends(x, "ello world");
    x->dump(x);
    x->del(x);
}

