#include <stdio.h>
#include <string.h>
int main() {
    char s1[] = "   Hello   World    ";
    void py_rstrip();
    py_rstrip(s1);
    printf("-%s-\n", s1);
}

void py_rstrip(inp)
    char inp[];
{   
    int i, j;
    for(i=0, j=0; i<strlen(inp)-1; i++) {
        if ( inp[i] == '\n' || 
             inp[i] == '\t' || inp[i] == ' ' ) {
            /* Whitespace skip  */
        } else {
            j = i; /* last non-blank */
        }
    }
    if ( j+1 < strlen(inp) ) inp[j+1] = '\0';
}
