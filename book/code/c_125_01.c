#include <stdio.h>
#define MAXWORD 20

main() /* count C keywords */

{
    int n, t;
    char word[MAXWORD];

    while ((t = getword (word, MAXWORD)) != EOF)
        if (t == LETTER)
            if ((n = binary(word, keytab, NKEYS)) >= 0)
                keytab[n].keycount++;

    for (n = 0; n < NKEYS; n++)
        if (keytab[n].keycount > 0)
            printf("%4d %s\n",keytab[n].keycount, keytab[n].keyword);

}

binary(word, tab, n) /* find word in tab[0]...tab[n-1] */
char *word;
struct key tab[];
int n;
{
    int low, high, mid, cond;

    low = 0;
    high = n - 1;
    while (low <= high) {
        mid = (low+high) / 2;
        if ((cond = strcmp(word, tab[mid].keyword)) < 0)
            high = mid - 1;
        else if (cond > 0)
            low = mid + 1;
        else
            return (mid);
    }
    return(-1);
}
