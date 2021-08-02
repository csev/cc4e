#include <stdio.h>
#include <stdlib.h>
#include <string.h>

int main()
{
        printf("Here we go\n");
        while(1)
        {
                void *m = malloc(1024*1024);
                memset(m,0,1024*1024);
        }
        return 0;
}

