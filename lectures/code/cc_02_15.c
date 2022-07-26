#include <stdio.h>
#include <string.h>
#include <stdlib.h>
int main() {
    char first[100], second[100], *concat;
    int needed;
    printf("Enter two strings\n");
    scanf("%100s", first);
    scanf("%100s", second);
    needed = strlen(first)+3+strlen(second)+1;
    printf("We need %d characters\n",needed);
    concat = (char *) calloc(needed, sizeof(char));
    strcpy(concat, first);
    strcat(concat, " & ");
    strcat(concat, second);
    printf("%s\n", concat);
}


