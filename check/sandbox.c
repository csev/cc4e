#include <stdio.h>
#include <fcntl.h>

int cc4e_puts(const char *str)
{
    puts(" | ");
    return puts(str);
}

FILE *cc4e_fopen(const char *filename, const char *mode)
    return fopen(filename, mode);
}
