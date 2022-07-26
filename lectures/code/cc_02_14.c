#include <stdio.h>
#include <string.h>
#include <ctype.h>
int main() {
    char s1[] = "   Hello   World    ";
    void py_lstrip();
    printf("-%s-\n", s1);
    py_lstrip(s1);
    printf("-%s-\n", s1);
}

void py_lstrip(inp)
    char inp[];
{
    int i, j;
    int found = 0;
    for(i=0, j=0; i<strlen(inp)-1; i++) {
        if ( ! found && isspace(inp[i]) ) continue;
        if ( i == j ) return;
        found = 1;
        inp[j++] = inp[i];
    }
    inp[++j] = '\0';
}
